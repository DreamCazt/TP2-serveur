<header>
    <a href='main.php' class="logo">Mon Blog</a>
    <ul class="header-menu">
        <li class=<?php $_SERVER['REQUEST_URI'] === '/add-article.php' ? 'active' : '' ?>>
            <a href='/add-article.php'>Ajouter article</a>
        </li>
    </ul>
</header>