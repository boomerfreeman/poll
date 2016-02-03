<?php

class Controller
{
    protected $model;
    /**
     * @var null The controller
     */
    protected $url_controller = null;
    /**
     * @var null The method (of the above controller)
     */
    protected $url_method = null;
    /**
     * @var array URL parameters
     */
    protected $url_params = array();
    
    /**
     * Main controller constructor
     */
    protected function __construct()
    {   
        require_once '/model/model.php';
        $this->model = new Model();
    }
    
    /**
     * Check controller existence
     * @return boolean
     */
    protected function checkController()
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
    protected function checkMethod()
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
    protected function createController($controller)
    {
        require_once 'controller/' . $controller . '.php';
        return new $controller;
    }
    
    /**
     * Generate and show the specified page
     * @param type $body
     */
    protected function generateView($body)
    {
        require_once '/view/header.php';
        require_once '/view/' . $body . '.php';
        require_once '/view/footer.php';
    }
    
    protected function showError($error)
    {
        echo $error;
    }
}
