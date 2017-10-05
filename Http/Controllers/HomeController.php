<?php

namespace Http\Controllers;

use Lib\Framework\Session;

class HomeController
{
    public function index()
    {
        Session::set('name', 'guest');
        $name = Session::get('name');
        echo "$name HOME PAGE Success!!!!";
    }
}
