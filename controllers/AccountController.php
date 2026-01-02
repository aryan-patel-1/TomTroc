<?php

class AccountController
{
    public function showAccount()
    {
        AuthService::ensureAuthenticated();
        $user = AccountService::loadCurrentUser();
        $error = null;
        $success = false;

        // traite le formulaire de mise a jour du profil
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            [$error, $success, $user] = AccountService::handleProfileUpdate($user);
        }

        $memberSinceText = AccountService::formatMemberSince($user);

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