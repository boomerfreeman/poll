<?php

require_once 'controller.php';

/**
 * Administration panel controller
 */
class AdminPanel extends Controller
{
    private $test;
    
    public function __construct()
    {
        parent::__construct();
        
        session_start();
        
        if ($this->checkLoginStatus()) {
            
            if ( ! $this->model->checkAdminStatus($_SESSION['username'])) {
                header('Location: ' . URL . '/choice/');
            }
            
            isset($_POST['logout']) ? $this->logOut() : null;
            
            isset($_POST['test']) ? $this->test = htmlspecialchars($_POST['test']) : null;
            
            if (isset($_POST['edit'])) {
                if (( ! empty($_POST['question'])) && ( ! empty($_POST['answer'])) && ( ! empty($_POST['correct']))) {
                    $this->editTest($_POST['question'], $_POST['answer'], $_POST['correct']);
                    $test['message'] = "Test $this->test is edited";
                } else {
                    $test['message'] = 'Some fields are empty...';
                }
            }
            
            if (isset($_POST['add'])) {
                if (( ! empty($_POST['question'])) && ( ! empty($_POST['answer'])) && ( ! empty($_POST['correct']))) {
                    $this->addTest($_POST['question'], $_POST['answer'], $_POST['correct']);
                    $test['message'] = 'New test is added';
                } else {
                    $test['message'] = 'Some fields are empty...';
                }
            }
            
            if (isset($_POST['delete'])) {
                $this->deleteTest();
                $test['message'] = "Test $this->test is deleted";
            }
            
            $test['date'] = date("H:i:s d.m.Y");
            $test['list'] = $this->model->showTests();
            
            $this->generateView('adminpanel', $test);
        }
    }
    
    private function editTest($question, $answer, $correct)
    {
        $this->model->editTestInDB($this->test, $question, $answer, $correct);
    }
    
    private function addTest($question, $answer, $correct)
    {
        $this->model->addTestToDB($question, $answer, $correct);
    }
    
    private function deleteTest()
    {
        $this->model->deleteTestFromDB($this->test);
    }
}
