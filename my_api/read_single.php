<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

include_once('../core/initialize.php');

$id = $_GET['id'] ?? die(json_encode(['message' => 'No ID Provided']));

$post = new Post($db);

$postItem = $post->get($id);

if ($postItem) {
    echo json_encode($postItem);
} else {
    echo json_encode(['message' => 'Post not found.']);
}
