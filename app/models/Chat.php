<?php

class Chat
{
    private $db;

    public function __construct()
    {
        $this->db = new Connection();
    }

    //methods

    public function getPreviousMessages()
    {
        $sql = 'SELECT * from messages';
        $this->db->query($sql);

        $result = $this->db->result();

        return $result;
    }

    public function saveMessage($message)
    {
        $sql = 'Insert into messages (user_id, user_name, message) VALUES (:user_id,:user_name ,:message)';
        $this->db->query($sql);

        $this->db->bind('user_id', $_SESSION['user_id']);
        $this->db->bind('user_name', $_SESSION['name']);
        $this->db->bind('message', $message);

        if($this->db->execute()){
            return true;
        }
        else{
            return false;
        }
    }
}
