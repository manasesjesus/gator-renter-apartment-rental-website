<?php

class Model
{
    /**
     * @param object $db A PDO database connection
     */
    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function getAllApartments() {
        $sql = "SELECT * FROM apartments ORDER BY id desc";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getApartment($apartment_id) {
        $sql = "SELECT * FROM apartments WHERE id = :apartment_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':apartment_id' => $apartment_id);
        $query->execute($parameters);
        return $query->fetchAll();
    }

    public function getOwnersApartments($owner_id) {
        $sql = "SELECT * FROM apartments WHERE owner_id = :owner_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':owner_id' => $owner_id);
        $query->execute($parameters);
        return $query->fetchAll();
    }

    public function createApartment($fields, $values, $pics) {
        $fields = join(", ", $fields);
        $values = join("', '", $values);
        $sql = "INSERT INTO apartments (" . $fields . ") VALUES ('" . $values . "')";
        $query = $this->db->prepare($sql);
        $query->execute();
        $lastId = $this->db->lastInsertId();
        if(sizeof($pics) > 0) {
            foreach($pics as $key => $value) {
                $sql = "INSERT INTO pictures (apartment_id, URL) VALUES (" . $lastId . ", '" . $value . "');";
                $query = $this->db->prepare($sql);
                $query->execute();
            }
        }
        $apt = $this->getApartment($lastId)[0];
        $pics = $this->getPictures($lastId);
        $apt->pictures = $pics;
        return $apt;
    }

    public function deleteApartment($apartment_id) {
        $sql = "DELETE FROM apartments WHERE id = :apartment_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':apartment_id' => $apartment_id);
        $query->execute($parameters);
    }

    public function getPictures($apartment_id) {
        $sql = "SELECT URL FROM pictures WHERE apartment_id = :apartment_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':apartment_id' => $apartment_id);
        $query->execute($parameters);
        return $query->fetchAll();
    }

    /**
     * Get a user information from database by user email address
     */
    public function getUserInfoById($userId)
    {
        if($userId == null)
        {
            $sql = "CALL getUserDetail(null);";
        }
        else
        {
            $sql = "CALL getUserDetail(\" $userId \");";
        }

        $query = $this->db->prepare($sql);

        $query->execute();

        // fetch() is the PDO method that get exactly one result
        return $query->fetchall();
    }

    // saving new user in the database
    public function saveNewUser($data) {

        $sql = "INSERT INTO users (first_name, last_name, email, password, address, city, created, user_roles_id, is_active) " .
            " VALUES (:first_name, :last_name, :email, :password, :address, :city, :creationDate, :userRoleId, :isActive)";
        $query = $this->db->prepare($sql);
        $parameters = array(':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'],
            ':email' => $data['email'],
            ':password' => $data['password'],
            ':address' => $data['address'],
            ':city' => $data['city'],
            ':creationDate' => Helper::getCurrentMySQLFormatTime(),
            ':userRoleId' => $data['role_type_id'],
            ':isActive' => 1 );

        $query->execute($parameters);

        //setting response
        $userId = $this->db->lastInsertId();
        $data['user_id'] = $userId;
        unset($data['password']);

        return $data;

    }

    // update user in the database
    public function updateUser($data) {

        $sql = "CALL updateUserDetail(:email, :first_name, :last_name, :address, :city)";

        $query = $this->db->prepare($sql);

        $parameters = array(
            ':email' => $data['email'],
            ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'],
            ':address' => $data['address'],
            ':city' => $data['city']);

        $status = $query->execute($parameters);
        return $status;
    }

    //DELETE a user, it's a soft delete
    public function deleteUser($userId) {

        $sql = "UPDATE `users` SET `is_active`='0' WHERE `uid`= :userId ";
        $query = $this->db->prepare($sql);
        $parameters = array(':userId' => $userId);

        return $query->execute($parameters);

    }

    /**
     * Get a user information from database by user email address
     */
    public function getUserInfo($user_email)
    {
        $sql = "SELECT * FROM users WHERE email = :user_email LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':user_email' => $user_email);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
        return $query->fetch();
    }

}