<?php

class Index
{
    public $msg;
    private $model, $username, $password;
    
    public function __construct()
    {
        require_once 'model/model.php';
        $this->model = new Model();
        
        if ((isset($_POST['username'])) && (isset($_POST['password']))) {
            
            $this->username = htmlspecialchars($_POST['username']);
            $this->password = htmlspecialchars($_POST['password']);
            
            // If user exists:
            if ($this->model->checkAuthorization($this->username, $this->password)) {
                
                // If admin:
                if ($this->model->checkAdminStatus($this->username) == 1) {
                    require_once 'controller/adminpanel.php';
                    new AdminPanel();
                } else {
                    require_once 'controller/poll.php';
                    new Poll();
                }
            } else {
                require_once 'controller/login.php';
                new Login();
            }
        } else {
            require_once 'controller/login.php';
            new Login();
        }
    }
}

new Index();
