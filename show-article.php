<?php
$filename = __DIR__ . '/public/data/articles.json';

$posts = [];
$GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = $_GET['id'] ?? '';



// Si l'id n'est pas défénit, rediriger vers l'index.php
if (!$id) {
    header('Location: /');
} else {
    if (file_exists($filename)) {
        $articles = json_decode(file_get_contents($filename), true) ?? '';
        $articlesIndex = array_search($id, array_column($articles, $id));
        $article = $articles[$articlesIndex];
    }
}
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
                <a href="/" class="article-back">Retour à la liste des articles</a>
                <img class="article-cover-img" src="<?= $article['image'] ?>">
                <h1 class="article-title"><?= $article['titre'] ?></h1>
                <div class="separator"></div>
                <p class="article-content"><?= $article['contenu'] ?></p>
            </div>
        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>
</body>

</html>