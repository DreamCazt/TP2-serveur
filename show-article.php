<?php
$id = $_GET['id'] ?? ''; // GET id from url

$url = "http://localhost:3000/api/posts/$id";
$json = file_get_contents($url);


$post = json_decode($json, true);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once 'includes/head.php' ?>
    <link rel="stylesheet" href="public/css/show-article.css">
    <title>Article</title>
</head>

<body>
    <div class="container">
        <?php require_once 'includes/header.php' ?>
        <div class="content">
            <div class="article-container">
                <a href="main.php" class="article-back">Retour à la liste des articles</a>
                <img class="article-cover-img" src="<?= $post['image'] ?>">
                <h1 class="article-title"><?= $post['titre'] ?></h1>
                <div class="separator"></div>
                <p class="article-content"><?= $post['contenu'] ?></p>
            </div>
        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>
</body>

</html>