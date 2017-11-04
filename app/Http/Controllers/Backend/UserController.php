<?php

namespace App\Http\Controllers\Backend;

use Lib\Database\Connection;
use Lib\Framework\Http\Controller;
use Lib\Framework\Http\MiddlewareQueue;
use Doctrine\ORM\Query;

class UserController extends Controller
{
    private $connection;
    private $entityManager;
    private $view;

    public function __construct($middleware, $twig)
    {
        parent::__construct($middleware, $twig);
        $this->addMiddleware('TestMiddleware');
        $this->connection = new Connection;
        $this->entityManager = $this->connection->entityManager;
        $this->view = $twig;
    }

    public function index()
    {
        $userRepository = $this->entityManager->getRepository('Database\Entities\User');
        $users = $userRepository->findAll();
        
        return $this->view->render('backend/partials/users.php', array('users' =>  $users));
    }
}
