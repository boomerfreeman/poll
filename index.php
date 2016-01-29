<?php

class Index
{
    /**
     * @var null The controller
     */
    private $url_controller = null;
    /**
     * @var null The method (of the above controller)
     */
    private $url_method = null;
    /**
     * @var array URL parameters
     */
    private $url_params = array();
    
    public function __construct()
    {
        require_once '/config/config.php';
        
        if (isset($_SERVER['REQUEST_URI'])) {
            
            $this->splitUrl();
            
            if ( ! $this->url_controller) {
                
                $this->url_controller = 'login';
            
            } elseif ($this->checkControllerExistence()) {
                
                $controller = $this->createController($this->url_controller);
                
                $this->checkMethodExistence() ? $controller->{$this->url_method}() : null;
            } else {
                $this->url_controller = 'error';
            }
        } else {
            $this->url_controller = 'login';
        }
        $this->createController($this->url_controller);
    }
    
    /**
     * Split URL into the parts
     */
    private function splitUrl()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);

        $this->url_controller = isset($url[0]) ? $url[0] : null;
        $this->url_method = isset($url[1]) ? $url[1] : null;

        unset($url[0], $url[1]);

        $this->url_params = array_values($url);
    }
    
    /**
     * Check if controller exist
     * @return boolean
     */
    private function checkControllerExistence()
    {
        if (file_exists('controller/' . $this->url_controller . '.php')) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Check if method exist
     * @return boolean
     */
    private function checkMethodExistence()
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
     * @return \controller
     */
    private function createController($controller)
    {
        require_once 'controller/' . $controller . '.php';
        return new $controller;
    }
}

new Index();
