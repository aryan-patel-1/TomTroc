<section class="tt-error-wrapper">
    <div class="tt-error-card">
        <h1>Oups...</h1>
        <p><?= htmlspecialchars($errorMessage ?? "Une erreur est survenue.") ?></p>
        <a class="tt-login" href="?page=home">Retour à l'accueil</a>
    </div>
</section>