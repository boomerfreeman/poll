<?php

require_once 'controller.php';

/**
 *  Controller for login page:
 */
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
                $_SESSION['username'] = $this->username;
                
                // Redirect user to administration panel if he has rights, otherwise redirect to tests
                if ($this->model->checkAdminStatus($this->username)) {
                    header('Location: ' . URL . '/adminpanel/');
                } else {
                    header('Location: ' . URL . '/choice/');
                }
            } else {
                $test['message'] = 'Incorrect username or password';
            }
        } else {
            $test['message'] = '';
        }
        $this->generateView('login', $test);
    }
}
