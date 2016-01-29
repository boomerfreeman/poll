<?php

class Controller
{
    public $model, $view, $username, $password;
    
    public function __construct()
    {
        require_once '/model/model.php';
        $this->model = new Model();
        
//        if ((isset($_POST['username'])) && (isset($_POST['password'])) && ( ! empty($_POST['username'])) && ( ! empty($_POST['password']))) {
//            
//            $this->username = htmlspecialchars($_POST['username']);
//            $this->password = htmlspecialchars($_POST['password']);
//            
//            // If user exists:
//            if ($this->model->checkAuthorization($this->username, $this->password)) {
//                
//                // If admin:
//                if ($this->model->checkAdminStatus($this->username) == 1) {
//                    header("Location: /adminpanel.php");
//                } else {
//                    header("Location: /poll.php");
//                }
//            } else {
//                require_once '/login.php';
//                new Login();
//            }
//        } else {
//            require_once '/login.php';
//            new Login();
//        }
    }
    
    public function generateView($body = 'login')
    {
        require_once '/view/header.php';
        require_once '/view/' . $body . '.php';
        require_once '/view/footer.php';
    }
}

//new Controller();