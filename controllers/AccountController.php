<?php

class AccountController
{
    public function showAccount()
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit;
        }

        // Récupération de l'utilisateur connecté.
        $user = UserModel::findById((int) $_SESSION['user_id']);
        if (!$user) {
            throw new Exception('Utilisateur introuvable.');
        }
        // Récupère les livres appartenant à l'utilisateur.
        $books = BookModel::findByOwnerId((int) $user->id);

        $view = new View('Mon compte');
        $view->render('account', [
            'user' => $user,
            'books' => $books,
        ]);
    }
}