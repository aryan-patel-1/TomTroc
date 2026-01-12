<?php
// carte livre
$book = $book ?? null;
$ownersById = $ownersById ?? [];
$useInfoWrapper = $useInfoWrapper ?? false;

if (!$book) {
    return;
}

$owner = $ownersById[$book->ownerId] ?? null;
$ownerName = 'Membre TomTroc';
if ($owner) {
    $ownerName = $owner->username;
} elseif ($book->ownerId) {
    $ownerName = 'Utilisateur #' . $book->ownerId;
}

$cover = $book->coverUrl ?: 'images/kinfolk.png';
$isAvailable = !empty($book->availability);
?>
<a
    class="tt-book-link"
    href="?page=book&id=<?= htmlspecialchars((string) $book->id) ?>"
    data-title="<?= htmlspecialchars($book->title) ?>"
>
    <article class="tt-book-card">
        <?php if (!$isAvailable): ?>
            <span class="tt-book-badge" aria-label="Livre non disponible">non dispo.</span>
        <?php endif; ?>
        <img src="<?= htmlspecialchars($cover) ?>" alt="<?= htmlspecialchars($book->title) ?>">
        <?php if ($useInfoWrapper): ?>
            <div class="tt-book-info">
        <?php endif; ?>
                <h3><?= htmlspecialchars($book->title) ?></h3>
                <p class="author"><?= htmlspecialchars($book->author) ?></p>
                <p class="seller">Vendu par : <span><?= htmlspecialchars($ownerName) ?></span></p>
        <?php if ($useInfoWrapper): ?>
            </div>
        <?php endif; ?>
    </article>
</a>
