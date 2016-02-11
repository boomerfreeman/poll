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
        
        isset($_POST['logout']) ? $this->logOut() : null;
        
        isset($_POST['check']) ? $this->answer = $_POST['check'] : null;
        
        if (isset($_POST['answer'])) {
            $id = htmlspecialchars($_POST['question_id']);
            $data = $this->controlAnswer($id);
            
            if ($data) {
                echo 'Correct';
            } else {
                echo 'Wrong';
            }
        }
        
        $test['list'] = array_unique($this->model->showActiveTests(), SORT_REGULAR);
        $test['date'] = date("H:i:s d.m.Y");
        
        $this->generateView('test', $test);
    }
    
    private function controlAnswer($id)
    {
        return $this->model->controlTestAnswer($id, $this->answer);
    }
}
