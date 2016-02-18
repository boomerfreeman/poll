<?php

/**
 * Main controller
 */
class Controller
{
    /**
     * @var null 
     */
    public $model = null;
    
    /**
     * Main controller constructor
     */
    public function __construct()
    {   
        require_once '/model/model.php';
        $this->model = new Model();
    }
    
    /**
     * Control if user logged or not
     * @return boolean
     */
    public function checkLoginStatus()
    {
        if (isset($_SESSION['logged'])) {
            return true;
        } else {
            header('Location: ' . URL);
            exit;
        }
    }
    
    /**
     * Construct controller
     * @param type $controller
     * @return void
     */
    public function createController($controller)
    {
        require_once 'controller/' . $controller . '.php';
        return new $controller;
    }
    
    /**
     * Generate and show the specified page
     * @param type $body
     */
    public function generateView($body = 'login', $params = array())
    {
        require_once '/view/header.php';
        require_once '/view/' . $body . '.php';
        require_once '/view/footer.php';
    }
    
    /**
     * Logout from administration panel
     */
    public function logOut()
    {
        session_destroy();
        header('Location: ' . URL);
        exit;
    }
}
