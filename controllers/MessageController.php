<?php

class MessageController
{
    public function showMessages(): void
    {
        AuthService::ensureAuthenticated();

        // recupere l'id de l'utilisateur connecte
        $userId = (int) $_SESSION['user_id'];

        // recupere les conversations de l'utilisateur
        $conversationsByUser = MessageModel::findGroupByConversation($userId);

        // stocke les informations des autres utilisateurs
        $users = [];

        // charge les utilisateurs lies aux conversations
        foreach (array_keys($conversationsByUser) as $conversationUserId) {
            $users[$conversationUserId] = UserModel::findById($conversationUserId);
        }

        // determine la conversation active
        $activeId = 0;
        $viewMode = $_GET['view'] ?? '';

        // recupere l'id depuis le parametre with
        if (isset($_GET['with'])) {
            $activeId = (int) $_GET['with'];

        // sinon recupere l'id depuis le parametre to
        } elseif (isset($_GET['to'])) {
            $activeId = (int) $_GET['to'];
        }

        // selectionne la premiere conversation par defaut
        if ($activeId === 0 && $viewMode !== 'list' && !empty($conversationsByUser)) {
            $activeId = (int) array_keys($conversationsByUser)[0];
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
                $conversationsByUser[$activeId] = ['lastMessage' => null];
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
            'conversations' => $conversationsByUser,
            'users' => $users,
            'activeUser' => $activeUser,
            'activeId' => $activeId,
            'thread' => $thread,
            'currentUserId' => $userId,
        ]);
    }
}