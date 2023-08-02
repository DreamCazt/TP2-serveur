<?php
$filename = __DIR__ . '/public/data/articles.json';
print_r($filename);
$errors = [
    'titre' => '',
    'image' => '',
    'categorie' => '',
    'contenu' => '',
];
// Essayer toujours !! d'afficher vos variables pour comprendre
// mieux le fonctionnement
//print_r($filename);

if (file_exists($filename)) {
    // Si le contenu du fichier est pas vide alors, obtenir le contenu du fichier puis,
    // convertir le format json en un tableau PHP associatif
    // ?? [] : sinon affecter a la variable $ articles un tableau vide []
    // Ceci evite des erreurs dans le code plus tard en initialisant de
    // toute facon la variable $articles
    $articles = json_decode(file_get_contents($filename), true) ?? [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Filtrer les donnees du formulaire
    $_POST = filter_input_array(
        INPUT_POST,
        [
            'titre' => FILTER_SANITIZE_SPECIAL_CHARS,
            'image' => FILTER_SANITIZE_URL,
            'categorie' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'contenu' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ]
    );

    //initialiser les variables filtrees et validees
    $titre = $_POST['titre'] ?? '';
    print_r($titre);
    $image = $_POST['image'] ?? '';
    $categorie = $_POST['categorie'] ?? '';
    $contenu = $_POST['contenu'] ?? '';

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

    // empty retourne true si uen variable est vide
    // array_filter($errors, fn($e) => $e !== '') retourne un nouveau tableau associatif
    //qui contient uniquement les elements dont la valeur nest pas une chaine de
    // characteres vide. Cela evite de soumettre le formulaire avec au moins une erreur
    // (possibilites de attaque)
    if (empty(array_filter($errors, fn ($e) => $e !== ''))) {
        $articles = [
            ...$articles, [
                'titre' => $titre,
                'image' => $image,
                'categorie' => $categorie,
                'contenu' => $contenu,
                'id' => time(),
            ],
        ];

        file_put_contents($filename, json_encode($articles));
        header('Location: /');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'includes/head.php' ?>
    <link rel="stylesheet" href="public/css/add-article.css">
    <title>Ajouter un article</title>
</head>

<body>
    <div class="container">
        <?php require_once 'includes/header.php' ?>
        <div class="content">

            <div class="block p-20 form-container">
                <h1>Ajouter un article</h1>
                <form action="/add-article.php" method="post">

                    <!-- Titre -->
                    <div class="form-control">
                        <label for="titre">Titre</label>
                        <input type="text" name="titre" id="titre" value=<?= $titre ?? '' ?>>
                        <?php if ($errors['titre']) : ?>
                            <p class='text-danger'><?= $errors['titre'] ?></p>
                        <?php endif; ?>

                    </div>

                    <!-- Image -->
                    <div class="form-control">
                        <label for="image">Image</label>
                        <input type="text" name="image" id="image" value=<?= $image ?? '' ?>>
                        <?php if ($errors['image']) : ?>
                            <p class='text-danger'><?= $errors['image'] ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- categorie -->
                    <div class="form-control">
                        <label for="categorie">Catégorie</label>
                        <select name="categorie" id="categorie">
                            <option value="">Non choisie</option>
                            <option value="hotels">Hôtels</option>
                            <option value="chalets">Châlets</option>
                            <option value="camping">Camping</option>
                        </select>

                        <?php if ($errors['categorie']) : ?>
                            <p class='text-danger'><?= $errors['categorie'] ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Contenu -->
                    <div class="form-control">
                        <label for="contenu">Contenu</label>

                        <textarea name="contenu" id="contenu" value=<?= $contenu ?? '' ?>></textarea>
                        <?php if ($errors['contenu']) : ?>

                            <p class='text-danger'><?= $errors['contenu'] ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Boutons -->
                    <div class="form-actions">
                        <button class="btn btn-secondary" type="button">Annuler</button>
                        <button class="btn btn-primary" type="submit">Sauvegarder</button>
                    </div>

                </form>
            </div>

        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>

</body>

</html>