<!-- page messagerie -->
<main class="tt-messages <?= !empty($activeUser) ? 'is-thread' : 'is-list' ?>">
    <!-- liste conversations -->
    <!-- colonne gauche -->
    <section class="tt-messages-list-page">
        <h1>Messagerie</h1>
        <div class="tt-messages-list">
            <!-- boucle conversations -->
            <?php foreach ($conversations as $otherId => $data): ?>
                <?php
                    // ignore si pas de profil
                    // recupere l'utilisateur associe a la conversation
                    $otherUser = $users[$otherId] ?? null;
                    if (!$otherUser) continue;

                    // extrait infos dernier message
                    // recupere le dernier message de la conversation
                    $lastMsg = $data['lastMessage'] ?? null;
                    $preview = $lastMsg ? mb_strimwidth($lastMsg->content, 0, 28, '…', 'UTF-8') : 'Pas encore de message';
                    $time = $lastMsg ? date('d/m H:i', strtotime($lastMsg->dateTime)) : '';
                    $avatar = !empty($otherUser->picture) ? $otherUser->picture : 'images/hamza.png';
                ?>
                <!-- carte conversation -->
                <a href="?page=messages&with=<?= htmlspecialchars((string) $otherId) ?>" class="tt-conv">
                    <img src="<?= htmlspecialchars($avatar) ?>" alt="<?= htmlspecialchars($otherUser->username) ?>" class="tt-conv-avatar">
                    <div>
                        <p class="tt-conv-title"><?= htmlspecialchars($otherUser->username) ?></p>
                        <p class="tt-conv-preview"><?= htmlspecialchars($preview) ?></p>
                    </div>
                    <span class="tt-conv-time"><?= htmlspecialchars($time) ?></span>
                </a>
            <?php endforeach; ?>

            <?php if (empty($conversations)): ?>
                <!-- etat vide -->
                <p class="tt-conv-preview tt-conv-preview--empty">Aucune conversation</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- fil discussion -->
    <!-- colonne droite -->
    <section class="tt-messages-main tt-messages-main--thread-only">
        <a href="?page=messages&view=list" class="tt-back-link tt-back-link--main">← retour</a>

        <?php if ($activeUser): ?>
            <!-- en tete conversation -->
            <div class="tt-messages-header">
                <?php 
                // avatar utilisateur actif
                $avatar = !empty($activeUser->picture) ? $activeUser->picture : 'images/hamza.png'; 
                ?>
                <img src="<?= htmlspecialchars($avatar) ?>" alt="<?= htmlspecialchars($activeUser->username) ?>">
                <p class="tt-user-name"><?= htmlspecialchars($activeUser->username) ?></p>
            </div>

            <!-- messages -->
            <div class="tt-thread">
                <!-- boucle messages -->
                <?php foreach ($thread as $message): ?>
                    <?php
                        // classe bulle selon auteur
                        $isMe = $message->senderId === $currentUserId;
                        $bubbleClass = $isMe ? 'tt-bubble tt-bubble--me' : 'tt-bubble tt-bubble--other';
                        $time = date('d/m H:i', strtotime($message->dateTime));
                    ?>
                    <div class="<?= $bubbleClass ?>">
                        <span><?= nl2br(htmlspecialchars($message->content)) ?></span>
                        <span class="tt-bubble-meta"><?= htmlspecialchars($time) ?></span>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($thread)): ?>
                    <!-- etat vide -->
                    <p class="tt-conv-preview">Aucun message pour le moment</p>
                <?php endif; ?>
            </div>

            <!-- saisie message -->
            <form class="tt-message-form" method="POST">
                <input type="text" class="tt-message-input" name="message" placeholder="Tapez votre message ici" autocomplete="off" required>
                <button type="submit" class="tt-message-submit">Envoyer</button>
            </form>
        <?php else: ?>
            <!-- etat sans selection -->
            <p class="tt-conv-preview">Sélectionnez une conversation</p>
        <?php endif; ?>
    </section>
</main>