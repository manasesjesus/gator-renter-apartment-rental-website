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
        $sql = "SELECT * FROM apartments";
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

}