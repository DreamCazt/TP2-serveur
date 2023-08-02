<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application.json');

include_once('../core/initialize.php');

//instantiate post
$post = new Post($db);

//blog post query
$result = $post->read();

//get row count
$num = $result->rowcount();

if ($num > 0) {
    $post_arr = array();
    $post_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $post_item = array(
            'id' => $id,
            'titre' => $titre,
            'image' => $image,
            'contenu' => $contenu,
            'category_id' => $category_id
        );
        array_push($post_arr['data'], $post_item);
    }


    // convert to json and output
    // this is the json you are always getting as a response from this endpoint
    echo json_encode($post_arr);
} else {
    echo json_encode(array('message' => 'No posts found.'));
}
