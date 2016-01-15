<?php

class User
{
    private $model, $username, $password;
    
    public function __construct()
    {
        require_once '../model/UserModel.php';
        $this->model = new UserModel();
        //$this->getUser('admin');
    }
    
    public function setUsername($username)
    {
        $this->username = $username;
    }
    
    public function addNewUser()
    {
        
    }
}

new User();