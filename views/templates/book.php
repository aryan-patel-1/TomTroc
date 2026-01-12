<!-- page livre -->
<main class="tt-book-detail">

    <div class="tt-book-breadcrumb">
        <a href="?page=booksList">Nos livres</a>
        <span>></span>
        <span><?= htmlspecialchars($book->title) ?></span>
    </div>

    <div class="tt-book-layout">

        <div class="tt-book-image">
            <img src="<?= htmlspecialchars($cover) ?>" alt="<?= htmlspecialchars($book->title) ?>">
        </div>

        <div class="tt-book-content">
            <h1><?= htmlspecialchars($book->title) ?></h1>
            <p class="tt-book-author">par <?= htmlspecialchars($book->author) ?></p>
            <div class="tt-book-separator"></div>

            <div class="tt-book-section">
                <p class="tt-book-section-title">Description</p>
                <p><?= (htmlspecialchars($description)) ?></p>
            </div>

            <div class="tt-book-owner">
                <p class="tt-book-section-title">Propriétaire</p>
                <a href="<?= $owner ? '?page=owner&id=' . htmlspecialchars((string) $owner->id) : '#'; ?>" class="tt-book-owner-card" aria-label="Voir le profil de <?= htmlspecialchars($ownerName) ?>">
                    <img src="<?= htmlspecialchars($ownerPicture) ?>" alt="Photo propriétaire" class="tt-book-owner-avatar">
                    <span class="tt-book-owner-name"><?= htmlspecialchars($ownerName) ?></span>
                </a>
            </div>

            <?php if ($owner): ?>
            <a href="?page=messages&with=<?= htmlspecialchars((string) $owner->id) ?>" class="tt-book-cta">Envoyer un message</a>
            <?php endif; ?>
        </div>

    </div>
</main>