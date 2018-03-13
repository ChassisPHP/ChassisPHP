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
}
