<?php

class MessageController
{
    public function showMessages(): void
    {
        // verifie connexion
        AuthService::ensureAuthenticated();

        // charge conversations utilisateur
        $userId = (int) $_SESSION['user_id'];
        $conversationsByUser = MessageModel::findGroupByConversation($userId);
        $users = [];

        // charge profils associes
        foreach (array_keys($conversationsByUser) as $conversationUserId) {
            $users[$conversationUserId] = UserModel::findById($conversationUserId);
        }

        // lit la conversation active
        $viewMode = $_GET['view'] ?? '';
        $activeId = (int) ($_GET['with'] ?? $_GET['to'] ?? 0);

        // selectionne la premiere conversation par defaut
        if ($activeId === 0 && $viewMode !== 'list' && !empty($conversationsByUser)) {
            $activeId = (int) array_key_first($conversationsByUser);
        }

        // recupere utilisateur actif
        $activeUser = $activeId ? ($users[$activeId] ?? null) : null;

        // charge une conversation non presente dans la liste
        if ($activeId > 0 && !$activeUser) {
            $activeUser = UserModel::findById($activeId);

            if ($activeUser) {
                $users[$activeId] = $activeUser;
                $conversationsByUser[$activeId] = ['lastMessage' => null];
            }
        }

        // envoi message si formulaire valide
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $activeUser) {
            $content = trim($_POST['message'] ?? '');

            if ($content !== '') {
                MessageModel::create($userId, $activeId, $content, null);

                header('Location: ?page=messages&with=' . $activeId);
                exit;
            }
        }

        // charge le fil de discussion
        $thread = $activeUser ? MessageModel::findThread($userId, $activeId) : [];

        // rendu de la page
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