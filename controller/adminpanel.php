<?php

require_once 'controller.php';

// Controller for administration panel:
class AdminPanel extends Controller
{
    protected $poll;
    
    protected function __construct()
    {
        parent::__construct();
        
        isset($_POST['logout']) ? $this->logOut() : null;
        
        isset($_POST['poll']) ? $this->poll = htmlspecialchars($_POST['poll']) : null;
        
        if (isset($_POST['activate'])) {
            $this->activatePoll();
            $this->showMessage("Poll $this->poll is activated");
        }
        
        if (isset($_POST['disable'])) {
            $this->disablePoll();
            $this->showMessage("Poll $this->poll is disabled");
        }
        
        if (isset($_POST['edit'])) {
            $this->editPoll();
            $this->showMessage("Poll $this->poll is edited");
        }
        
        if (isset($_POST['add'])) {
            if (( ! empty($_POST['question'])) && ( ! empty($_POST['answer'])) && ( ! empty($_POST['correct']))) {
                $this->addPoll($_POST['question'], $_POST['answer'], $_POST['correct']);
                $this->showMessage('New poll is added');
            } else {
                $this->showMessage('Some fields are empty...');
            }
        }
        
        if (isset($_POST['delete'])) {
            //$this->detelePoll();
            $this->showMessage("Poll $this->poll is deleted");
        }
        
        $poll['date'] = date("H:i:s d.m.Y");
        $poll['list'] = array_unique($this->model->showPolls(), SORT_REGULAR);
        
        $this->generateView('adminpanel', $poll);
    }
    
    /**
     * Logout from administration panel
     */
    protected function logOut()
    {
        session_start();
        session_destroy();
        header("Location: http://poll/");
        exit;
    }
    
    protected function activatePoll()
    {
        $this->model->activatePollInDB($this->poll);
    }
    
    protected function disablePoll()
    {
        $this->model->disablePollInDB($this->poll);
    }
    
    protected function editPoll()
    {
        $this->model->editPollInDB($this->poll);
    }
    
    protected function addPoll($question, $answer, $correct)
    {
        $this->model->addPollToDB($question, $answer, $correct);
    }
    
    protected function deletePoll()
    {
        $this->model->deletePollFromDB($this->poll);
    }
}
