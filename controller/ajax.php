<?php

/**
 * Ajax query controller
 */
class Ajax extends Controller
{
    public function __construct()
    {
        parent::__construct();
        
        if (isset($_POST['test'])) {
            
            $test = htmlspecialchars($_POST['test']);
            
            echo json_encode($this->model->getTestData($test));
        }
    }
}