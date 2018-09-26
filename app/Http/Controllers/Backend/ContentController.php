<?php

namespace App\Http\Controllers\Backend;

use Lib\Database\Connection;
use Lib\Framework\Http\Controller;
use Lib\Framework\Session;
use Doctrine\ORM\Query;
use Database\Entities\Content;
use Database\Entities\User;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class ContentController extends Controller
{

    private $connection;
    private $entityManager;
    private $loggedInUser;
    private $loggedInUserId;

    public function __construct()
    {
        // Set up DB connection and entity
        $this->connection = new Connection;
        $this->entityManager = $this->connection->entityManager;
        $this->loggedInUser = Session::get('name');
        $this->loggedInUserId = Session::get('user');
    }

    public function addMiddleware()
    {
        // Only allow logged in users
        $this->middlewareQueue->addMiddleware('AuthMiddleware', '\Lib\Framework\Http\Middleware\\');
    }

    public function index($message = null)
    {
        // Display all users from the DB
        $contentRepository = $this->entityManager->getRepository('Database\Entities\Content');
        $content = $contentRepository->findAll();
        return $this->view->render(
            'backend/pages/content.twig.php',
            array(
                'contents' => $content,
                'message' => $message,
                'loggedInUser' => $this->loggedInUser
            )
        );
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
     */

    public function create($formVars = null)
    {
        $formAction = "/backend/content/create";
        $formMethod = "post";
        $author['name'] = $this->loggedInUser;
        $author['id'] = $this->loggedInUserId;

        return $this->view->render(
            'backend/pages/contentForm.twig.php',
            array(
                'formVars' => $formVars,
                'action' => $formAction,
                'method' => $formMethod,
                'loggedInUser' => $this->loggedInUser,
                'author' => $author
            )
        );
    }

    /**
    * Store a newly created resource in storage.
    *
    * @return Response
     */

    public function store()
    {
        $formVars = $this->request->getParsedBody();

        $content = new Content;

        $timestamp = new \DateTime();
        $content->setPublicationDate($timestamp);
        
        $author = $this->entityManager->find('Database\Entities\User', $formVars['author']);
        $content->setAuthor($author);
        $message = $this->hydrateAndPersist($content, $formVars);
        return $this->index($message);
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function select($id, $message = null)
    {
        //
        $content = $this->entityManager->find('Database\Entities\Content', $id['ID']);
        return $this->view->render(
            'backend/pages/contentDetails.twig.php',
            array(
                'content' => $content,
                'message' => $message,
                'loggedInUser' => $this->loggedInUser
            )
        );
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function edit($id)
    {
        //
        $content = $this->entityManager->find('Database\Entities\Content', $id['ID']);
        $contentId = $id['ID'];
        $formAction = "/backend/content/update/$contentId";
        $formMethod = "post";
        $contentAuthor = $this->entityManager->getRepository('Database\Entities\User')->find($content->getAuthor());
        $author['name'] = $contentAuthor->getName();
        $author['id'] = $contentAuthor->getId();
        return $this->view->render(
            'backend/pages/contentForm.twig.php',
            array(
                'contentEntry' => $content,
                'action' => $formAction,
                'method' => $formMethod,
                'loggedInUser' => $this->loggedInUser,
                'author' => $author
            )
        );
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function update($id)
    {
        $content = $this->entityManager->find('Database\Entities\Content', $id['ID']);
    
        $formVars = $this->request->getParsedBody();

        $author = $this->entityManager->find('Database\Entities\User', $formVars['author']);
        $formVars['author'] = $author;
        $updatedBy = $this->entityManager->getRepository('Database\Entities\User')->find($this->loggedInUserId);
        $content->setUpdatedBy($updatedBy);
        
        $this->hydrateAndPersist($content, $formVars);

        return $this->select($id);
    }
 
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($contentId)
    {
        // remove content  from the DB
        $content = $this->entityManager->find('Database\Entities\Content', $contentId['ID']);
        $title = $content->getTitle();
        if (!$title) {
            $title = "untitled content";
        }
        $this->entityManager->remove($content);
        $this->entityManager->flush();

        $message['type'] = 'alert-danger';
        $message['content'] = "Content entry \"$title\" deleted succesfully";

        return $this->index($message);
    }

    /**
    * method to hydrate and persist an entity
    */
    private function hydrateAndPersist($content, $formVars)
    {
        $title = $formVars['title'];
        $position = $formVars['position'];
        $body = $formVars['body'];
        //$author = $formVars['author'];

        $timestamp = new \DateTime();
        $content->setUpdated($timestamp);
        $content->setTitle($title);
        $content->setPosition($position);
        $content->setBody($body);
        //$content->setAuthor($author);

        try {
            $this->entityManager->persist($content);
            $this->entityManager->flush();
            $message['type'] = 'alert-info';
            $message['content'] = "$title content added succesfully";
            return $message;
        } catch (UniqueConstraintViolationException $e) {
            $message['type'] = 'alert-danger';
            $message['content'] = "$title could not be added";
            return $this->create($message, $formVars);
        }
    }
}
