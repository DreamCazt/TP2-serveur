<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../core/initialize.php';

$post = new Post($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if (
    !empty($data->id) &&
    !empty($data->titre) &&
    !empty($data->image) &&
    !empty($data->contenu) &&
    !empty($data->categorie)
) {
    // set product property values
    $id = $data->id;
    $title = $data->title;
    $image = $data->image;
    $contenu = $data->contenu;
    $categorie = $data->categorie;

    // update the post
    if ($post->update($id, $titre, $image, $categorie, $contenu)) {
        echo json_encode(["message" => "Post was updated."]);
    } else {
        echo json_encode(["message" => "Unable to update post."]);
    }
} else {
    echo json_encode(["message" => "Unable to update post. Data is incomplete."]);
}
