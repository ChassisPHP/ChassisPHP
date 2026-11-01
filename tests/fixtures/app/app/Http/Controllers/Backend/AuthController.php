<?php

namespace App\Http\Controllers\Backend;

use ChassisPHP\Framework\Http\Controller;

class AuthController extends Controller
{
    public function addMiddleware()
    {
    }

    public function login($vars)
    {
        return 'login page';
    }
}
