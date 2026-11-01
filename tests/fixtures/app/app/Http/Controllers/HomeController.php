<?php

namespace App\Http\Controllers;

use ChassisPHP\Framework\Http\Controller;

class HomeController extends Controller
{
    public function addMiddleware()
    {
    }

    public function index($vars)
    {
        return $this->view->render('home.html', ['name' => 'Chassis']);
    }
}
