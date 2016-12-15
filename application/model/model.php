<?php


/*
 * Modified by: 
 * - Manasés Galindo
 * - Anil Manzoor
 */
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
        else if ($userId == "admin") {
            $sql = "CALL getAllUsersDetails(null);";
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

        $query->execute($parameters);
        return $query->fetch();
    }

    //DELETE a user, it's a soft delete
    public function deleteUser($userId) {

        $sql = "UPDATE `users` SET `is_active`='0' WHERE `uid`= :userId ";
        $query = $this->db->prepare($sql);
        $parameters = array(':userId' => $userId);

        return $query->execute($parameters);

    }

    //Toggle a user status
    public function toggleUser($data) {

        $sql = "UPDATE `users` SET `is_active`= :status WHERE `uid`= :userId ";
        $query = $this->db->prepare($sql);
        $parameters = array(':userId' => $data['uid'], ':status' => $data['status']);

        return $query->execute($parameters);

    }

    /**
     * Get a user information from database by user email address
     */
    public function getUserInfo($user_email)
    {
        $sql = "SELECT * FROM users WHERE email = :user_email AND is_active = 1 LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':user_email' => $user_email);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
        return $query->fetch();
    }
    
    /*
     * Save a new Mesasge from a User to another.
     */
    public function saveNewMessage($data) {
        
        $sql = "CALL addMessage(:in_from_user_id, :in_to_user_id, :in_apartment_id, :in_message)";

        $query = $this->db->prepare($sql);

        $parameters = array(
            ':in_from_user_id' => $data['from_user_id'],
            ':in_to_user_id' => $data['to_user_id'],
            ':in_apartment_id' => $data['apartment_id'],
            ':in_message' => $data['message']);

        $status = $query->execute($parameters);
        return $status;
    }

    /*
     * Get latest message received to a user from a particular or any user for a 
     * any or a particular apartment 
     */
    public function getMessages($data)
    {
        $sql = "CALL getMessages(:email, :apartment_id, :fromuser_email, :page_number, :page_size)";

        $query = $this->db->prepare($sql);

        $parameters = array(
            ':email' => $data['email'],
            ':apartment_id' => empty($data['apartment_id']) ? null : $data['apartment_id'],
            ':fromuser_email' => empty($data['fromuser_email']) ? null : $data['fromuser_email'],
            ':page_number' => $data['page_number'],
            ':page_size' => empty($data['page_size']) ? 10 : $data['page_size']);

        $status = $query->execute($parameters);
        
        
        if ($status != true) {
            throw new Exception ();
        }

        return $query->fetchall();
    }
    
    /*
     * Get conversation received to a user from a particular user for
     * any or a particular apartment 
     */
    public function getConversation($data)
    {
        $sql = "CALL getConversation(:email, :apartment_id, :fromuser_email, :page_number, :page_size)";

        $query = $this->db->prepare($sql);
        
        $parameters = array(
            ':email' => $data['email'],
            ':apartment_id' => empty($data['apartment_id']) ? null : $data['apartment_id'],
            ':fromuser_email' => $data['fromuser_email'],
            ':page_number' => $data['page_number'],
            ':page_size' => empty($data['page_size']) ? 10 : $data['page_size']);

        $status = $query->execute($parameters);
        
        if ($status != true) {
            throw new Exception ();
        }
        
        return $query->fetchall();
    }
    
    /*
     * Search apartments across a combination of different paramters
     */
    public function searchApartment($data)
    {
        $sql = "CALL getApartments(
            :private_room, 
            :private_bath, 
            :kitchen_in_apartment, 
            :has_security_deposit, 
            :credit_score_check, 
            :owner_id, 
            :apartment_id, 
            :monthly_rent_min, 
            :monthly_rent_max,
            :email,
            :get_only_user_fav,
            :page_number,
            :page_size)";
        
        $query = $this->db->prepare($sql);
        
        $parameters = array(
            ':private_room' => empty($data['private_room']) ? null : $data['private_room'],
            ':private_bath' => empty($data['private_bath']) ? null : $data['private_bath'],
            ':kitchen_in_apartment' => empty($data['kitchen_in_apartment']) ? null : $data['kitchen_in_apartment'],
            ':has_security_deposit' => empty($data['has_security_deposit']) ? null : $data['has_security_deposit'],
            ':credit_score_check' => empty($data['credit_score_check']) ? null : $data['credit_score_check'],
            ':owner_id' => empty($data['owner_id']) ? null : $data['owner_id'],
            ':apartment_id' => empty($data['owner_id']) ? null : $data['owner_id'],
            ':monthly_rent_min' => empty($data['monthly_rent_min']) ? null : $data['monthly_rent_min'],
            ':monthly_rent_max' => empty($data['monthly_rent_max']) ? null : $data['monthly_rent_max'],
            ':email' => empty($data['email']) ? null : $data['email'],
            ':get_only_user_fav' => empty($data['get_only_user_fav']) ? null : $data['get_only_user_fav'],
            ':page_number' => $data['page_number'],
            ':page_size' => empty($data['page_size']) ? 10 : $data['page_size']);
        
        $status = $query->execute($parameters);
        
        if ($status != true) {
            throw new Exception ();
        }
        
        return $query->fetchall();
    }
    
    /*
     * Add favortie apartment against a user
     */
    public function addFavApartment($data)
    {
        $sql = "CALL addFavApartment(:apartment_id, :email)";

        $query = $this->db->prepare($sql);
        
        $parameters = array(
            ':apartment_id' => $data['apartment_id'],
            ':email' => $data['email']);

        $status = $query->execute($parameters);
        
        if ($status != true) {
            throw new Exception ();
        }
        
        return $status;
    }
    
    /*
     * Add favourite apartment against a user
     */
    public function addFavouriteApartment($data)
    {
        $sql = "CALL addFavApartment(:apartment_id, :email)";

        $query = $this->db->prepare($sql);
        
        $parameters = array(
            ':apartment_id' => $data['apartment_id'],
            ':email' => $data['email']);

        $status = $query->execute($parameters);
        
        if ($status != true) {
            throw new Exception ();
        }
        
        return $status;
    }
    
    /*
     * Delete favourite apartment against a user
     */
    public function deleteFavouriteApartment($data)
    {
        $sql = "CALL deleteFavApartment(:apartment_id, :email)";

        $query = $this->db->prepare($sql);
        
        $parameters = array(
            ':apartment_id' => $data['apartment_id'],
            ':email' => $data['email']);

        $status = $query->execute($parameters);
        
        if ($status != true) {
            throw new Exception ();
        }
        
        return $status;
    }
    
    /*
     * Get new messages count for a user
     */
    public function getNewMessagesCount($data) 
    {
        $sql = "CALL hasNewMessages(:email)";
        
        $query = $this->db->prepare($sql);
         
        $parameters = array(':email' => $data['email']);    
        
        $status = $query->execute($parameters);
        
        if ($status != true) {
            throw new Exception ();
        }
        
        return $query->fetch();
    }

}