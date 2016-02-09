<?php

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
     * /**
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
     * Show all polls
     * @return array
     */
    public function showPolls()
    {
        $query = $this->db->query('SELECT `question_id`, `question` FROM `poll` ORDER BY `id`');
        
        return $query->fetchAll();
    }
    
    /**
     * Make poll visible for user
     * @param type $id
     */
    public function activatePollInDB($id)
    {
        $query = $this->db->prepare('UPDATE `poll` SET `show` = 1, `mdate` = :mdate WHERE `question_id` = :id');
        
        $query->execute(array(
            ':mdate' => date("Y-m-d H:i:s"),
            ':id' => $id
        ));
    }
    
    /**
     * Make poll hidden for user
     * @param type $id
     */
    public function disablePollInDB($id)
    {
        $query = $this->db->prepare('UPDATE `poll` SET `show` = 0, `mdate` = :mdate WHERE `question_id` = :id');
        
        $query->execute(array(
            ':mdate' => date("Y-m-d H:i:s"),
            ':id' => $id
        ));
    }
    
    /**
     * Add new poll to the database
     * @param type $question
     * @param type $answer
     * @param type $correct
     */
    public function addPollToDB($question, $answer, $correct)
    {
        $question_id = $this->getLastQuestionID() + 1;
        $rows = count($answer);
        $date = date("Y-m-d H:i:s");
        
        for ($i=0; $i < $rows; $i++) {
            
            $insert = "INSERT INTO `poll` (`question_id`, `question`, `answer`, `correct`, `show`, `cdate`, `mdate`) VALUES (:question_id, :question, :answer, :correct, :show, :cdate, :mdate)";
            
            $query = $this->db->prepare($insert);
            
            $query->execute(array(
                ':question_id' => $question_id,
                ':question' => $question,
                ':answer' => $answer[$i],
                ':correct' => $correct[$i],
                ':show' => 1,
                ':cdate' => $date,
                ':mdate' => $date)
            );
        }
    }
    
    /**
     * Delete poll from the database
     * @param type $id
     */
    public function deletePollFromDB($id)
    {
        $query = $this->db->prepare('DELETE FROM `question` WHERE `question_id` = :id');
        $query->execute(array(':id' => $id));
    }
    
    public function editPollInDB($id)
    {
        echo 'Edited';
    }
    
    /**
     * Get last poll ID from the database
     * @return int
     */
    private function getLastQuestionID()
    {
        $query = $this->db->query('SELECT MAX(`question_id`) as `id` FROM `poll`')->fetch();
        
        return (int) $query->id;
    }
}
