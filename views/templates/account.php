<!-- page compte -->
<main class="tt-account">
    <div class="tt-account-container">
        <h1 class="tt-account-title">Mon compte</h1>

        <?php if (!empty($profileError ?? null)): ?>
            <div class="tt-alert tt-alert--error"><?= htmlspecialchars($profileError) ?></div>
        <?php elseif (!empty($profileSuccess ?? null)): ?>
            <div class="tt-alert tt-alert--success">Profil mis à jour</div>
        <?php endif; ?>

        <div class="tt-account-grid">
            <!-- colonne profil -->
            <aside class="tt-account-card tt-account-profile">
                <div class="tt-account-avatar-block">
                    <div class="tt-account-avatar">
                        <img src="<?= htmlspecialchars($userPicture ?? '') ?>" alt="Avatar profil">
                    </div>
                    <label class="tt-account-edit" for="avatar_file">modifier</label>
                    <input type="file" id="avatar_file" name="avatar_file" accept="image/*" class="tt-account-file-input" form="profile-form">
                </div>

                <div class="tt-account-divider"></div>

                <h2 class="tt-account-name"><?= htmlspecialchars($username ?? '') ?></h2>
                <p class="tt-account-meta">Membre depuis <?= htmlspecialchars($memberSinceText ?? '') ?></p>

                <!-- infos bibliotheque -->
                <div class="tt-account-library">
                    <span class="tt-account-library-label">Bibliothèque</span>
                    <span class="tt-account-library-count">
                        <img src="images/Vector.svg" alt="" aria-hidden="true">
                        <?= count($books) ?> livres
                    </span>
                </div>
            </aside>

            <!-- colonne formulaire -->
            <section class="tt-account-card tt-account-form">
                <h2>Vos informations personnelles</h2>
                <!-- formulaire profil -->
                <form id="profile-form" class="tt-account-form-grid" method="POST" enctype="multipart/form-data">
                    <label class="tt-account-label">
                        <span>Adresse email</span>
                        <input type="email" name="email" value="<?= htmlspecialchars($userEmail ?? '') ?>" required>
                    </label>
                    <label class="tt-account-label">
                        <span>Mot de passe</span>
                        <input type="password" name="password" placeholder="Laisser vide pour ne pas changer">
                    </label>
                    <label class="tt-account-label">
                        <span>Pseudo</span>
                        <input type="text" name="username" value="<?= htmlspecialchars($username) ?>" required>
                    </label>
                    <button type="submit" class="tt-account-button">Enregistrer</button>
                </form>
            </section>
        </div>

        <!-- section livres -->
        <section class="tt-account-books">
            <div class="tt-account-table-wrapper">
                <?php if (!empty($books)): ?>
                    <!-- tableau desktop -->
                    <table class="tt-account-table" aria-label="Liste de vos livres">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Titre</th>
                                <th>Auteur</th>
                                <th>Description</th>
                                <th>Disponibilité</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- boucle livres -->
                            <?php foreach ($books as $book): ?>
                                <?php
                                    $cover = $book->coverUrl ?: 'images/kinfolk.png';
                                    $description = $book->description ?? '';
                                    $isAvailable = !empty($book->availability);
                                    $pillClass = $isAvailable ? 'tt-pill--available' : 'tt-pill--unavailable';
                                    $availabilityLabel = $isAvailable ? 'Disponible' : 'Non dispo';
                                ?>
                                <tr>
                                    <td>
                                        <div class="tt-account-thumb">
                                            <img src="<?= htmlspecialchars($cover) ?>" alt="<?= htmlspecialchars($book->title) ?>">
                                        </div>
                                    </td>
                                    <td class="tt-account-col-title"><?= htmlspecialchars($book->title) ?></td>
                                    <td><?= htmlspecialchars($book->author) ?></td>
                                    <td>
                                        <p class="tt-account-description"><?= htmlspecialchars($description) ?></p>
                                    </td>
                                    <td>
                                        <span class="tt-pill <?= $pillClass ?>"><?= $availabilityLabel ?></span>
                                    </td>
                                    <td>
                                        <div class="tt-account-actions">
                                            <a href="?page=bookEdit&id=<?= htmlspecialchars((string) $book->id) ?>" class="tt-account-link">Éditer</a>
                                            <button type="button" class="tt-account-link tt-account-link--danger">Supprimer</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <!-- etat vide -->
                    <div class="tt-account-empty">
                        <p>Vous n'avez pas encore ajouté de livres.</p>
                        <p>Ajoutez vos livres pour les proposer à l'échange.</p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (!empty($books)): ?>
                <!-- cartes mobile -->
                <div class="tt-account-cards" aria-label="Liste de vos livres">
                    <!-- boucle livres -->
                    <?php foreach ($books as $book): ?>
                        <?php
                            $cover = $book->coverUrl ?: 'images/kinfolk.png';
                            $description = $book->description ?? '';
                            $isAvailable = !empty($book->availability);
                            $pillClass = $isAvailable ? 'tt-pill--available' : 'tt-pill--unavailable';
                            $availabilityLabel = $isAvailable ? 'Disponible' : 'Non dispo';
                        ?>
                        <article class="tt-account-card tt-account-book-card">
                            <div class="tt-account-book-top">
                                <div class="tt-account-thumb tt-account-thumb--large">
                                    <img src="<?= htmlspecialchars($cover) ?>" alt="<?= htmlspecialchars($book->title) ?>">
                                </div>
                                <div class="tt-account-book-meta">
                                    <h3><?= htmlspecialchars($book->title) ?></h3>
                                    <p class="author"><?= htmlspecialchars($book->author) ?></p>
                                    <span class="tt-pill <?= $pillClass ?>"><?= $availabilityLabel ?></span>
                                </div>
                            </div>
                            <p class="tt-account-description"><?= htmlspecialchars($description) ?></p>
                            <div class="tt-account-actions">
                                <a href="?page=bookEdit&id=<?= htmlspecialchars((string) $book->id) ?>" class="tt-account-link">Éditer</a>
                                <button type="button" class="tt-account-link tt-account-link--danger">Supprimer</button>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>
</main>
<script src="js/image-preview.js" defer></script>
