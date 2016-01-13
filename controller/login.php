<?php

// Controller for login page:
class Login
{
    public function __construct()
    {
        if ($this->checkLogin()) {
            require_once 'view/header.php';
            require_once 'view/login.php';
            require_once 'view/footer.php';
        } else {
            echo 'Fuck you';
        }
    }
    
    private function checkLogin()
    {
        session_start();
        $_SESSION['auth'] = false;
    }
}
