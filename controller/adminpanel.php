<?php

require_once 'controller.php';

// Controller for administration panel:
class AdminPanel extends Controller
{
    protected function __construct()
    {
        parent::__construct();
        
        if ((isset($_POST['activate'])) && (isset($_POST['poll']))) {
            $this->activatePoll($_POST['poll']);
            $this->showMessage("Poll {$_POST['poll']} is activated");
        }
        
        if ((isset($_POST['disable'])) && (isset($_POST['poll']))) {
            $this->disablePoll($_POST['poll']);
            $this->showMessage("Poll {$_POST['poll']} is disabled");
        }
        
        $poll['list'] = array_unique($this->model->showPolls(), SORT_REGULAR);
        $poll['count'] = count($poll['list']);
        $poll['i'] = 0;
        
        $this->generateView('adminpanel', $poll);
    }
    
    protected function activatePoll($id)
    {
        $this->model->activatePollInDB($id);
    }
    
    protected function disablePoll($id)
    {
        $this->model->disablePollInDB($id);
    }
}
