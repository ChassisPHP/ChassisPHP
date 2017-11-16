<?php

namespace App\Http\Controllers\Backend;

use Lib\Database\Connection;
use Lib\Framework\Hash;
use Lib\Framework\Http\Controller;
use Doctrine\ORM\Query;
use Database\Entities\User;

class AuthController extends Controller
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

    public function index($message = null)
    {
        // Display Login form
        return $this->view->render('backend/pages/login.php');
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    *
    */
    public function create()
    {
        return $this->view->render('backend/partials/register.twig.php');
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
        $email = $formVars['email'];
        $passwd = $formVars['passwd'];
        $passwd = $this->hash->make($passwd);

        //TODO Validation

        // Lookup user by email
        $user = $this->entityManager->getRepository('Database\Entities\User')->findby(array('email' => $email));
        debugVar($user);
        $message['type'] = 'alert-info';
        $message['content'] = "User $name added succesfully";
    
        return $this->index($message);
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
        // remove a user from the DB
        $userRepo = $this->entityManager->getRepository('Database\Entities\User');
        $user = $userRepo->find($id['ID']);
        $name = $user->getName();
        $this->entityManager->remove($user);
        $this->entityManager->flush();
        
        $message['type'] = 'alert-danger';
        $message['content'] = "User $name deleted succesfully";
    
        return $this->index($message);
    }
}
