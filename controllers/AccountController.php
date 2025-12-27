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
            $upload = EditPictures::upload('avatar_file');

            /**
             * Validation des champs
             * 
             * $isValidFormUserAccount = isValidUserFormAccount($username, $email, $upload, $newPassword);
             * 
             * if (!$isValidFormUserAccount) {
             *   return isValidFormUserAccount;  
             * }
             */

            if ($username === '' || $email === '') {
                $error = 'Pseudo et email sont obligatoires';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Adresse email invalide';
            } elseif (!empty($upload['error'])) {
                $error = $upload['error'];
            } else {
                $newPicture = $upload['path'] ?? $currentPicture;
                UserModel::updateUser($user->id, $username, $email, $newPicture, $newPassword ?: null);
                // recharge les infos utilisateur mise a jour
                $user = UserModel::findById((int) $_SESSION['user_id']);
                $success = true;
            }
        }

        // données pour la vue;
        if (!empty($user->createdAt)) {
            $timestamp = strtotime($user->createdAt);
            if ($timestamp) {
                $memberSinceText = date('d/m/Y', $timestamp);
            }
        }

        $view = new View('Mon compte');
        $view->render('account', [
            'books' => BookModel::findByOwnerId((int) $user->id), // recupere les livres appartenant a l'utilisateur
            'profileError' => $error,
            'profileSuccess' => $success,
            'username' => $user->username ?? 'Utilisateur',
            'userEmail' => $user->email ?? 'email@example.com',
            'userPicture' => !empty($user->picture) ? $user->picture : 'images/logo-footer.svg',
            'memberSinceText' => $memberSinceText ?? 'Membre TomTroc',
        ]);
    }
}
