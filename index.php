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
$app->get('/api/posts/{id}', function (Request $request, Response $response, $args) use ($db) {
    $id = $args['id'];

    // Instantiate the Post model with the database connection
    $post = new Post($db);

    // Get the post
    $result = $post->get($id);

    // If the post was found, render the view with the post data
    if ($result) {
        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    } else {
        //Aucun articles trouvés
        $response->getBody()->write(json_encode(['message' => 'No posts found.']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
});

// Définition d'une route pour supprimer un article
$app->delete('/api/post/delete/{id}', function (Request $request, Response $response, $args) use ($db) {
    // Get the post ID from the URL
    $id = $args['id'];

    // Instantiation du modèle Post en passant la connexion à la base de données
    $post = new Post($db);

    // Suppression de l'article
    if ($post->delete($id)) {
        // Retour d'une réponse JSON de succès
        $data = ['message' => 'Post deleted successfully'];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    } else {
        // Retour d'une réponse JSON d'erreur
        $data = ['message' => 'Failed to delete post'];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }
});


// Définition d'une route pour Créer un post
$app->post('/api/post/create', function (Request $request, Response $response, $args) use ($db) {

    // Récupération des données mises à jour du post depuis le corps de la requête
    $data = $request->getParsedBody();
    $titre = $data['titre'] ?? '';
    $image = $data['image'] ?? '';
    $contenu = $data['contenu'] ?? '';
    $categorie = $data['categorie_id'] ?? '';

    // Validation
    if (!$titre) {
        $errors['titre'] = 'Saisir le titre svp !';
    }

    if (!$image) {
        $errors['image'] = "Entrer l'URL de l'image svp !";
    } elseif (!filter_var($image, FILTER_VALIDATE_URL)) {
        $errors['image'] = "Entrer une URL valide de l'image svp ! ";
    }

    if (!$categorie) {
        $errors['categorie'] = 'Saisir la catégorie svp !';
    }

    if (!$contenu) {
        $errors['contenu'] = 'Saisir le contenu svp !';
    }


    // Instantiation du modèle Post en passant la connexion à la base de données
    $post = new Post($db);

    // Récupérer le id du nom de catégorie
    $categorie_id = $post->getCategoryId($categorie);

    // Update the post
    if ($post->create($titre, $image, $contenu, $categorie_id)) {
        // Return a success JSON response
        $data = ['message' => 'Post created successfully'];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    } else {
        // Return an error JSON response
        $data = ['message' => 'Failed to create post'];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }
});

//Run Slim app
$app->run();
