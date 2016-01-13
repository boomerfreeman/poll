<?php

class Application
{
    public function __construct()
    {
        $this->checkLoginStatus();
    }
    
    private function checkLoginStatus()
    {
        session_start();
        
        if ($_SESSION['auth']) {
            
            require_once 'controller/adminpanel.php';
            new AdminPanel;
            
        } else {
            
            require_once 'controller/login.php';
            new Login;
        }
    }
}

new Application;