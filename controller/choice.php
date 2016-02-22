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
    
    public function __construct()
    {
        parent::__construct();
        
        session_start();
        
        if ($this->checkLoginStatus()) {
            
            isset($_POST['logout']) ? $this->logOut() : null;
            
            isset($_POST['check']) ? $this->answer = $_POST['check'] : null;
            
            if (isset($_POST['answer'])) {
                
                if (! empty ($this->answer)) {
                    $res = $this->controlAnswer();
                    $test['message'] = 'Your answers have been saved.';
                } else {
                    $test['message'] = 'Click any checkbox, please';
                }
            }
            
            $test['list'] = array_unique($this->model->showTests(), SORT_REGULAR);
            
            $this->generateView('test', $test);
        }
    }
    
    private function controlAnswer()
    {
        return $this->model->controlUserAnswer($this->answer);
    }
}
