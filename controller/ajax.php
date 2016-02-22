<?php

/**
 * Ajax query controller for "Edit test" option in administration panel
 */
class Ajax extends Controller
{
    public function __construct()
    {
        parent::__construct();
        
        if (isset($_POST['test_id'])) {
            
            $id = htmlspecialchars($_POST['test_id']);
            
            echo json_encode($this->model->getTestData($id));
        }
    }
}