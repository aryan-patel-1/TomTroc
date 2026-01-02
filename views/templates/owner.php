<main class="tt-owner">
    <div class="tt-owner-container">

        <aside class="tt-owner-profile">
            <div class="tt-owner-avatar-frame">
                <img src="<?= htmlspecialchars($ownerPicture) ?>" alt="Photo du propriétaire" class="tt-owner-avatar">
            </div>

            <div class="tt-owner-divider"></div>

            <h1 class="tt-owner-name"><?= htmlspecialchars($ownerName) ?></h1>
            <p class="tt-owner-meta">Membre depuis <?= htmlspecialchars($memberSinceText) ?></p>

            <div class="tt-owner-library-meta">
                <span class="tt-owner-library-label">Bibliothèque</span>
                <span class="tt-owner-library-count">
                    <img src="images/Vector.svg" alt="" aria-hidden="true">
                    <?= $booksCount ?> livre<?= $booksCount > 1 ? 's' : '' ?>
                </span>
            </div>

            <a href="?page=messages&with=<?= htmlspecialchars((string) ($owner->id ?? '')) ?>" class="tt-owner-message">Écrire un message</a>
        </aside>

        <section class="tt-owner-library">
            <?php if (!empty($books ?? [])): ?>
            <div class="tt-owner-table-wrapper">
                <table class="tt-owner-table">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Titre</th>
                            <th>Auteur</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($books as $book): ?>
                        <?php
                            $cover = $book->coverUrl ?: 'images/kinfolk.png';
                            $description = $book->description ?: 'Description non disponible';
                        ?>
                        <tr>
                            <td class="tt-owner-cover">
                                <img src="<?= htmlspecialchars($cover) ?>" alt="<?= htmlspecialchars($book->title) ?>">
                            </td>
                            <td class="tt-owner-title"><?= htmlspecialchars($book->title) ?></td>
                            <td class="tt-owner-author"><?= htmlspecialchars($book->author) ?></td>
                            <td class="tt-owner-summary"><?= htmlspecialchars($description) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="tt-owner-cards">
                <?php foreach ($books as $book): ?>
                    <?php
                        $cover = $book->coverUrl ?: 'images/kinfolk.png';
                        $description = $book->description ?: 'Description non disponible';
                    ?>
                    <article class="tt-owner-card">
                        <div class="tt-owner-card-top">
                            <div class="tt-owner-card-cover">
                                <img src="<?= htmlspecialchars($cover) ?>" alt="<?= htmlspecialchars($book->title) ?>">
                            </div>
                            <div>
                                <p class="tt-owner-card-title"><?= htmlspecialchars($book->title) ?></p>
                                <p class="tt-owner-card-author"><?= htmlspecialchars($book->author) ?></p>
                            </div>
                        </div>
                        <p class="tt-owner-card-summary"><?= htmlspecialchars($description) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
                <p>Aucun livre pour le moment</p>
            <?php endif; ?>
        </section>

    </div>
</main>