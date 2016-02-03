<?php

require_once 'controller.php';

// Controller for administration panel:
class AdminPanel extends Controller
{
    public function __construct()
    {
        parent::__construct();
        
//        $poll['list'] = array_unique($this->model->showActivePolls(), SORT_REGULAR);
//        $poll['count'] = count($poll['list']);
        
        $this->generateView('adminpanel');
        echo 'adminpanel';
    }
    
    public function test()
    {
        echo 'True';
    }
}

//new AdminPanel();