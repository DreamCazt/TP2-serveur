<?php

// Aller chercher le endpoint pour les données
$url = 'http://localhost:3000/api/posts';

// Prendre les données json du enpoint 
$json_data = file_get_contents($url);

// Créer l'array posts qui est les données json décodé.
$posts = json_decode($json_data, true);

$categories = [];
$postsParCategorie = [];

foreach ($posts as $post) {
    $cat = $post['category_name'];

    // incrémente le compte de catégorie
    if (!isset($categories[$cat])) {
        $categories[$cat] = 1;
    } else {
        $categories[$cat]++;
    }

    // Ajouter les catégories à post
    if (!isset($postsParCategorie[$cat])) {
        $postsParCategorie[$cat] = [$post];
    } else {
        array_push($postsParCategorie[$cat], $post);
    }
}

$selectedCat = $_GET['cat'] ?? false;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'includes/head.php' ?>
    <link rel="stylesheet" href="public/css/index.css">
    <title>Blog</title>
</head>

<body>
    <div class="container">
        <?php require_once 'includes/header.php' ?>
        <div class="content">
            <div class="newsfeed-container">
                <div class="categorie-container">
                    <ul>
                        <li class=<?= $selectedCat ? '' : 'cat-active' ?>>
                            <a href="main.php">Tous les articles <span class="small">(<?= count($posts) ?>)</span></a>
                        </li>
                        <!-- Libelles des toutes les categories -->
                        <?php foreach ($categories as $catName => $catNum) : ?>
                            <li class=<?= $selectedCat === $catName ? "cat-active" : '' ?>>
                                <a href="main.php?cat=<?= $catName ?>"><?= $catName ?><span class="small">
                                        (<?= $catNum ?>)
                                    </span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="newsfeed-content">
                <?php if (!$selectedCat) : ?>
                    <?php foreach ($categories as $cat => $num) : ?>
                        <h2><?= $cat ?></h2>
                        <div class="articles-container">
                            <?php foreach ($postsParCategorie[$cat] as $post) : ?>
                                <div class="article block">
                                    <a href="#" class="delete-logo" style="color: red;" onclick="deletePost(<?= $post['id'] ?>);">
                                        X
                                    </a>
                                    <a href="/show-article.php?id=<?= $post['id'] ?>">

                                        <!-- Image -->
                                        <div class="overflow">
                                            <img class="img-container" src="<?= $post['image'] ?>">
                                        </div>
                                        <!-- Titre -->
                                        <h3>
                                            <?= $post['titre'] ?>
                                        </h3>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <h2><?= $selectedCat ?></h2>

                    <div class="articles-container">
                        <?php foreach ($postsParCategorie[$selectedCat] as $post) : ?>
                            <a href="/show-article.php?id=<?= $post['id'] ?>" class="article block">
                                <!-- Image -->
                                <div class="overflow">
                                    <img class="img-container" src="<?= $post['image'] ?>">
                                </div>
                                <!-- Titre -->
                                <h3>
                                    <?= $post['titre'] ?>
                                </h3>
                            </a>
                        <?php endforeach; ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php require_once 'includes/footer.php' ?>
        <script src="/public/js/index.js"></script>

</body>

</html>