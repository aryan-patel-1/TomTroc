<!-- page connexion -->
<main class="tt-auth">

    <!-- colonne formulaire -->
    <section class="tt-auth-left">

        <h1>Connexion</h1>

        <!-- message erreur -->
        <?php if (!empty($error)): ?>
            <p class="tt-error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <!-- formulaire connexion -->
        <form method="POST" action="?page=login">

            <!-- champ email -->
            <label for="email">Adresse email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

            <!-- champ mot de passe -->
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>

            <!-- bouton connexion -->
            <button type="submit" class="tt-auth-btn">S’identifier</button>
        </form>

        <!-- lien inscription -->
        <p class="tt-auth-switch">
            Pas de compte ? <a href="?page=register">Inscrivez-vous</a>
        </p>

    </section>

    <!-- colonne visuel -->
    <section class="tt-auth-right">
        <img src="images/img-connection.png" alt="Bibliothèque" class="tt-auth-img">
    </section>

</main>
