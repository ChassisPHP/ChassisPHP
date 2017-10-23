<?php

namespace App\Http\Controllers;

use Lib\Framework\Session;

class HomeController
{
    public function index()
    {
        $name = Session::get('name');
        echo "$name HOME PAGE Success!!!!";
    }
}
