<?php

namespace App\Http\Controllers;

use Lib\Database\Connection;
use Lib\Framework\Session;
use Lib\Framework\Http\Controller;

class AboutController extends Controller
{
    public function __construct()
    {
        // Set up DB connection and entity
        $this->connection = new Connection;
        $this->entityManager = $this->connection->entityManager;
    }
    
    public function addMiddleware()
    {
        // TODO change container to check for existence of this method
        // only do "withmethod if esists
    }

    public function index()
    {
        $criteria = array('position' => 'about-1');
        $content = $this->entityManager->getRepository('Database\Entities\Content')->findBy($criteria);
        $content = $content[0];
        return $this->view->render('frontend/pages/about.twig.php', array('content' => $content));
    }
}
