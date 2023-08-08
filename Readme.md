# Documentation de l'API de Mon Projet

## Introduction

Bienvenue dans la documentation de l'API de notre projet. Ce guide vous aidera à comprendre comment utiliser efficacement nos points d'accès API.



---

## Points d'accès

### 1. Récupérer tous les articles

**Point d'accès**: `/api/posts`

**Méthode**: `GET`

**Description**: Récupère tous les articles disponibles.

**Réponse**:

- `200 OK` si la requête est réussie. Retourne une liste d'articles.
- `400 Mauvaise Requête` si aucun article n'est trouvé.

---

### 2. Récupérer un article spécifique

**Point d'accès**: `/api/posts/{id}`

**Méthode**: `GET`

**Paramètres**:

- `id`: L'ID de l'article.

**Description**: Récupère les détails d'un article spécifique.

**Réponse**:

- `200 OK` si la requête est réussie. Retourne les détails de l'article.
- `400 Mauvaise Requête` si l'article n'est pas trouvé.

---

### 3. Supprimer un article

**Point d'accès**: `/api/post/delete/{id}`

**Méthode**: `DELETE`

**Paramètres**:

- `id`: L'ID de l'article.

**Description**: Supprime un article spécifique.

**Réponse**:

- `200 OK` si l'article est supprimé avec succès.
- `500 Erreur Interne du Serveur` si la suppression a échoué.

---

### 4. Créer un nouvel article

**Point d'accès**: `/api/post/create`

**Méthode**: `POST`

**Paramètres**:

- `titre`: Titre de l'article.
- `image`: URL de l'image de l'article.
- `contenu`: Contenu de l'article.
- `categorie_id`: ID de la catégorie de l'article.

**Description**: Crée un nouvel article.

**Réponse**:

- `200 OK` si l'article est créé avec succès.
- `500 Erreur Interne du Serveur` si la création a échoué.

---

### 5. Mettre à jour un article

**Point d'accès**: `/api/post/update/{id}`

**Méthode**: `PUT`

**Paramètres**:

- `id`: L'ID de l'article.
- `titre`: Nouveau titre de l'article.
- `image`: Nouvelle URL de l'image de l'article.
- `contenu`: Nouveau contenu de l'article.
- `categorie_id`: Nouvel ID de catégorie de l'article.

**Description**: Met à jour un article existant.

**Réponse**:

- `200 OK` si l'article est mis à jour avec succès.
- `500 Erreur Interne du Serveur` si la mise à jour a échoué.

---

## Support

Pour toute question ou problème lié à l'API, contactez [support@example.com](mailto:support@example.com).

---

