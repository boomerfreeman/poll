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
    
    public function showPolls()
    {
        $query = $this->db->query('SELECT `question_id`, `question` FROM `poll` ORDER BY `id`');
        
        return $query->fetchAll();
    }
    
    public function activatePollInDB($id)
    {
        $query = $this->db->prepare('UPDATE `poll` SET `show` = 1 WHERE `question_id` = :id');
        $query->execute(array(':id' => $id));
    }
    
    public function disablePollInDB($id)
    {
        $query = $this->db->prepare('UPDATE `poll` SET `show` = 0 WHERE `question_id` = :id');
        $query->execute(array(':id' => $id));
    }
    
    public function addPollToDB()
    {
        $query = $this->db->query('SELECT `question` FROM `poll` ORDER BY `id`');
        
        return $query->fetchAll();
    }
    
    public function deletePollFromDB()
    {
        $query = $this->db->query('SELECT `question` FROM `poll` ORDER BY `id`');
        
        return $query->fetchAll();
    }
}
