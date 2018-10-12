<?php

namespace App\Http\Controllers\Backend;

use Lib\Database\Connection;
use Lib\Framework\Hash;
use Lib\Framework\Session;
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

    public function addMiddleware()
    {
        // Only allow logged in users
        //$this->middlewareQueue->addMiddleware('AuthMiddleware', '\Lib\Framework\Http\Middleware\\');
    }


    public function index()
    {
        $message =  Session::getMessage();
        return $this->view->render('backend/pages/login.php', array('message' => $message));
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

        //TODO Validation

        // Lookup user by email
        $user = $this->entityManager->getRepository('Database\Entities\User')->findoneby(array('email' => $email));

        if ($user && $this->hash->check($passwd, $user->getPasswd())) {
            Session::set('user', $user->getId());
            Session::set('name', $user->getName());
            Session::set('authenticated', true);

            // if the user has attempted to access a restricted
            // page without logging in, we need to clear the error
            if (Session::get('error')) {
                Session::clear('error');
            }
            // send the user to the page request prior to login
            $URI = Session::get('history');

            redirectPath("backend/users");
        } else {
            //$message['type'] = 'alert-danger';
            Session::setMessage('warning', 'Wrong Email or Password, please try again');

            return $this->index();
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
    * Log the current user out and return them to the homepage
    *
    * @return Response
    */
    public function logout()
    {
        // destroy the  user's session
        Session::destroy();

        // return the homepage as the response
        return $this->view->render('frontend/pages/welcome.twig.php');
    }
}
