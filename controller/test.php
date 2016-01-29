<?php

require_once 'controller.php';

class Test extends Controller
{
    private $func, $id;
    
    public function __construct()
    {
        parent::__construct();
        
        require_once '../model/model.php';
        new Model();
        
        $this->func = $_POST['func'];
        $this->id = htmlspecialchars($_POST['id']);
        
        switch ($function) {
            case 'activate': $this->model->activatePoll($this->id); break;
            case 'disable': $this->model->activatePoll($this->id); break;
            case 'add': $this->model->activatePoll($this->id); break;
            case 'delete': $this->model->activatePoll($this->id); break;
            default: echo 'Error';
        }
    }
}

new Test();