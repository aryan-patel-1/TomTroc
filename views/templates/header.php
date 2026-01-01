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
    <script src="js/header.js" defer></script>
</head>
<body>

<?php
$newMessageCount = 0;
if (!empty($_SESSION['user_id'])) {
    try {
        $newMessageCount = MessageModel::countUnreadForUser((int) $_SESSION['user_id']);
    } catch (Throwable $e) {
        // on laisse 0 si une erreur survient pour ne pas casser l'affichage du header
        $newMessageCount = 0;
    }
}
?>

<header class="tt-header" data-header>
    <div class="tt-left">
        <a href="?page=home" class="tt-logo" aria-label="Accueil Tom Troc">
            <img src="images/logo.svg" alt="Logo" class="tt-logo-img">
        </a>

        <button class="tt-burger" type="button" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="tt-main-nav" data-header-toggle>
            <img src="images/icon-menu.png" alt="" class="tt-burger-icon" aria-hidden="true">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>

    <div class="tt-nav-wrapper" id="tt-main-nav" data-header-nav>
        <nav class="tt-nav-left">
            <a href="?page=home">Accueil</a>
            <a href="?page=booksList">Nos livres à l'échange</a>
        </nav>

        <nav class="tt-nav-right">
            <div class="tt-separator" aria-hidden="true"></div>
            <a href="?page=messages" class="tt-icon-link">
                <img src="images/message.svg" class="tt-icon">
                Messagerie <span class="tt-badge"><?= htmlspecialchars((string) $newMessageCount) ?></span>
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
    </div>
</header>
