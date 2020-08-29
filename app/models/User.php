<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Connection();
    }

    public function login($username, $password)
    {
        $sql = 'SELECT * FROM users WHERE username = :username';
        //Prepare
        $this->db->query($sql);
        //Bind
        $this->db->bind(':username', $username);

        //Execute
        $row = $this->db->single();

        $db_password = $row->password;
        if ($password == $db_password) {
            return $row;
        } else {
            return false;
        }
    }

    //Reset password
    public function reset($id, $newpassword)
    {
        $sql = "UPDATE users SET password = :newpassword WHERE id = :id";

        $this->db->query($sql);
        $this->db->bind(':newpassword', $newpassword);
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //Find user by username
    public function findUserByUsername($username)
    {
        $sql = 'SELECT * FROM users WHERE username = :username';
        $this->db->query($sql);
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        //check if row is 1 or 0
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserById($id)
    {
        $sql = 'SELECT * FROM users WHERE id = :id';
        $this->db->query($sql);
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;
    }

    public function getDepartment($dep_id)
    {

        $sql = 'SELECT * FROM departments WHERE id = :dep_id';
        $this->db->query($sql);
        $this->db->bind(':dep_id', $dep_id);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $row;
        }
        else{
            return false;
        }
    }

    public function updateUserProfile($data)
    {

      $sql = "UPDATE users SET first_name = :fname, last_name = :lname, email = :bEmail, date_of_birth = :dob, address= :bAddress, phone= :bPhone WHERE id = :bId;";
      $this->db->query($sql);
        // Bind variables to the prepared statement as parameters
        $this->db->bind(":bId", $data->id, PDO::PARAM_INT);
        $this->db->bind(":fname", $data->first_name, PDO::PARAM_STR);
        $this->db->bind(":lname", $data->last_name, PDO::PARAM_STR);
        $this->db->bind(":bEmail", $data->email, PDO::PARAM_STR);
        $this->db->bind(":dob", $data->date_of_birth, PDO::PARAM_STR);
        $this->db->bind(":bAddress", $data->address, PDO::PARAM_STR);
        $this->db->bind(":bPhone", $data->phone, PDO::PARAM_STR);

        // execute query
        return $this->db->execute();
    }

    public function updateProfileImg($userID, $img)
    {
        $sql = "UPDATE users SET img = :img WHERE id = :id;";
        $this->db->query($sql);
        // Bind variables to the prepared statement as parameters
        $this->db->bind(":id", $userID, PDO::PARAM_STR);
        $this->db->bind(":img", $img, PDO::PARAM_STR);

        //image file directory
        $target = "img/".basename($img);

        // execute query
        $this->db->execute();

        if (move_uploaded_file($_FILES['newImg']['tmp_name'], $target))
        {
            $_SESSION['profileImg'] = $img;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getAvailability($id)
    {
      $sql = 'SELECT * FROM employee_availability WHERE user_id = :id';
      $this->db->query($sql);
      $this->db->bind(':id', $id);

      $row = $this->db->single();
      return $row;
    }

    public function updateAvailability($id, $availability)
    {
      $sql = 'UPDATE employee_availability SET monday= :m, tuesday= :t, wednesday= :w, thursday= :th, friday = :f, saturday= :s WHERE user_id= :id;';
      $this->db->query($sql);
      $this->db->bind(":id", $id, PDO::PARAM_INT);
      $this->db->bind(":m", $availability['monday'], PDO::PARAM_STR);
      $this->db->bind(":t", $availability['tuesday'], PDO::PARAM_STR);
      $this->db->bind(":w", $availability['wednesday'], PDO::PARAM_STR);
      $this->db->bind(":th", $availability['thursday'], PDO::PARAM_STR);
      $this->db->bind(":f", $availability['friday'], PDO::PARAM_STR);
      $this->db->bind(":s", $availability['saturday'], PDO::PARAM_STR);

      $this->db->execute();
    }
}
