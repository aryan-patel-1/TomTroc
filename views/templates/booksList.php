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
                <?php $useInfoWrapper = true; ?>
                <?php foreach ($bookList as $book): ?>
                    <?php require __DIR__ . '/../../services/book-card.php'; ?>
                <?php endforeach; ?>
            </section>

            <p class="tt-search-empty" hidden>Aucun livre ne correspond à votre recherche.</p>
        <?php else: ?>
            <p>Aucun livre disponible pour le moment.</p>
        <?php endif; ?>
    </div>
</main>
<script src="js/books-search.js" defer></script>
