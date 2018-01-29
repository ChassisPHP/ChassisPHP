<?php

namespace App\Http\Controllers\Backend;

use Lib\Database\Connection;
use Lib\Framework\Http\Controller;
use Lib\Framework\Session;
use Doctrine\ORM\Query;
use Database\Entities\Content;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class ContentController extends Controller
{

    private $connection;
    private $entityManager;
    private $loggedInUser;

    public function __construct()
    {
        // Set up DB connection and entity
        $this->connection = new Connection;
        $this->entityManager = $this->connection->entityManager;
        $this->loggedInUser = Session::get('name');
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
        $loggedInUser = Session::get('name');
               
        return $this->view->render('backend/pages/content.twig.php', array('contents' => $content, 'message' => $message, 'loggedInUser' => $this->loggedInUser));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
     */

    public function create($formVars = null)
    {
        return $this->view->render('backend/pages/contentForm.twig.php', array('formVars' => $formVars));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @return Response
     */

    public function store()
    {
        $formVars = $this->request->getParsedBody();
        $title = $formVars['title'];
        $position = $formVars['position'];
        $slug = $formVars['slug'];
        $body = $formVars['body'];
        $author = $formVars['author'];

        $timestamp = new \DateTime();

        $content = new Content;
        $content->setTitle($title);
        $content->setPosition($position);
        $content->setSlug($slug);
        $content->setBody($body);
        $content->setAuthor($author);
        $content->setPublicationDate($timestamp);

        try {
            $this->entityManager->persist($content);
            $this->entityManager->flush();
            $message['type'] = 'alert-info';
            $message['content'] = "$title content added succesfully";
            return $this->index($message);
        } catch (UniqueConstraintViolationException $e) {
            $message['type'] = 'alert-danger';
            $message['content'] = "Email has already been registered";
            return $this->create($message, $formVars);
        }
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
        $contentEntry = $this->entityManager->find('Database\Entities\Content', $id['ID']);
        return $this->view->render('backend/pages/contentDetails.twig.php', array('entryDetails' => $contentEntry, 'message' => $message, 'loggedInUser' => $this->loggedInUser));
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
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function update($id)
    {
        //
    }
 
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response

    public function destroy($id)
    {
        // remove a user from the DB
        $userRepo = $this->entityManager->getRepository('Database\Entities\User');
        $user = $userRepo->find($id['ID']);
        $name = $user->getName();
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        $message['type'] = 'alert-danger';
        $message['content'] = "User $name deleted succesfully";

        return $this->index($message);
    }*/
}
