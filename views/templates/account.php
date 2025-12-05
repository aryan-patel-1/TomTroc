<?php
$username = $user->username ?? 'Utilisateur';
$userEmail = $user->email ?? 'email@example.com';
$memberSince = $user->createdAt ?? '';
?>

<main class="tt-account">
    <div class="tt-account-container">
        <h1 class="tt-account-title">Mon compte</h1>

        <div class="tt-account-grid">
            <aside class="tt-account-card tt-account-profile">
                <div class="tt-account-avatar">
                    <img src="images/logo-footer.svg" alt="Avatar profil">
                </div>
                <button class="tt-account-edit" type="button">modifier</button>

                <div class="tt-account-divider"></div>

                <h2 class="tt-account-name"><?= htmlspecialchars($username) ?></h2>
                <p class="tt-account-meta">Membre depuis : <?= htmlspecialchars($memberSince) ?></p>

                <div class="tt-account-library">
                    <span class="tt-account-library-label">Bibliothèque</span>
                    <span class="tt-account-library-count"><?= count($books) ?> livres</span>
                </div>
            </aside>

            <section class="tt-account-card tt-account-form">
                <h2>Vos informations personnelles</h2>
                <form class="tt-account-form-grid">
                    <label>
                        Adresse email
                        <input type="email" value="<?= htmlspecialchars($userEmail) ?>" readonly>
                    </label>
                    <label>
                        Mot de passe
                        <input type="password" value="password" readonly>
                    </label>
                    <label>
                        Pseudo
                        <input type="text" value="<?= htmlspecialchars($username) ?>" readonly>
                    </label>
                    <button type="button">Enregistrer</button>
                </form>
            </section>
        </div>
    </div>
</main>