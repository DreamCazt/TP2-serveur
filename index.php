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

// Endpoint pour récupérer les articles
$app->get('/api/posts', function (Request $request, Response $response, array $args) use ($db) {

    //Instantiate Post et passer la connection à la base de données
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
// Endpoint pour récupérer les information d'un seul article
$app->get('/api/posts/{id}', function (Request $request, Response $response, $args) use ($db) {
    $id = $args['id'];

    // Instantiate Post avec bd
    $post = new Post($db);

    // Get post id
    $result = $post->get($id);

    //Retour des articles en tant que réponse json
    if ($result) {
        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    } else {
        //Aucun articles trouvés
        $response->getBody()->write(json_encode(['message' => 'No posts found.']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
});

// Endpoint pour supprimer un article
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

    // Créer article(post)
    if ($post->create($titre, $image, $contenu, $categorie_id)) {
        // retourne succès réponse JSON 
        $data = ['message' => 'Post created successfully'];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    } else {
        // retourne erreur réponse JSON 
        $data = ['message' => 'Failed to create post'];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }
});

// Lancée l'application
$app->run();
