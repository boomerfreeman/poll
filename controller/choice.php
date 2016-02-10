<?php

require_once 'controller.php';

/**
 * Poll page controller
 */
class Choice extends Controller
{
    public function __construct()
    {
        parent::__construct();
        
        isset($_POST['logout']) ? $this->logOut() : null;
        
        $poll['list'] = array_unique($this->model->showActivePolls(), SORT_REGULAR);
        $poll['date'] = date("H:i:s d.m.Y");
        
        $this->generateView('poll', $poll);
    }
}
