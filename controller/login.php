<?php

require_once 'controller.php';

// Controller for login page:
class Login extends Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->generateView('login');
    }
}
