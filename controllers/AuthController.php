<?php

class AuthController
{
    public function login()
    {
        require_once './views/templates/header.php';
        require_once './views/templates/login.php';
        require_once './views/templates/footer.php';
    }

    public function register()
    {
        require_once './views/templates/header.php';
        require_once './views/templates/register.php';
        require_once './views/templates/footer.php';
    }
}