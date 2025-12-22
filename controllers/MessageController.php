<?php

class MessageController
{
    public function showMessages(): void
    {
        // verifie si l'utilisateur est connecte
        if (empty($_SESSION['user_id'])) {
            // redirige vers la page de connexion si non connecte
            header('Location: ?page=login');
            exit;
        }

        // recupere l'id de l'utilisateur connecte
        $userId = (int) $_SESSION['user_id'];

        // recupere les conversations de l'utilisateur
        $conversations = MessageModel::findConversations($userId);

        // stocke les informations des autres utilisateurs
        $users = [];

        // charge les utilisateurs lies aux conversations
        foreach (array_keys($conversations) as $otherId) {
            $users[$otherId] = UserModel::findById($otherId);
        }

        // determine la conversation active
        $activeId = 0;

        // recupere l'id depuis le parametre with
        if (isset($_GET['with'])) {
            $activeId = (int) $_GET['with'];

        // sinon recupere l'id depuis le parametre to
        } elseif (isset($_GET['to'])) {
            $activeId = (int) $_GET['to'];
        }

        // selectionne la premiere conversation par defaut
        if ($activeId === 0 && !empty($conversations)) {
            $activeId = (int) array_keys($conversations)[0];
        }

        // initialise le thread de messages
        $thread = [];

        // recupere l'utilisateur actif si existe
        $activeUser = $activeId ? ($users[$activeId] ?? null) : null;

        // charge l'utilisateur cible si non present dans la liste
        if ($activeId > 0 && !$activeUser) {
            $activeUser = UserModel::findById($activeId);

            // ajoute l'utilisateur et la conversation si trouve
            if ($activeUser) {
                $users[$activeId] = $activeUser;
                $conversations[$activeId] = ['lastMessage' => null];
            }
        }

        // gere l'envoi d'un message
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $activeUser) {

            // recupere et nettoie le contenu du message
            $content = trim($_POST['message'] ?? '');

            // cree le message si le contenu n'est pas vide
            if ($content !== '') {
                MessageModel::create($userId, $activeId, $content, null);

                // redirige pour eviter la double soumission
                header('Location: ?page=messages&with=' . $activeId);
                exit;
            }
        }

        // charge le fil de discussion actif
        if ($activeUser) {
            $thread = MessageModel::findThread($userId, $activeId);
        }

        // rend la vue de la messagerie avec les donnees necessaires
        $view = new View('Messagerie');
        $view->render('messages', [
            'conversations' => $conversations,
            'users' => $users,
            'activeUser' => $activeUser,
            'activeId' => $activeId,
            'thread' => $thread,
            'currentUserId' => $userId,
        ]);
    }
}