<?php
// initialise les variables avec une valeur par defaut si elles n'existent pas
$conversations = $conversations ?? [];
$users = $users ?? [];
$activeUser = $activeUser ?? null;
$activeId = $activeId ?? 0;
$thread = $thread ?? [];
$currentUserId = $currentUserId ?? 0;
?>

<main class="tt-messages">
    <aside class="tt-messages-sidebar">
        <h1>Messagerie</h1>
        <div class="tt-messages-list">
            <?php foreach ($conversations as $otherId => $data): ?>
                <?php
                    // recupere l'utilisateur associe a la conversation
                    $otherUser = $users[$otherId] ?? null;

                    // si aucun utilisateur alors on saute cette conversation
                    if (!$otherUser) continue;

                    // recupere le dernier message de la conversation
                    $lastMsg = $data['lastMessage'] ?? null;

                    // prepare un texte court pour l'apercu du message
                    $preview = $lastMsg ? mb_strimwidth($lastMsg->content, 0, 28, '…', 'UTF-8') : 'Pas encore de message';

                    // verifie si cette conversation est celle actuellement ouverte
                    $isActive = ($otherId === $activeId);

                    // formatte la date du dernier message
                    $time = $lastMsg ? date('d/m H:i', strtotime($lastMsg->dateTime)) : '';

                    // utilise l'avatar de l'utilisateur sinon image par defaut
                    $avatar = !empty($otherUser->picture) ? $otherUser->picture : 'images/hamza.png';
                ?>
                <!-- lien vers la conversation -->
                <a href="?page=messages&with=<?= htmlspecialchars((string) $otherId) ?>" class="tt-conv <?= $isActive ? 'is-active' : '' ?>">
                    <img src="<?= htmlspecialchars($avatar) ?>" alt="<?= htmlspecialchars($otherUser->username) ?>" class="tt-conv-avatar">

                    <div>
                        <!-- affiche le nom de l'utilisateur -->
                        <p class="tt-conv-title"><?= htmlspecialchars($otherUser->username) ?></p>

                        <!-- affiche l'apercu du dernier message -->
                        <p class="tt-conv-preview"><?= htmlspecialchars($preview) ?></p>
                    </div>

                    <!-- affiche l'heure du dernier message -->
                    <span class="tt-conv-time"><?= htmlspecialchars($time) ?></span>
                </a>
            <?php endforeach; ?>

            <?php if (empty($conversations)): ?>
                <!-- message si aucune conversation -->
                <p class="tt-conv-preview" style="padding: 0 24px;">Aucune conversation</p>
            <?php endif; ?>
        </div>
    </aside>

    <section class="tt-messages-main">
        <?php if ($activeUser): ?>
        <div class="tt-messages-header">
            <?php 
            // avatar de l'utilisateur actif
            $avatar = !empty($activeUser->picture) ? $activeUser->picture : 'images/hamza.png'; 
            ?>
            <img src="<?= htmlspecialchars($avatar) ?>" alt="<?= htmlspecialchars($activeUser->username) ?>">
            
            <!-- affiche le nom de l'utilisateur actif -->
            <p class="tt-user-name"><?= htmlspecialchars($activeUser->username) ?></p>
        </div>

        <div class="tt-thread">
            <?php foreach ($thread as $message): ?>
                <?php
                    // verifie si le message a ete envoye par l'utilisateur connecte
                    $isMe = $message->senderId === $currentUserId;

                    // applique une classe differente selon l'auteur
                    $bubbleClass = $isMe ? 'tt-bubble tt-bubble--me' : 'tt-bubble tt-bubble--other';

                    // formatte l'heure du message
                    $time = date('d/m H:i', strtotime($message->dateTime));
                ?>
                <div class="<?= $bubbleClass ?>">
                    <!-- contenu du message -->
                    <span><?= nl2br(htmlspecialchars($message->content)) ?></span>

                    <!-- affichage de la date -->
                    <span class="tt-bubble-meta"><?= htmlspecialchars($time) ?></span>
                </div>
            <?php endforeach; ?>

            <?php if (empty($thread)): ?>
                <!-- message si aucune discussion encore -->
                <p class="tt-conv-preview">Aucun message pour le moment</p>
            <?php endif; ?>
        </div>

        <!-- formulaire pour envoyer un message -->
        <form class="tt-message-form" method="POST">
            <input type="text" class="tt-message-input" name="message" placeholder="Tapez votre message ici" autocomplete="off" required>
            <button type="submit" class="tt-message-submit">Envoyer</button>
        </form>

        <?php else: ?>
            <!-- affiche si aucun utilisateur actif -->
            <p>Aucune conversation</p>
        <?php endif; ?>
    </section>
</main>