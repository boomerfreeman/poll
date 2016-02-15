<?php

require_once 'controller/controller.php';

/**
 * Routing class
 */
class Index extends Controller
{
    public function __construct()
    {
        require_once '/config/config.php';
        
        if (isset($_SERVER['REQUEST_URI'])) {
            
            $this->splitUrl();
            
            if ( ! $this->url_controller) {
                
                $this->url_controller = 'login';
            
            } elseif ($this->checkController()) {
                
                // Create controller and call method if they have been set in URL
                $this->checkMethod() ? $this->createController($this->url_controller)->{$this->url_method}() : null;
                
            } else {
                $this->url_controller = 'error';
            }
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
}

new Index();
