console.log('Hello World !');

// Fonction pour l'event delete du post
function deletePost(postId) {
    fetch('/api/post/delete/' + postId, { method: 'DELETE' })
        .then(response => {
            if (!response.ok) { throw new Error('Network response was not ok'); }

            location.reload();
        })
        .catch(error => console.error('Error:', error));
}
