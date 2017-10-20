<?php

namespace App\Http\Controllers\Backend;

use Lib\Database\Connection;
use Lib\Framework\Http\Controller;
use Lib\Framework\Http\MiddlewareQueue;

class UserController extends Controller
{
    private $connection;
    private $entityManager;

    public function __construct(MiddlewareQueue $middlewareQueue)
    {
        parent::__construct($middlewareQueue);
        $this->addMiddleware('TestMiddleware');
        $this->connection = new Connection;
        $this->entityManager = $this->connection->entityManager;
    }

    public function index()
    {
        $userRepository = $this->entityManager->getRepository('Database\Entities\User');
        $users = $userRepository->findAll();
        
        foreach ($users as $user) {
            $id = $user->getId();
            $name = $user->getUserName();
            $email = $user->getEmail();
            $userLevel = $user->getUserLevel();
            echo "$id | $name | $email | $userLevel \n";
        }
    }
}
