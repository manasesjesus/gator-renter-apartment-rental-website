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

    public function createApartment($fields, $values) {
        $fields = join(", ", $fields);
        $values = join("', '", $values);
        $sql = "INSERT INTO apartments (" . $fields . ") VALUES ('" . $values . "')";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $this->getApartment($this->db->lastInsertId())[0];
    }

    public function deleteApartment($apartment_id) {
        $sql = "DELETE FROM apartments WHERE id = :apartment_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':apartment_id' => $apartment_id);
        $query->execute($parameters);
    }

}