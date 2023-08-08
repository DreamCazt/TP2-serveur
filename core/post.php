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
                  categories ON posts.categorie_id = categories.id';

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


    public function update($id, $titre, $image, $contenu, $categorie)
    {
        // Create query
        $query = 'UPDATE ' . $this->table .
            ' SET titre = :titre, image = :image, contenu = :contenu, categorie_id = :categorie_id WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':contenu', $contenu);
        $stmt->bindParam(':categorie_id', $categorie);

        // Execute query
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Aller chercher le id du post
    public function get($id)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        } else {
            return false;
        }
    }


    public function create($titre, $image, $contenu, $categorie)
    {
        $query = 'INSERT INTO ' . $this->table . '(titre, image, contenu, categorie_id)
        VALUES (?, ?, ?, ?)';

        $stmt = $this->conn->prepare($query);

        $result = $stmt->execute([$titre, $image, $contenu, $categorie]);

        return $result;
    }

    public function getCategoryId($name)
    {
        // Prepare the query
        $query = 'SELECT id FROM categories WHERE name = ?';
        $stmt = $this->conn->prepare($query);

        // Execute the query
        $stmt->execute([$name]);

        // Fetch the category
        $category = $stmt->fetch();

        // Return the ID
        return $category['id'];
    }
}
