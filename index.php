<?php

require_once 'controller/controller.php';

/**
 * Routing class
 */
class Index extends Controller
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
    
    public function __construct()
    {
        require_once '/config/config.php';
        
        if (isset($_SERVER['REQUEST_URI'])) {
            
            $this->splitUrl();
            
            if ( ! $this->url_controller) {
                $this->url_controller = 'login';
            } else {
                if ($this->checkController()) {
                    // Create controller and call method if they have been set in URL
                    $this->checkMethod() ? $this->createController($this->url_controller)->{$this->url_method}() : null;
                } else {
                    $this->url_controller = 'error';
                }
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

        $this->url_controller = isset($url[0]) ? $url[0] : 'login';
        $this->url_method = isset($url[1]) ? $url[1] : null;

        unset($url[0], $url[1]);

        $this->url_params = array_values($url);
    }
    
    /**
     * Check controller existence
     * @return boolean
     */
    private function checkController()
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
    private function checkMethod()
    {
        if (method_exists($this->url_controller, $this->url_method)) {
            return true;
        } else {
            return false;
        }
    }
}

new Index();
