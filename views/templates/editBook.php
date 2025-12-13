<?php
if (!isset($book)) {
    echo '<main class="tt-book-edit"><p>Livre introuvable.</p></main>';
    return;
}

$formValues = $formValues ?? [];
$coverPreview = $coverPreview ?? ($book->coverUrl ?: 'images/kinfolk.png');
$availabilityValue = $formValues['availability'] ?? ($book->availability ? '1' : '0');
?>

<main class="tt-book-edit">
    <a href="?page=account" class="tt-back-link">← retour</a>

    <h1>Modifier les informations</h1>

    <?php if (!empty($error)): ?>
        <div class="tt-alert tt-alert--error"><?= htmlspecialchars($error) ?></div>
    <?php elseif (!empty($success)): ?>
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
                <input type="file" id="cover_file" name="cover_file" accept="image/*" style="display:none">
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

                <label class="tt-book-edit-label" id="cover_url">
                    URL de la photo (optionnel)
                    <input type="text" name="cover_url" value="<?= htmlspecialchars($formValues['cover_url'] ?? $book->coverUrl) ?>" placeholder="https://…">
                </label>

                <label class="tt-book-edit-label">
                    Disponibilité
                    <select name="availability">
                        <option value="1" <?= $availabilityValue === '1' ? 'selected' : '' ?>>disponible</option>
                        <option value="0" <?= $availabilityValue === '0' ? 'selected' : '' ?>>non disponible</option>
                    </select>
                </label>

                <button type="submit" class="tt-book-edit-submit">Valider</button>
            </div>
        </div>
    </form>
</main>