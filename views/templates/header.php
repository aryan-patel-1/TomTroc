<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $pageTitle = $pageTitle ?? ($title ?? 'Tom Troc'); ?>
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="icon" type="image/svg" href="images/logo-footer.svg">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="tt-header">

    <div class="tt-left">
        <a href="?page=home" class="tt-logo" aria-label="Accueil Tom Troc">
            <img src="images/logo.svg" alt="Logo" class="tt-logo-img">
        </a>

        <nav class="tt-nav-left">
            <a href="?page=home">Accueil</a>
            <a href="?page=booksList">Nos livres à l'échange</a>
        </nav>
    </div>

    <nav class="tt-nav-right">
        <div class="tt-separator" aria-hidden="true"></div>
        <a href="?page=messages" class="tt-icon-link">
            <img src="images/message.svg" class="tt-icon">
            Messagerie <span class="tt-badge">1</span>
        </a>

        <a href="?page=account" class="tt-icon-link">
            <img src="images/user.svg" class="tt-icon">
            Mon compte
        </a>

        <?php if (!empty($_SESSION['user_id'])): ?>
            <a href="?page=logout" class="tt-login">Déconnexion</a>
        <?php else: ?>
            <a href="?page=login" class="tt-login">Connexion</a>
        <?php endif; ?>
    </nav>

</header>