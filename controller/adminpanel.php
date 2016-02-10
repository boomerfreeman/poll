<?php

require_once 'controller.php';

/**
 * Administration panel controller
 */
class AdminPanel extends Controller
{
    private $poll;
    
    public function __construct()
    {
        parent::__construct();
        
        isset($_POST['logout']) ? $this->logOut() : null;
        
        isset($_POST['poll']) ? $this->poll = htmlspecialchars($_POST['poll']) : null;
        
        if (isset($_POST['activate'])) {
            $this->activatePoll();
            $poll['message'] = "Poll $this->poll is activated";
        }
        
        if (isset($_POST['disable'])) {
            $this->disablePoll();
            $poll['message'] = "Poll $this->poll is disabled";
        }
        
        if (isset($_POST['edit'])) {
            if (( ! empty($_POST['question'])) && ( ! empty($_POST['answer'])) && ( ! empty($_POST['correct']))) {
                $this->editPoll($_POST['question'], $_POST['answer'], $_POST['correct']);
                $poll['message'] = "Poll $this->poll is edited";
            } else {
                $poll['message'] = 'Some fields are empty...';
            }
        }
        
        if (isset($_POST['add'])) {
            if (( ! empty($_POST['question'])) && ( ! empty($_POST['answer'])) && ( ! empty($_POST['correct']))) {
                $this->addPoll($_POST['question'], $_POST['answer'], $_POST['correct']);
                $poll['message'] = 'New poll is added';
            } else {
                $poll['message'] = 'Some fields are empty...';
            }
        }
        
        if (isset($_POST['delete'])) {
            $this->deletePoll();
            $poll['message'] = "Poll $this->poll is deleted";
        }
        
        $poll['date'] = date("H:i:s d.m.Y");
        $poll['list'] = array_unique($this->model->showPolls(), SORT_REGULAR);
        
        $this->generateView('adminpanel', $poll);
    }
    
    private function activatePoll()
    {
        $this->model->activatePollInDB($this->poll);
    }
    
    private function disablePoll()
    {
        $this->model->disablePollInDB($this->poll);
    }
    
    private function editPoll($question, $answer, $correct)
    {
        $this->model->editPollInDB($this->poll, $question, $answer, $correct);
    }
    
    private function addPoll($question, $answer, $correct)
    {
        $this->model->addPollToDB($question, $answer, $correct);
    }
    
    private function deletePoll()
    {
        $this->model->deletePollFromDB($this->poll);
    }
}
