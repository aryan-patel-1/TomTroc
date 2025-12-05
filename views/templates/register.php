<main class="tt-auth">

    <section class="tt-auth-left">

        <h1>Inscription</h1>

        <?php if (!empty($error)): ?>
            <p class="tt-error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="?page=register">

            <label for="username">Nom d'utilisateur</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>

            <label for="email">Adresse email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="btn-primary">S’inscrire</button>
        </form>

        <p class="tt-auth-switch">
            Déjà inscrit ? <a href="?page=login">Connectez-vous</a>
        </p>

    </section>

    <section class="tt-auth-right">
        <img src="images/img-connection.png" alt="Bibliothèque" class="tt-auth-img">
    </section>

</main>