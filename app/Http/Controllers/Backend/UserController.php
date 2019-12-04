<?php

namespace App\Http\Controllers\Backend;

use Doctrine\ORM\Query;
use Lib\Framework\Hash;
use Lib\Framework\Session;
use Database\Entities\User;
use Lib\Database\Connection;
use Lib\Framework\Http\Controller;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class UserController extends Controller
{

    private $connection;
    private $entityManager;
    private $hash;

    public function __construct()
    {
        // Set up DB connection and entity
        $this->connection = new Connection;
        $this->hash = new Hash;
        $this->entityManager = $this->connection->entityManager;
    }

    public function addMiddleware()
    {
        // Only allow logged in users
        $this->middlewareQueue->addMiddleware('AuthMiddleware', '\Lib\Framework\Http\Middleware\\');
    }

    public function index($message = null)
    {
        // Display all users from the DB
        $userRepository = $this->entityManager->getRepository('Database\Entities\User');
        $users = $userRepository->findAll();
        $loggedInUser = Session::get('name');

        return $this->view->render(
            'backend/pages/users.php',
            array(
                'users' => $users,
                'message' => $message,
                'loggedInUser' => $loggedInUser
            )
        );
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    *
    */
    public function create($message = null, $formVars = null)
    {
        return $this->view->render(
            'backend/pages/register.twig.php',
            array(
                'message' => $message,
                'formVars' => $formVars
            )
        );
    }

    /**
    * Store a newly created resource in storage.
    *
    * @return Response
    *
    */
    public function store()
    {
        $formVars = $this->request->getParsedBody();
        $name = $formVars['name'];
        $email = $formVars['email'];
        $passwd = $formVars['passwd'];
        $passwd = $this->hash->make($passwd);
        $userLevel = $formVars['userLevel'];

        $user = new User;
        $user->setName($name);
        $user->setEmail($email);
        $user->setPasswd($passwd);
        $user->setUserLevel($userLevel);

        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $message['type'] = 'alert-info';
            $message['content'] = "User $name added succesfully";
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
    public function show($id)
    {
        //
        $user = $this->entityManager->getRepository('Database\Entities\User')->find($id);
        // TODO add functionality to get user details
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
    */
    public function destroy($id)
    {
        $userLevel = Session::get('level');

        $userRepo = $this->entityManager->getRepository('Database\Entities\User');
        $user = $userRepo->find($id['ID']);
        $name = $user->getName();

        // Check that logged in user has permission
        // Disallow self delete
        if ($userLevel && $userLevel == 1 && $id['ID'] != Session::get('user')) {
        // remove a user from the DB
            $this->entityManager->remove($user);
            $this->entityManager->flush();

            $message['type'] = 'alert-danger';
            $message['content'] = "User $name deleted succesfully";
        } else {
            if ($id['ID'] == Session::get('user')) {
                $message['type'] = 'alert-danger';
                $message['content'] = "You cannot delete yourself. Have an administrator delete your account";
            } else {
                $message['type'] = 'alert-danger';
                $message['content'] =
                    "You are not authorized to delete user accounts. Please contact a site adminsitrator";
            }
            $loggedInUser = Session::get('name');
            $logMessage = $loggedInUser . " attempted to delete user " . $name;
            $this->logger->info($logMessage);
        }
            return $this->index($message);
    }
}
