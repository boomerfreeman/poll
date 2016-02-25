<?php

require_once 'controller.php';

/**
 * Administration panel controller
 */
class AdminPanel extends Controller
{
    private $test_id;
    
    public function __construct()
    {
        parent::__construct();
        
        session_start();
        
        if ($this->checkLoginStatus()) {
            
            if ( ! $this->model->checkAdminStatus($_SESSION['username'])) {
                header('Location: ' . URL . '/choice/');
            }
            
            isset($_POST['logout']) ? $this->logOut() : null;
            
            isset($_POST['test']) ? $this->test_id = htmlspecialchars($_POST['test']) : null;
            
            if (isset($_POST['predit'])) {
                $test['editdata'] = $this->model->getTestData($this->test_id);
                $test['editmenu'] = true;
                $test['message'] = 'Please note that all correct answers are dropped!';
            }
            
            if (isset($_POST['edit'])) {
                if ( ! empty($_POST['question']) && ! empty($_POST['answer']) && ! empty($_POST['correct'])) {
                    $this->model->editTestInDB($this->test_id, htmlspecialchars($_POST['question']), $_POST['answer'], $_POST['correct']);
                    $test['message'] = "Test $this->test_id is edited";
                } else {
                    $test['message'] = 'Some fields are empty...';
                }
            }
            
            if (isset($_POST['add'])) {
                if ( ! empty($_POST['question']) && ! empty($_POST['answer']) && ! empty($_POST['correct'])) {
                    $this->model->addTestToDB($_POST['question'], $_POST['answer'], $_POST['correct']);
                    $test['message'] = 'New test is added';
                } else {
                    $test['message'] = 'Some fields are empty...';
                }
            }
            
            if (isset($_POST['delete'])) {
                $this->model->deleteTestFromDB($this->test_id);
                $test['message'] = "Test $this->test_id is deleted";
            }
            
            $test['date'] = date("H:i:s d.m.Y");
            $test['list'] = $this->model->showTests();
            
            $this->generateView('adminpanel', $test);
        }
    }
}
