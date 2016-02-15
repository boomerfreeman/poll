<?php

/**
 * Main model class
 */
class Model
{
    /**
     * Database connection
     * @return connection handle
     */
    public function __construct()
    {
        require_once '/config/config.php';
        
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
            
            if (($username == $user_db) && (md5($password) == $pass_db)) {
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
        $query = $this->db->prepare('SELECT `id` FROM `user` WHERE `username` = :username');
        $query->execute(array(':username' => $username));
        
        return $query->fetch()->id;
    }
    
    /**
     * Show all tests
     * @return object
     */
    public function showTests()
    {
        $query = $this->db->query('SELECT `question_id`, `question` FROM `test` ORDER BY `question_id`');
        
        return $query->fetchAll();
    }
    
    /**
     * Show active tests for user
     * @return object
     */
    public function showActiveTests()
    {
        $query = $this->db->query('SELECT `question_id`, `question` FROM `test` WHERE `show` = 1 ORDER BY `question_id`');
        
        return $query->fetchAll();
    }
    
    /**
     * Make test visible for user
     * @param type $id
     */
    public function activateTestInDB($id)
    {
        $query = $this->db->prepare('UPDATE `test` SET `show` = 1, `mdate` = :mdate WHERE `question_id` = :id');
        
        $query->execute(array(
            ':mdate' => date("Y-m-d H:i:s"),
            ':id' => $id
        ));
    }
    
    /**
     * Make test hidden for user
     * @param type $id
     */
    public function disableTestInDB($id)
    {
        $query = $this->db->prepare('UPDATE `test` SET `show` = 0, `mdate` = :mdate WHERE `question_id` = :id');
        
        $query->execute(array(
            ':mdate' => date("Y-m-d H:i:s"),
            ':id' => $id
        ));
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
    public function addTestToDB($question, $answers, $correct, $question_id = null)
    {
        if ($question_id == null) {
            $question_id = $this->getLastQuestionID() + 1;
        }
        
        $rows = count($answers);
        
        for ($i=0; $i < $rows; $i++) {
            
            $insert = "INSERT INTO `test` (`question_id`, `question`, `answer`, `correct`, `show`, `cdate`, `mdate`) VALUES (:question_id, :question, :answer, :correct, :show, :cdate, :mdate)";
            
            $query = $this->db->prepare($insert);
            
            $query->execute(array(
                ':question_id' => $question_id,
                ':question' => $question,
                ':answer' => $answers[$i],
                ':correct' => $correct[$i],
                ':show' => 1,
                ':cdate' => date("Y-m-d H:i:s"),
                ':mdate' => date("Y-m-d H:i:s")
            ));
        }
    }
    
    /**
     * Delete test from the database
     * @param type $id
     */
    public function deleteTestFromDB($id)
    {
        $query = $this->db->prepare('DELETE FROM `test` WHERE `question_id` = :id');
        $query->execute(array(':id' => $id));
    }
    
    /**
     * Fetch test data with certain ID
     * @param type $id
     * @return object
     */
    public function getTestData($id)
    {
        $query = $this->db->prepare('SELECT `question_id`, `question`, `answer`, `correct`, `show` FROM `test` WHERE `question_id` = :id');
        $query->execute(array(':id' => $id));
        
        return $query->fetchAll();
    }
    
    /**
     * Control user selected asnwers
     * @param type $id
     * @param type $answers
     * @return boolean
     */
    public function controlUserAnswer($id, $answers)
    {
        $query = $this->db->prepare('SELECT `answer` FROM `test` WHERE `question_id` = :id AND `correct` = 1');
        $query->execute(array(':id' => $id));
        
        $result = $query->fetchAll();
        
        $user_answers = count($answers);
        $db_answers = $query->rowCount();
        
        if ($db_answers > 0) {
            
            if ($user_answers != $db_answers) {
                $this->saveUserAnswer($id, $answers, 0);
                return false;
            } else {
                $i = 0;
                $true = 0;
                
                foreach ($result as $row => $link) {
                    if ($answers[$i] == $link->answer) {
                        $true++;
                        $i++;
                    }
                }
                
                if ($true != $db_answers) {
                    $this->saveUserAnswer($id, $answers, 0);
                    return false;
                } else {
                    $this->saveUserAnswer($id, $answers, 1);
                    return true;
                }
            }
        }
    }
    
    /**
     * Save right or wrong user answer to the database
     * @param type $question_id
     * @param type $answers
     * @param type $correct
     */
    private function saveUserAnswer($question_id, $answers, $correct)
    {
        $query = $this->db->prepare('INSERT INTO `progress` (`user_id`, `question_id`, `user_answer`, `correct`, `cdate`) VALUES (:user_id, :question_id, :user_answer, :correct, :cdate)');
        
        $user_id = $this->getUserID($_SESSION['username']);
        
        $list = null;
        
        foreach ($answers as $answer) {
            $list .= $answer . ', ';
        }
        
        $answer = substr($list, 0, -2);
        
        $query->execute(array(
            ':user_id' => $user_id,
            ':question_id' => $question_id,
            ':user_answer' => $answer,
            ':correct' => $correct,
            ':cdate' => date("Y-m-d H:i:s")
        ));
    }
    
    /**
     * Get last test ID from the database
     * @return int
     */
    private function getLastQuestionID()
    {
        $query = $this->db->query('SELECT MAX(`question_id`) as `id` FROM `test`');
        
        $res = $query->fetch();
        
        $rows = $query->rowCount();
        
        if ($rows > 0) {
            $max = $res->id;
        } else {
            $max = 0;
        }
        
        return $max;
    }
}
