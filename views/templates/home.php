<main class="tt-home">

<!-- HERO -->
<section class="home-hero">

    <div class="hero-left">
        <h1>Rejoignez nos<br>lecteurs passionnés</h1>

        <p>
            Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture.
            Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres.
        </p>

        <a href="?page=booksList" class="btn-primary">Découvrir</a>
    </div>

    <div class="hero-right">
        <img src="images/hamza.png" alt="Illustration" class="hero-img">
        <p class="hero-credit">Hamza</p>
    </div>

</section>

<!-- DERNIERS LIVRES -->
<section class="tt-last-books">

    <h2>Les derniers livres ajoutés</h2>

    <?php if (!empty($latestBooks ?? [])): ?>
    <div class="tt-books-grid">
        <?php foreach ($latestBooks as $book): ?>
            <?php
                // Détermine le nom du propriétaire affiché
                $owner = $ownersById[$book->ownerId] ?? null;
                $ownerName = 'Membre TomTroc';
                if ($owner) {
                    $ownerName = $owner->username;
                } elseif ($book->ownerId) {
                    $ownerName = 'Utilisateur #' . $book->ownerId;
                }
                // Image de couverture
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
                    <h3><?= htmlspecialchars($book->title) ?></h3>
                    <p class="author"><?= htmlspecialchars($book->author) ?></p>
                    <p class="seller">Vendu par : <span><?= htmlspecialchars($ownerName) ?></span></p>
                </article>
            </a>
        <?php endforeach; ?>
    </div>
    <a href="?page=booksList" class="tt-see-all">Voir tous les livres</a>
    <?php endif; ?>

</section>

<!-- COMMENT ÇA MARCHE ?-->
<section class="tt-how">

    <h1>Comment ça marche ?</h1>

    <p class="tt-how-subtext">
        Échanger des livres avec TomTroc c’est simple et amusant !<br>
        Suivez ces étapes pour commencer :
    </p>

    <div class="tt-how-steps">

        <div class="tt-step"><p>Inscrivez-vous gratuitement<br>sur notre plateforme.</p></div>
        <div class="tt-step"><p>Ajoutez les livres que vous souhaitez échanger à votre profil.</p></div>
        <div class="tt-step"><p>Parcourez les livres disponibles chez d'autres membres.</p></div>
        <div class="tt-step"><p>Proposez un échange et discutez avec d'autres passionnés.</p></div>

    </div>

    <a href="?page=booksList" class="tt-btn-secondary">Voir tous les livres</a>

</section>

<!-- NOS VALEURS -->
<section class="tt-banner">
    <img src="images/valeur.png" alt="Bibliothèque et livres">
</section>

<section class="tt-values">
    <div class="tt-values-content">
        <h2>Nos valeurs</h2>

        <p>
        Chez Tom Troc, nous mettons l’accent sur le partage, la découverte et la communauté. Nos valeurs sont ancrées dans notre passion pour les livres et notre désir de créer des liens entre les lecteurs. Nous croyons en la puissance des histoires pour rassembler les gens et inspirer des conversations enrichissantes.
        </p>

        <p>
        Notre association a été fondée avec une conviction profonde : chaque livre mérite d’être lu et partagé.
        </p>

        <p>
        Nous sommes passionnés par la création d’une plateforme conviviale qui permet aux lecteurs de se connecter, de partager leurs découvertes littéraires et d’échanger des livres qui attendent patiemment sur les étagères.
        </p>

        <p class="tt-values-signature">L’équipe Tom Troc</p>
    </div>

    <img src="images/heart.svg" alt="Icône coeur" class="tt-heart">
</section>

</main>