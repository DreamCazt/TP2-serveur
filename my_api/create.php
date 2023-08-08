<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once('../core/initialize.php');

// Instantiate post
$post = new Post($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->titre) && !empty($data->image) && !empty($data->contenu) && !empty($data->$categorie)) {
    $post->titre = $data->titre;
    $post->image = $data->image;
    $post->contenu = $data->contenu;
    $post->$categorie = $data->$categorie;

    // Create post
    if ($post->create($titre, $image, $contenu, $categorie)) {
        echo json_encode(
            array('message' => 'Post Created')
        );
    } else {
        echo json_encode(
            array('message' => 'Post Not Created')
        );
    }
} else {
    echo json_encode(
        array('message' => 'Incomplete data')
    );
}
