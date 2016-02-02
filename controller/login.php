<?php

require_once 'controller.php';

// Controller for login page:
class Login extends Controller
{
    private $username, $password;
    
    public function __construct()
    {
        parent::__construct();
        
        if((isset($_POST['username'])) && (isset($_POST['password']))) {
            
            $this->username = htmlspecialchars($_POST['username']);
            $this->password = htmlspecialchars($_POST['password']);
            
            if ($this->model->checkAuthorization($this->username, $this->password)) {
                
                session_start();
                $_SESSION['logged'] = true;
            } else {
                $this->showError('Incorrect username or password');
                //$this->generateView('login');
            }
        } else {
            $this->generateView('login');
        }
    }
}
