<?php

namespace App\Http\Controllers;

use Lib\Framework\Session;
use Lib\Framework\Http\Controller;

class HomeController extends Controller
{
    public function addMiddleware()
    {
        /* TODO change container to check for existence of this method
           only do "withmethod if esists
        */
    }

    public function index()
    {
        return $this->view->render('frontend/pages/welcome.twig.php');
    }
}
