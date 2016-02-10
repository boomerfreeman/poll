<?php

require_once 'controller.php';

// Controller for login page:
class Login extends Controller
{
    public $username, $password;
    
    public function __construct()
    {
        parent::__construct();
        
        if((isset($_POST['username'])) && (isset($_POST['password']))) {
            
            $this->username = htmlspecialchars($_POST['username']);
            $this->password = htmlspecialchars($_POST['password']);
            
            if ($this->model->checkAuthorization($this->username, $this->password)) {
                
                session_start();
                $_SESSION['logged'] = true;
                
                // Redirect user to administration panel if he has rights, otherwise redirect to polls
                if ($this->model->checkAdminStatus($this->username)) {
                    header("Location: http://" . $_SERVER['SERVER_NAME'] . '/adminpanel/');
                } else {
                    header("Location: http://" . $_SERVER['SERVER_NAME'] . '/choice/');
                }
                
            } else {
                $this->showMessage('Incorrect username or password');
            }
        } else {
            $this->generateView('login');
        }
    }
}
