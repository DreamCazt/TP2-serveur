<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Methods: DELETE');

include_once('../core/initialize.php');

// Get ID from URL
$id = isset($_GET['id']) ? $_GET['id'] : die(json_encode(array('message' => 'ID not provided.')));

// Instantiate Post
$post = new Post($db);

// Set the ID to be deleted
$post->id = $id;

// Delete Post
if ($post->delete($id)) {
    echo json_encode(array('message' => 'Post deleted.'));
} else {
    echo json_encode(array('message' => 'Post not deleted.'));
}
