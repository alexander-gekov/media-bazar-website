<?php

class Shift
{
    private $db;

    public function __construct()
    {
        $this->db = new Connection();
    }

    //methods

    public function getShiftsByUserId($id)
    {
        $sql = 'SELECT * from all_shifts WHERE user_id = :userId';
        $this->db->query($sql);
        $this->db->bind('userId', $id);

        $result = $this->db->result();

        return $result;
    }

    public function getAllShiftRequests($id)
    {
        $sql = 'SELECT * from shift_requests WHERE user_id = :userId';
        $this->db->query($sql);
        $this->db->bind('userId', $id);

        $result = $this->db->result();

        return $result;
    }

    public function Chill($shift_id, $user_id)
    {
        $sql = 'Insert into shift_requests (shift_id, user_id) VALUES (:shift_id, :user_id)';
        $this->db->query($sql);
        $this->db->bind('shift_id', $shift_id);
        $this->db->bind('user_id', $user_id);

        $this->db->execute();
    }

    public function Work($shift_id, $user_id)
    {
        $sql = 'Insert into shift_requests (shift_id, user_id, `work`) VALUES (:shift_id, :user_id, 1)';
        $this->db->query($sql);
        $this->db->bind('shift_id', $shift_id);
        $this->db->bind('user_id', $user_id);

        $this->db->execute();
    }

    public function getCurrentShift($shift_id, $user_id)
    {
        $sql = "Select * from all_shifts where shift_id = :shift_id and user_id = :user_id";
        $this->db->query($sql);
        $this->db->bind('shift_id', $shift_id);
        $this->db->bind('user_id', $user_id);

        $result = $this->db->single();

        return $result;
    }

    public function Start($shift_id, $user_id)
    {
        $sql = "UPDATE all_shifts SET start_shift = :now where shift_id = :shift_id and user_id = :user_id";
        $this->db->query($sql);
        $this->db->bind('shift_id', $shift_id);
        $this->db->bind('user_id', $user_id);
        $this->db->bind('now', date('Y-m-d H:i:s'));

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function Stop($shift_id, $user_id)
    {
        $sql = "UPDATE all_shifts SET end_shift = :now where shift_id = :shift_id and user_id = :user_id";
        $this->db->query($sql);
        $this->db->bind('shift_id', $shift_id);
        $this->db->bind('user_id', $user_id);
        $this->db->bind('now', date('Y-m-d H:i:s'));

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
