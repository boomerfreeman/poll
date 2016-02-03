<?php

require_once 'controller.php';

// Controller for login page:
class Login extends Controller
{
    protected $username, $password;
    
    protected function __construct()
    {
        parent::__construct();
        
        if((isset($_POST['username'])) && (isset($_POST['password']))) {
            
            $this->username = htmlspecialchars($_POST['username']);
            $this->password = htmlspecialchars($_POST['password']);
            
            if ($this->model->checkAuthorization($this->username, $this->password)) {
                
                session_start();
                $_SESSION['logged'] = true;
                
                /**
                 * Create administration panel if user has administrator rights, otherwise redirect to polls
                 */
                if ($this->model->checkAdminStatus($this->username)) {
                    header("Location: http://" . $_SERVER['SERVER_NAME'] . '/adminpanel/');
                } else {
                    header("Location: http://" . $_SERVER['SERVER_NAME'] . '/poll/');
                }
                
            } else {
                $this->showError('Incorrect username or password');
            }
        } else {
            $this->generateView('login');
        }
    }
}
