<?php

$errors = [];
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
                <form action="http://localhost:3000/api/post/create" method="post">

                    <!-- Titre -->
                    <div class="form-control">
                        <label for="titre">Titre</label>
                        <input type="text" name="titre" id="titre" value=<?= $titre ?? '' ?>>
                        <?php if (isset($errors['titre'])) : ?>
                            <p class='text-danger'><?= $errors['titre'] ?></p>
                        <?php endif; ?>

                    </div>

                    <!-- Image -->
                    <div class="form-control">
                        <label for="image">Image</label>
                        <input type="text" name="image" id="image" value=<?= $image ?? '' ?>>
                        <?php if (isset($errors['image'])) : ?>
                            <p class='text-danger'><?= $errors['image'] ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- categorie -->
                    <div class="form-control">
                        <label for="categorie">Catégorie</label>
                        <select name="categorie_id" id="categorie">
                            <option value="">Non choisie</option>
                            <option value="hotels">Hôtels</option>
                            <option value="chalets">Châlets</option>
                            <option value="camping">Camping</option>
                        </select>

                        <?php if (isset($errors['categorie'])) : ?>
                            <p class='text-danger'><?= $errors['categorie'] ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Contenu -->
                    <div class="form-control">
                        <label for="contenu">Contenu</label>

                        <textarea name="contenu" id="contenu" <?= $contenu ?? '' ?>></textarea>
                        <?php if (isset($errors['contenu'])) : ?>

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