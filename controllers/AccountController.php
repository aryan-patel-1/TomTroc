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
        $books = []; 

        require_once './views/templates/header.php';
        require_once './views/templates/account.php';
        require_once './views/templates/footer.php';
    }
}