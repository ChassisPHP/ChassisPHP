<?php

namespace App\Http\Controllers\Backend;

use Lib\Framework\Hash;
use Doctrine\ORM\Query;
use Lib\Framework\Session;
use Database\Entities\User;
use Lib\Database\Connection;
use Lib\Framework\Http\Controller;

class AuthController extends Controller
{
    private $hash;
    private $connection;
    private $entityManager;

    public function __construct()
    {
        // Set up DB connection and entity
        $this->connection    = new Connection;
        $this->hash          = new Hash;
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

    public function forgotIndex($formVars = array())
    {
        $message =  Session::getMessage();
        return $this->view->render(
            'backend/pages/forgot.twig.php',
            array(
                'message' => $message,
                'formVars' => $formVars
            )
        );
    }

    public function forgotStore()
    {
        $formVars = $this->request->getParsedBody();
        $user = $this->entityManager
                     ->getRepository(
                         'Database\Entities\User'
                     )
                     ->findoneby(
                         array('email' => $formVars['email'])
                     );
        if ($user) {
            $hash = $this->hash->make(microtime() . uniqid(true));
            $user->setForgotPasswd($hash);
            $user->setExpireForgotPasswd(time() + 60 * 10);

            $recipient = array($user->getEmail());
            $subject ="Password Rest Request";
            $messageBody = array('content' => "Hello,
                            Someone requested a password reset. If it was not you, ignore this email.
                            Otherwise, please click the link below to continue.
                            The link expires in 10 minutes." .
                            baseURL() . "backend/reset/" . base64_encode($hash));
            $fromAddress = "roger@chassisphp.com";
            $fromName = "Site Admin";
            $template = "backend/email/passwordReset.twig.php";

            try {
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                if ($this->mailer->send(
                    $recipient,
                    $subject,
                    $messageBody,
                    $fromAddress,
                    $fromName,
                    $template
                )) {
                    Session::setMessage('info', 'Please check your email to continue resetting your password');
                } else {
                    Session::setMessage('warning', 'Could not reset your password, please contact support');
                }
            } catch (UniqueConstraintViolationException $e) {
                Session::setMessage('warning', 'Could not reset your password, please contact support');
            }
        } else {
            Session::setMessage('warning', 'Wrong Email, please try again');
        }
        return $this->forgotIndex($formVars);
    }

    public function resetIndex($get)
    {

        $hash = base64_decode($get['hash']);
        $user = $this->entityManager
                     ->getRepository('Database\Entities\User')
                     ->findoneby(array('forgotPasswd' => $hash));
        if ($user) {
            if ($user->getExpireForgotPasswd() < time()) {
                Session::setMessage('warning', 'Your password reset link has expired, please try again');
            }
        } else {
            Session::setMessage('warning', 'Your password reset link is malformed, please try again');
        }
        $message =  Session::getMessage();
        return $this->view->render(
            'backend/pages/reset.twig.php',
            array(
                'message' => $message,
                'hash'    => base64_encode($hash)
            )
        );
    }

    public function resetStore($get)
    {
        $hash = base64_decode($get['hash']);
        $user = $this->entityManager
                     ->getRepository('Database\Entities\User')
                     ->findoneby(array('forgotPasswd' => $hash));
        if ($user) {
            if ($user->getExpireForgotPasswd() > time()) {
                $formVars = $this->request->getParsedBody();
                if ($formVars['passwd'] &&
                    $formVars['confirmPasswd'] &&
                    (strcmp($formVars['passwd'], $formVars['confirmPasswd'] === 0))
                ) {
                    $passwd = $this->hash->make($formVars['passwd']);
                    $user->setPasswd($passwd);
                    try {
                        $this->entityManager->persist($user);
                        $this->entityManager->flush();

                        Session::setMessage('info', 'Your password has been reset');
                    } catch (UniqueConstraintViolationException $e) {
                        Session::setMessage('warning', 'Could not reset your password, please contact support');
                    }
                } else {
                    Session::setMessage('warning', 'Your passwords do not match, please try again');
                }
            } else {
                Session::setMessage('warning', 'Your password reset link has expired, please try again');
            }
        } else {
            Session::setMessage('warning', 'Your password reset link is malformed, please try again');
        }
        return $this->index();
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
        $email    = $formVars['email'];
        $passwd   = $formVars['passwd'];

        //TODO Validation

        // Lookup user by email
        $user = $this->entityManager->getRepository('Database\Entities\User')->findoneby(array('email' => $email));

        if ($user && $this->hash->check($passwd, $user->getPasswd())) {
            Session::set('user', $user->getId());
            Session::set('name', $user->getName());
            Session::set('level', $user->getUserLevel());
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
    public function show($getVar)
    {
        $id = $getVar['ID'];
        $user = $this->entityManager->getRepository('Database\Entities\User')->find($id);
        // TODO add functionality to get user details
        //
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
