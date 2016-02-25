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
    private $answers = array();
    
    public function __construct()
    {
        parent::__construct();
        
        session_start();
        
        if ($this->checkLoginStatus()) {
            
            isset($_POST['logout']) ? $this->logOut() : null;
            
            isset($_POST['check']) ? $this->answers = $_POST['check'] : null;
            
            if (isset($_POST['answer'])) {
                
                if ( ! empty ($this->answers)) {
                    $this->model->controlUserAnswer($this->answers);
                    $test['rights'] = $this->model->getCorrectAnswers();
                    $test['checked'] = $_POST['check'];
                    $test['message'] = 'Correct answers are marked with green';
                } else {
                    $test['message'] = 'Click any checkbox, please';
                }
            }
            
            $test['list'] = $this->model->showTests();
            
            $this->generateView('test', $test);
        }
    }
}
