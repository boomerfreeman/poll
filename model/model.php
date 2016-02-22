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
        
        return $query->fetch()->id;
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
     * Remove and add new test to the database
     * @param type $id
     * @param type $question
     * @param type $answers
     * @param type $correct
     */
    public function editTestInDB($id, $question, $answers, $correct)
    {
        $this->deleteTestFromDB($id);
        $this->addTestToDB($question, $answers, $correct, $id);
    }
    
    /**
     * Add new test to the database
     * @param type $question
     * @param type $answers
     * @param type $correct
     */
    public function addTestToDB($question, $answers, $correct)
    {
        $query = $this->db->prepare("
            INSERT INTO `test` (`test_data`) 
            VALUES (:test_data)
        ");
        
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
     * Control user asnwers
     * @param type $answers
     * @return boolean
     */
    public function controlUserAnswer($answers)
    {
        $true = 0;
        
        foreach ($answers as $answer) {
            
            $user_test = explode("_", $answer);
            $user_test_id = $user_test[0];
            $user_test_answer = $user_test[1];
            
            $result = $this->getTestData($user_test_id);

            if ($result) {

                foreach ($result as $row => $field) {

                    $data = unserialize($field->test_data);

                    for ($i=0; $i < count($data['answers']); $i++) {
                        
                        if ($user_test_answer == $data['answers'][$i] && $data['correct'][$i] == '1') {
                            $true++;
                        } else {
                            $true--;
                        }
                    }
                }
            }
        }
        
        if (count($answers) == $true) {
            //return true;
            echo 'Correct';
        } else {
            return false;
        }
    }
    
    /**
     * Save right or wrong user answer to the database
     * @param type $test_id
     * @param type $answers
     * @param type $correct
     */
    private function saveUserAnswer($id, $answers, $correct)
    {
        $query = $this->db->prepare('INSERT INTO `progress` (`user_id`, `test_id`, `user_answer`, `correct`, `cdate`) VALUES (:user_id, :test_id, :user_answer, :correct, :cdate)');
        
        $user_id = $this->getUserID($_SESSION['username']);
        
        $list = null;
        
        foreach ($answers as $answer) {
            $list .= $answer . ', ';
        }
        
        $answer = substr($list, 0, -2);
        
        // Fields for db:
        $data = array(
            'user_id' => $user_id,
            'test_id' => $id,
            'data' => array(),
            'cdate' => date("Y-m-d H:i:s")
        );
        
        $query->execute(array(
            ':test_data' => serialize($data)
        ));
    }
}
