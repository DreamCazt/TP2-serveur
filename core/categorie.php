<?php

class Categorie
{
    private $conn;
    private $table = 'categories';

    public $id;
    public $name;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getCategories()
    {
        $query = 'SELECT * FROM ' . $this->table;

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();

        // Fetch all rows
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }
}
