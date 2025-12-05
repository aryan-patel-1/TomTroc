<main class="tt-auth">

    <section class="tt-auth-left">

        <h1>Connexion</h1>

        <?php if (!empty($error)): ?>
            <p class="tt-error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="?page=login">

            <label for="email">Adresse email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="btn-primary">S’identifier</button>
        </form>

        <p class="tt-auth-switch">
            Pas de compte ? <a href="?page=register">Inscrivez-vous</a>
        </p>

    </section>

    <section class="tt-auth-right">
        <img src="images/img-connection.png" alt="Bibliothèque" class="tt-auth-img">
    </section>

</main>