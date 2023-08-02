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
