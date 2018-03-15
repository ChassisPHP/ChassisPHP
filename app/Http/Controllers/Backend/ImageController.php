<?php

namespace App\Http\Controllers\Backend;

use Lib\Database\Connection;
use Lib\Framework\Http\Controller;
use Lib\Framework\Session;
use Doctrine\ORM\Query;
use Database\Entities\Image;
use Database\Entities\User;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class ImageController extends Controller
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
        // Display all images from the DB
        $imageRepository = $this->entityManager->getRepository('Database\Entities\Image');
        $images = $imageRepository->findAll();
        return $this->view->render('backend/pages/images.twig.php', array('images' => $images, 'message' => $message, 'loggedInUser' => $this->loggedInUser));
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return Response
     */

    public function create($formVars = null)
    {
        $formAction = "/backend/images/create";
        $formMethod = "post";
        $createdBy['name'] = $this->loggedInUser;
        $createdBy['id'] = $this->loggedInUserId;

        return $this->view->render('backend/pages/imageForm.twig.php', array('formVars' => $formVars, 'action' => $formAction, 'method' => $formMethod, 'loggedInUser' => $this->loggedInUser, 'createdBy' => $createdBy));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @return Response
     */

    public function store()
    {
        $formVars = $this->request->getParsedBody();

        $image = new Image;

        $timestamp = new \DateTime();
        $image->setPublicationDate($timestamp);
        
        $createdBy = $this->entityManager->find('Database\Entities\User', $formVars['author']);
        $createdBy->setAuthor($author);
        $message = $this->hydrateAndPersist($image, $formVars);
        $filename = $_FILES["imageFile"]["name"];
        $this->saveAs('storage/public/img', $filename);
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
        $image = $this->entityManager->find('Database\Entities\Image', $id['ID']);
        return $this->view->render('backend/pages/imageDetails.twig.php', array('image' => $image, 'message' => $message, 'loggedInUser' => $this->loggedInUser));
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
        $image = $this->entityManager->find('Database\Entities\Image', $id['ID']);
        $imageId = $id['ID'];
        $formAction = "/backend/content/update/$imageId";
        $formMethod = "post";
        $imageCreatedBy = $this->entityManager->getRepository('Database\Entities\User')->find($image->getCreatedBy());
        $createdBy['name'] = $createdByAuthor->getName();
        $createdBy['id'] = $imageCreatedBy->getId();
        return $this->view->render('backend/pages/imageForm.twig.php', array('imageEntry' => $image, 'action' => $formAction, 'method' => $formMethod, 'loggedInUser' => $this->loggedInUser, 'createdBy' => $createdBy));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function update($id)
    {
        $image = $this->entityManager->find('Database\Entities\Image', $id['ID']);
    
        $formVars = $this->request->getParsedBody();

        $createdBy = $this->entityManager->find('Database\Entities\User', $formVars['createdBy']);
        $formVars['createdBy'] = $createdBy;
        $updatedBy = $this->entityManager->getRepository('Database\Entities\User')->find($this->loggedInUserId);
        $image->setUpdatedBy($updatedBy);
        
        $this->hydrateAndPersist($content, $formVars);

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
        $image = $this->entityManager->find('Database\Entities\Image', $id['ID']);
        $filename = $filename->getFilename();
        if (!$filename) {
            //TODO throw exception
        }
        $this->entityManager->remove($image);
        $this->entityManager->flush();

        $message['type'] = 'alert-danger';
        $message['content'] = "Content entry \"$filename\" deleted succesfully";

        return $this->index($message);
    }

    /**
    * method to hydrate and persist an entity
    */
    private function hydrateAndPersist($image, $formVars)
    {
        $filename = $formVars['filename'];
        $position = $formVars['position'];
        $caption = $formVars['caption'];

        $timestamp = new \DateTime();
        $image->setUpdated($timestamp);
        $image->setTitle($title);
        $image->setPosition($position);
        $image->setBody($body);
        //$content->setAuthor($author);

        try {
            $this->entityManager->persist($image);
            $this->entityManager->flush();
            $message['type'] = 'alert-info';
            $message['content'] = "$filename added succesfully";
            return $message;
        } catch (UniqueConstraintViolationException $e) {
            $message['type'] = 'alert-danger';
            $message['content'] = "$title could not be added";
            return $this->create($message, $formVars);
        }
    }

        /**
         * method to save a file
         * TODO refactor this method
         * out, and make it available
         * throughout the entire application
         */
    private function saveAs($savePath, $filename)
    {
        $filePath = $savePath . basename($filename);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["imageFile"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                //TODO Throw an error
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($filePath)) {
            //TODO handle this??? Add confirmation??
            //$uploadOk = 0;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            //TODO throw an error
            $uploadOk = 0;
        }
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            // TODO throw an error "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            return false;
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $filePath)) {
                return true;
            } else {
                return false;
            }
        }
    }
}
