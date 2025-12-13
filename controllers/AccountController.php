<?php

class AccountController
{
    public function showAccount()
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit;
        }

        // recupere l'utilisateur connecte
        $user = UserModel::findById((int) $_SESSION['user_id']);
        if (!$user) {
            throw new Exception('Utilisateur introuvable');
        }
        $error = null;
        $success = false;

        // traite le formulaire de mise a jour du profil
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $newPassword = trim($_POST['password'] ?? '');
            $currentPicture = $user->picture ?? '';

            if ($username === '' || $email === '') {
                $error = 'Pseudo et email sont obligatoires';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Adresse email invalide';
            } else {
                UserModel::updateUser($user->id, $username, $email, $currentPicture, $newPassword ?: null);
                // recharge les infos utilisateur mise a jour
                $user = UserModel::findById((int) $_SESSION['user_id']);
                $success = true;
            }
        }

        // recupere les livres appartenant a l'utilisateur
        $books = BookModel::findByOwnerId((int) $user->id);

        $view = new View('Mon compte');
        $view->render('account', [
            'user' => $user,
            'books' => $books,
            'error' => $error,
            'success' => $success,
        ]);
    }
}