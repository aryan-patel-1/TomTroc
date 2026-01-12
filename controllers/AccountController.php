<?php

class AccountController
{
    public function showAccount()
    {
        // verifie connexion
        AuthService::ensureAuthenticated();
        // charge utilisateur courant
        $user = AccountService::loadCurrentUser();
        $error = null;
        $success = false;

        // traite le formulaire de mise a jour du profil
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            [$error, $success, $user] = AccountService::handleProfileUpdate($user);
        }

        // formate la date d'inscription
        $memberSinceText = AccountService::formatMemberSince($user);

        // rendu de la page
        $view = new View('Mon compte');
        $view->render('account', [
            // recupere les livres appartenant a l'utilisateur
            'books' => BookModel::findByOwnerId((int) $user->id),
            'profileError' => $error,
            'profileSuccess' => $success,
            'username' => $user->username ?? 'Utilisateur',
            'userEmail' => $user->email ?? 'email@example.com',
            'userPicture' => !empty($user->picture) ? $user->picture : 'images/logo-footer.svg',
            'memberSinceText' => $memberSinceText ?? 'Membre TomTroc',
        ]);
    }
}