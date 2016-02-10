<?php

class Ajax extends Controller
{
    public function __construct()
    {
        parent::__construct();
        
        if (isset($_POST['poll'])) {
            
            $poll = htmlspecialchars($_POST['poll']);
            
            echo json_encode($this->model->getPollData($poll));
        }
    }
}