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
                            <a href="/">Tous les articles <span class="small">(<?= count($articles) ?>)</span></a>
                        </li>
                        <!-- Libelles des toutes les categories -->
                        <?php foreach ($categories as $catName => $catNum) : ?>
                            <li class=<?= $selectedCat === $catName ? "cat-active" : '' ?>>
                                <a href="/?cat=<?= $catName ?>"><?= $catName ?><span class="small">
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
                            <?php foreach ($articlesParCategorie[$cat] as $a) : ?>
                                <a href="/show-article.php?id=<?= $a['id'] ?>" class="article block">
                                    <!-- Image -->
                                    <div class="overflow">
                                        <img class="img-container" src="<?= $a['image'] ?>">
                                    </div>
                                    <!-- Titre -->
                                    <h3>
                                        <?= $a['titre'] ?>
                                    </h3>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <h2><?= $selectedCat ?></h2>

                    <div class="articles-container">
                        <?php foreach ($articlesParCategorie[$cat] as $a) : ?>
                            <a href="/show-article.php?id=<?= $a['id'] ?>" class="article block">
                                <!-- Image -->
                                <div class="overflow">
                                    <img class="img-container" src="<?= $a['image'] ?>">
                                </div>
                                <!-- Titre -->
                                <h3>
                                    <?= $a['titre'] ?>
                                </h3>
                            </a>
                        <?php endforeach; ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php require_once 'includes/footer.php' ?>

</body>

</html>