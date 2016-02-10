<?php

/**
 * Main controller class
 */
class Controller
{
    /**
     * The controller
     * @var null
     */
    public $url_controller = null;
    
    /**
     * The method (of the above controller)
     * @var null
     */
    public $url_method = null;
    
    /**
     * URL parameters
     * @var array
     */
    public $url_params = array();
    
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
     * Check controller existence
     * @return boolean
     */
    public function checkController()
    {
        if (file_exists('controller/' . $this->url_controller . '.php')) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Check method existence
     * @return boolean
     */
    public function checkMethod()
    {
        if (method_exists($this->url_controller, $this->url_method)) {
            return true;
        } else {
            return false;
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
        session_start();
        session_destroy();
        header("Location: http://poll/");
        exit;
    }
}
