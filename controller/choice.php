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
                
                if ( ! empty ($this->answer)) {
                    $this->controlAnswer() ? $test['message'] = 'Correct answers.' : null;
                    $this->showAnswers();
                } else {
                    $test['message'] = 'Click any checkbox, please';
                }
            }
            
            $test['list'] = $this->model->showTests();
            
            $this->generateView('test', $test);
        }
    }
    
    /**
     * Process and check user answers
     */
    private function controlAnswer()
    {
        return $this->model->controlUserAnswer($this->answer);
    }
    
    private function showAnswers()
    {
        $this->model->getCorrectAnswers();
    }
}
