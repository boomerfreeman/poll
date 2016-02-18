<?php

require_once 'controller.php';

/**
 * Test page controller
 */
class Choice extends Controller
{
    /**
     * Array of user answers
     * @var type array
     */
    private $answer = array();
    
    public function __construct()
    {
        parent::__construct();
        
        session_start();
        
        if ($this->checkLoginStatus()) {
        
            isset($_POST['logout']) ? $this->logOut() : null;

            isset($_POST['check']) ? $this->answer = $_POST['check'] : null;

            if (isset($_POST['answer'])) {

                $id = htmlspecialchars($_POST['question_id']);

                if ($this->controlAnswer($id)) {
                    $test['message'] = "Correct answer. Well done!";
                } else {
                    $test['message'] = "No, you are wrong";
                }
            }

            $test['list'] = array_unique($this->model->showTests(), SORT_REGULAR);
            $test['date'] = date("H:i:s d.m.Y");

            $this->generateView('test', $test);
        }
    }
    
    private function controlAnswer($id)
    {
        return $this->model->controlUserAnswer($id, $this->answer);
    }
}
