<main class="tt-books-page">
    <div class="books-container">
        <div class="tt-books-header">
            <h1>Nos livres à l’échange</h1>

            <form class="tt-search-bar" role="search">
                <input
                    type="search"
                    placeholder="Rechercher un livre"
                    aria-label="Rechercher un livre"
                    data-search-books
                    autocomplete="off"
                >
            </form>
        </div>

        <?php if (!empty($bookList ?? [])): ?>
            <!-- Grille de livres -->
            <section class="tt-books-grid" data-books-grid>
                <?php foreach ($bookList as $book): ?>
                    <?php
                        $owner = $ownersById[$book->ownerId] ?? null;
                        $ownerName = 'Membre TomTroc';
                        if ($owner) {
                            $ownerName = $owner->username;
                        } elseif ($book->ownerId) {
                            $ownerName = 'Utilisateur #' . $book->ownerId;
                        }
                        $cover = $book->coverUrl ?: 'images/kinfolk.png';
                    ?>
                    <a
                        class="tt-book-link"
                        href="?page=book&id=<?= htmlspecialchars((string) $book->id) ?>"
                        data-title="<?= htmlspecialchars($book->title) ?>"
                    >
                        <article class="tt-book-card">
                            <img src="<?= htmlspecialchars($cover) ?>" alt="<?= htmlspecialchars($book->title) ?>">
                            <div class="tt-book-info">
                                <h3><?= htmlspecialchars($book->title) ?></h3>
                                <p class="author"><?= htmlspecialchars($book->author) ?></p>
                                <p class="seller">Vendu par : <span><?= htmlspecialchars($ownerName) ?></span></p>
                            </div>
                        </article>
                    </a>
                <?php endforeach; ?>
            </section>

            <p class="tt-search-empty" hidden>Aucun livre ne correspond à votre recherche.</p>
        <?php else: ?>
            <p>Aucun livre disponible pour le moment.</p>
        <?php endif; ?>
    </div>
</main>
<script src="js/books-search.js" defer></script>