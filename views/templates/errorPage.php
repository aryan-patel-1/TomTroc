<main class="tt-error-page">
    <section class="tt-error-wrapper">
        <div class="tt-error-card">
            <h1>Oups...</h1>
            <p><?= htmlspecialchars($errorMessage ?? "Une erreur est survenue.") ?></p>
            <a class="btn-primary tt-error-btn" href="?page=home">Retour à l'accueil</a>
        </div>
    </section>
</main>