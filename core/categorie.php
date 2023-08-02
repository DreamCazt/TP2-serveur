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

    public function read()
    {
        $query = 'SELECT name FROM categories';
    }
}
