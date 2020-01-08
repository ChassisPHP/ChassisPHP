<?php

namespace App\Http\Controllers\Backend;

use Doctrine\ORM\Query;
use Lib\Framework\Session;
use Database\Entities\User;
use Database\Entities\Album;
use Lib\Database\Connection;
use Lib\Framework\Http\Controller;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class AlbumController extends Controller
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
        // Display all albums from the DB
        $albumRepository = $this->entityManager->getRepository('Database\Entities\Album');
        $albums = $albumRepository->findAll();
        return $this->view->render('backend/pages/albums.twig.php', array(
            'albums' => $albums,
            'message' => $message,
            'loggedInUser' => $this->loggedInUser
        ));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
     */

    public function create($formVars = null)
    {
        $formAction = "/backend/albums/create";
        $formMethod = "post";
        $createdBy['name'] = $this->loggedInUser;
        $createdBy['id'] = $this->loggedInUserId;

        return $this->view->render('backend/pages/albumForm.twig.php', array(
            'formVars' => $formVars,
            'action' => $formAction,
            'method' => $formMethod,
            'loggedInUser' => $this->loggedInUser,
            'createdBy' => $createdBy
        ));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @return Response
     */

    public function store()
    {
        $formVars = $this->request->getParsedBody();

        $album = new Album;

        $timestamp = new \DateTime();
        $album->setCreatedDate($timestamp);

        $createdBy = $this->entityManager->find('Database\Entities\User', $formVars['createdById']);
        $album->setCreatedBy($createdBy);
        $album->setUpdatedBy($createdBy);

        $message = $this->hydrateAndPersist($album, $formVars);
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
        $album = $this->entityManager->find('Database\Entities\Album', $id['ID']);
        $baseURL = baseURL();
        return $this->view->render('backend/pages/albumDetails.twig.php', array(
            'album' => $album,
            'baseURL' => $baseURL,
            'message' => $message,
            'loggedInUser' => $this->loggedInUser
        ));
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
        $album = $this->entityManager->find('Database\Entities\Album', $id['ID']);
        $albumId = $id['ID'];
        $albumName = $album->getName();
        $formAction = "/backend/albums/update/$albumId";
        $formMethod = "post";
        $albumCreatedBy = $this->entityManager->getRepository('Database\Entities\User')->find($album->getCreatedBy());
        $createdBy['name'] = $albumCreatedBy->getName();
        $createdBy['id'] = $albumCreatedBy->getId();
        return $this->view->render('backend/pages/albumForm.twig.php', array(
            'album'   => $album,
            'action' => $formAction,
            'method' => $formMethod,
            'loggedInUser' => $this->loggedInUser,
            'createdBy' => $createdBy
        ));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function update($id)
    {
        $album = $this->entityManager->find('Database\Entities\Album', $id['ID']);

        $formVars = $this->request->getParsedBody();

        $createdBy = $this->entityManager->find('Database\Entities\User', $formVars['createdBy']);
        $formVars['createdBy'] = $createdBy;
        $updatedBy = $this->entityManager->getRepository('Database\Entities\User')->find($this->loggedInUserId);
        $album->setUpdatedBy($updatedBy);

        $this->hydrateAndPersist($album, $formVars);

        return $this->select($id);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
        // remove content  from the DB
        $album = $this->entityManager->find('Database\Entities\Album', $id['ID']);
        $albumName = $album->getName();
        if (!$albumName) {
            //TODO throw exception
        }
        $this->entityManager->remove($album);
        $this->entityManager->flush();

        $message['type'] = 'alert-danger';
        $message['content'] = "Album \"$albumName\" deleted succesfully";
        return $this->index($message);
    }

    /**
    * method to hydrate and persist an entity
    */
    private function hydrateAndPersist($album, $formVars)
    {
        $albumName = $formVars['name'];
        $albumDescription = $formVars['description'];

        $timestamp = new \DateTime();
        $album->setUpdated($timestamp);
        $album->setName($albumName);
        $album->setDescription($albumDescription);

        try {
            $this->entityManager->persist($album);
            $this->entityManager->flush();
            $message['type'] = 'alert-info';
            $message['content'] = "$albumName added succesfully";
            return $message;
        } catch (UniqueConstraintViolationException $e) {
            $message['type'] = 'alert-danger';
            $message['content'] = "$albumName could not be added";
            return $this->create($message, $formVars);
        }
    }
}
