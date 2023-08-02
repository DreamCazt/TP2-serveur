<?php
//this represent my model wich is the mapping of my database
class Post
{
    //db
    private $conn;
    private $table = 'posts';

    //post properties
    public $id;
    public $titre;
    public $image;
    public $categorie;
    public $contenu;

    //constructor with db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        //create query
        $query = 'SELECT posts.*, categories.name as category_name
                  FROM ' . $this->table . ' posts JOIN 
                  categories ON posts.category_id = categories.id';

        //prepare statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute();
        return $stmt;
    }

    public function delete($id)
    {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind parameter
        $stmt->bindParam(':id', $id);

        // Execute query
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function update($id, $title, $body)
    {
        // Create query
        $query = 'UPDATE ' . $this->table . ' SET title = :title, body = :body WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':body', $body);

        // Execute query
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update_title($id, $title)
    {
        // Create query
        $query = 'UPDATE ' . $this->table . ' SET title = :title WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);

        // Execute query
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
