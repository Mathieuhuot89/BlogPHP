<?php

namespace App\Controller;

use App\Router;

class AuthController
{

    public function __construct(private Router $router)
    {
        
    }
    public function logoutAction()
    {
        session_start();
        session_destroy();
        header('Location: ' . $this->router->url('login'));
        exit();
    }
}
