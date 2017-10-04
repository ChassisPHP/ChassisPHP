<?php

namespace Http\Controllers\Backend;

use Lib\Database\Connection;
use Database\Entities\User;

class UserController
{
    private $connection;
    private $entityManager;

    public function __construct()
    {
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
