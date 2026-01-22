<!-- edition livre -->
<main class="tt-book-edit">
    <a href="?page=account" class="tt-back-link">← retour</a>

    <h1>Modifier les informations</h1>

    <?php if (!empty($error ?? null)): ?>
        <div class="tt-alert tt-alert--error"><?= htmlspecialchars($error) ?></div>
    <?php elseif (!empty($success ?? null)): ?>
        <div class="tt-alert tt-alert--success">Livre mis à jour.</div>
    <?php endif; ?>

    <form class="tt-book-edit-card" method="POST" enctype="multipart/form-data">
        <div class="tt-book-edit-grid">

            <div class="tt-book-edit-photo">
                <span class="tt-book-edit-label">Photo</span>
                <div class="tt-book-edit-cover">
                    <img src="<?= htmlspecialchars($coverPreview) ?>" alt="<?= htmlspecialchars($book->title) ?>">
                </div>
                <label class="tt-book-edit-photo-link" for="cover_file">Modifier la photo</label>
                <input type="file" id="cover_file" name="cover_file" accept="image/*" class="tt-book-edit-file-input">
            </div>

            <div class="tt-book-edit-form">
                <label class="tt-book-edit-label">
                    Titre
                    <input type="text" name="title" value="<?= htmlspecialchars($formValues['title'] ?? $book->title) ?>" required>
                </label>

                <label class="tt-book-edit-label">
                    Auteur
                    <input type="text" name="author" value="<?= htmlspecialchars($formValues['author'] ?? $book->author) ?>" required>
                </label>

                <label class="tt-book-edit-label">
                    Commentaire
                    <textarea name="description" rows="8"><?= htmlspecialchars($formValues['description'] ?? $book->description) ?></textarea>
                </label>

                <label class="tt-book-edit-label">
                    Disponibilité
                    <select name="availability">
                        <option value="1" <?= ($availabilityValue ?? '') === '1' ? 'selected' : '' ?>>disponible</option>
                        <option value="0" <?= ($availabilityValue ?? '') === '0' ? 'selected' : '' ?>>non disponible</option>
                    </select>
                </label>

                <button type="submit" class="tt-book-edit-submit">Valider</button>
            </div>
        </div>
    </form>
</main>
<script src="js/image-preview.js" defer></script>