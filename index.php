<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Slim\Middleware\MethodOverrideMiddleware; // needs to be enabled in the case of delete
use \DI\Container;
use \Slim\Factory\AppFactory;


require_once __DIR__ . '/vendor/autoload.php';

//configuration file 
require_once __DIR__ . '/includes/config.php';

//Model file
require_once __DIR__ . '/core/post.php';

//Create new container
$container = new Container();

//Create new Slim application instance with container
$app = AppFactory::create(null, $container);

//Activation de la surcharge de méthode (dans le cas delete)
$app->addRoutingMiddleware();
$app->add(MethodOverrideMiddleware::class);

//Définition d'une route pour récupérer les articles
$app->get('/api/posts', function (Request $request, Response $response, array $args) use ($db) {

    //Instantiate the Post model and pass the database connection
    $post = new Post($db);

    //Récupérer des articles depuis la base de données
    $result = $post->read();

    //vérifier si des articles ont été trouvés
    if ($result->rowCount() > 0) {
        $posts = $result->fetchAll(PDO::FETCH_ASSOC);

        //Retour des articles en tant que réponse json
        $response->getBody()->write(json_encode($posts));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    } else {

        //Aucun articles trouvés
        $response->getBody()->write(json_encode(['message' => 'No posts found.']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
});

//Run Slim app
$app->run();



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