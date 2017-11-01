<?php

namespace App\Http\Controllers\Backend;

use Lib\Database\Connection;
use Lib\Framework\Http\Controller;
use Lib\Framework\Http\MiddlewareQueue;

class UserController extends Controller
{
    private $connection;
    private $entityManager;

    public function __construct($middleware, $twig)
    {
        parent::__construct($middleware, $twig);
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
            $classResponse = "$id | $name | $email | $userLevel <br>\n";
            return $classResponse;
        }
    }
}
