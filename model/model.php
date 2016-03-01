<?php

/**
 * Main model
 */
class Model
{
    /**
     * Database connection
     * @return connection handle
     */
    public function __construct()
    {
        require_once 'config/config.php';
        
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
        $this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS, $options);
        
        return $this->db;
    }
    
    /**
     * Check user credentials
     * @param type $username
     * @param type $password
     * @return boolean
     */
    public function checkAuthorization($username, $password)
    {
        $query = $this->db->prepare('SELECT `username`, `password` FROM `user` WHERE `username` = :username');
        $query->execute(array(':username' => $username));
        $data = $query->fetch();
        
        if ($data) {
            
            $user_db = $data->username;
            $pass_db = $data->password;
            
            if ($username == $user_db && md5($password) == $pass_db) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    /**
     * Check if user has administrator rights
     * @param type $username
     * @return boolean
     */
    public function checkAdminStatus($username = null)
    {
        $query = $this->db->prepare('SELECT `group` FROM `user` WHERE `username` = :username');
        $query->execute(array(':username' => $username));
        
        if ($query->fetch()->group == 1) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Fetch user ID by username
     * @param type $username
     * @return object
     */
    public function getUserID($username = 'user')
    {
        $query = $this->db->prepare('SELECT `user_id` FROM `user` WHERE `username` = :username');
        $query->execute(array(':username' => $username));
        
        return $query->fetch()->user_id;
    }
    
    /**
     * Show all tests
     * @return object
     */
    public function showTests()
    {
        $query = $this->db->query('SELECT `test_id`, `test_data` FROM `test` ORDER BY `test_id` ASC');
        
        return $query->fetchAll();
    }
    
    /**
     * Fetch test data with certain ID
     * @param type $id
     * @return object
     */
    public function getTestData($id)
    {
        $query = $this->db->prepare('SELECT `test_id`, `test_data` FROM `test` WHERE `test_id` = :id');
        $query->execute(array(':id' => $id));
        
        return $query->fetchAll();
    }
    
    /**
     * Edit test data in the database
     * @param type $id
     * @param type $question
     * @param type $answers
     * @param type $correct
     */
    public function editTestInDB($id, $question, $answers, $correct)
    {
        $query = $this->db->prepare('UPDATE `test` SET test_data = :test_data WHERE `test_id` = :id');
        
        $data = array(
            'question' => $question,
            'answers' => $answers,
            'correct' => $correct
        );
        
        $query->execute(array(
            ':test_data' => serialize($data),
            ':id' => $id
        ));
    }
    
    /**
     * Add new test to the database
     * @param type $question
     * @param type $answers
     * @param type $correct
     */
    public function addTestToDB($question, $answers, $correct)
    {
        $query = $this->db->prepare('INSERT INTO `test` (`test_data`) VALUES (:test_data)');
        
        $data = array(
            'question' => $question,
            'answers' => $answers,
            'correct' => $correct
        );
        
        $query->execute(array(
            ':test_data' => serialize($data)
        ));
    }
    
    /**
     * Delete test from the database
     * @param type $id
     */
    public function deleteTestFromDB($id)
    {
        $query = $this->db->prepare('DELETE FROM `test` WHERE `test_id` = :id');
        $query->execute(array(':id' => $id));
    }
    
    /**
     * Get correct answers for every test
     * @return array
     */
    public function getCorrectAnswers() {
        
        $correct_answers = array();
        $tests = $this->showTests();
        
        foreach ($tests as $row => $field) {
            
            $data = unserialize($field->test_data);
            $answers = count($data['correct']);
            
            for ($i=0; $i < $answers; $i++) {
                if ($data['correct'][$i] == '1') {
                    $correct_answers[] = $data['answers'][$i];
                }
            }
        }
        return $correct_answers;
    }
    
    /**
     * Control user asnwers
     * @param type $answers
     * @return boolean
     */
    public function controlUserAnswer($answers)
    {
        $corrects = 0;
        $true = 0;
        $data = array();
        $user_test_id = array();
        $user_test_answer = array();
        
        foreach ($answers as $answer) {
            $user_test = explode("_", $answer);
            $user_test_id[] = $user_test[0];
            $user_test_answer[] = $user_test[1];
        }
        
        foreach ($user_test_id as $i => $k) {
            $data[$k][] = $user_test_answer[$i];
        }
        array_walk($data, create_function('$v', '$v = (count($v) == 1)? array_pop($v): $v;'));
        
        foreach ($data as $test_id => $test_answers) {
            
            foreach ($test_answers as $test_answer) {
                $result = $this->getTestData($test_id);

                if ($result) {

                    foreach ($result as $row => $field) {
                        $data = unserialize($field->test_data);
                        $answer_num = count($data['answers']);
                        $user_test_question[] = $data['question'];

                        for ($i=0; $i < $answer_num; $i++) {
                            $data['correct'][$i] == '1' ? $corrects++ : null;
                            
                            if ($test_answer == $data['answers'][$i] && $data['correct'][$i] == '1') {
                                $true++;
                            }
                        }
                    }
                } else {
                    return false;
                }
            }
        }
        
        $this->saveUserAnswers($user_test_question, $user_test_answer);
        
        if ($corrects == $true) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Save user answers to the database
     * @param type $question
     * @param type $answers
     */
    private function saveUserAnswers($question, $answers)
    {
        $query = $this->db->prepare('INSERT INTO `progress` (`user_id`, `test_data`) VALUES (:user_id, :test_data)');
        
        $user_id = $this->getUserID($_SESSION['username']);
        
        $data = array(
            'test_data' => array(
                'question' => $question,
                'answers' => $answers
            )
        );
        
        $query->execute(array(
            ':user_id' => $user_id,
            ':test_data' => serialize($data)
        ));
    }
}
