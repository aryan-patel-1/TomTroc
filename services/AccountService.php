<?php

class AccountService
{
    // charge l'utilisateur courant ou lève une exception
    public static function loadCurrentUser()
    {
        $user = UserModel::findById((int) $_SESSION['user_id']);
        if (!$user) {
            throw new Exception('Utilisateur introuvable');
        }
        return $user;
    }

    // gère la mise à jour du profil et retourne [error, success, user]
    public static function handleProfileUpdate($user): array
    {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $newPassword = trim($_POST['password'] ?? '');
        $currentPicture = $user->picture ?? '';
        $upload = EditPictures::upload('avatar_file');

        $validation = FormUserAccountValidator::validate($username, $email, $upload, $newPassword);

        if (!$validation['isValid']) {
            return [$validation['error'], false, $user];
        }

        $newPicture = $upload['path'] ?? $currentPicture;
        UserModel::updateUser($user->id, $username, $email, $newPicture, $newPassword ?: null);
        $user = UserModel::findById((int) $_SESSION['user_id']);

        return [null, true, $user];
    }

    // renvoie la date d'inscription formatée
    public static function formatMemberSince($user): ?string
    {
        if (empty($user->createdAt)) {
            return null;
        }

        $timestamp = strtotime($user->createdAt);
        return $timestamp ? date('d/m/Y', $timestamp) : null;
    }
}