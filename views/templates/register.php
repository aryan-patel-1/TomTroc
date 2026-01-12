<!-- page inscription -->
<main class="tt-auth">

    <!-- colonne formulaire -->
    <section class="tt-auth-left">

        <h1>Inscription</h1>

        <!-- message erreur -->
        <?php if (!empty($error)): ?>
            <p class="tt-error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <!-- formulaire inscription -->
        <form method="POST" action="?page=register">

            <!-- champ username -->
            <label for="username">Nom d'utilisateur</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>

            <!-- champ email -->
            <label for="email">Adresse email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

            <!-- champ mot de passe -->
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>

            <!-- bouton inscription -->
            <button type="submit" class="btn-primary">S’inscrire</button>
        </form>

        <!-- lien connexion -->
        <p class="tt-auth-switch">
            Déjà inscrit ? <a href="?page=login">Connectez-vous</a>
        </p>

    </section>

    <!-- colonne visuel -->
    <section class="tt-auth-right">
        <img src="images/img-connection.png" alt="Bibliothèque" class="tt-auth-img">
    </section>

</main>