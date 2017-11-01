<?php

namespace App\Http\Controllers\Backend;

use Lib\Database\Connection;
use Lib\Framework\Http\Controller;

class AuthController extends Controller
{

    private $view;

    public function __construct($middleware, $twig)
    {
        parent::__construct($middleware, $twig);
        //
        $this->view = $twig;
    }

    public function index()
    {
        return $this->view->render('backend/partials/register.html.twig');
    }
}
