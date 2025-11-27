<main class="tt-auth">

    <section class="tt-auth-left">

        <h1>Inscription</h1>

        <form method="POST" action="?page=register">

            <label for="pseudo">Pseudo</label>
            <input type="text" id="pseudo" name="pseudo" required>

            <label for="email">Adresse email</label>
            <input type="email" id="email" name="email" required>

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
