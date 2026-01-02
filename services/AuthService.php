<?php

class AuthService
{
    // prépare les champs d'inscription (trim et fallback)
    public static function prepareRegisterData(array $data): array
    {
        return [
            trim($data['username'] ?? ''),
            trim($data['email'] ?? ''),
            $data['password'] ?? '',
        ];
    }

    // prépare les champs de connexion (trim et fallback)
    public static function prepareLoginData(array $data): array
    {
        return [
            trim($data['email'] ?? ''),
            $data['password'] ?? '',
        ];
    }

    // valide les entrées d'inscription
    public static function validateRegister(string $username, string $email, string $password): ?string
    {
        if ($username === '' || $email === '' || $password === '') {
            return 'Merci de remplir tous les champs';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Adresse email invalide';
        }

        if (UserModel::findByEmail($email)) {
            return 'Cet email est déjà utilisé';
        }

        return null;
    }

    // valide les entrées de connexion
    public static function validateLogin(string $email, string $password): ?string
    {
        if ($email === '' || $password === '') {
            return 'Merci de remplir tous les champs';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Adresse email invalide';
        }

        return null;
    }

    // prépare la session utilisateur après authentification
    public static function startUserSession($user): void
    {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user->id;
        $_SESSION['username'] = $user->username;
    }

    // force la connexion sinon redirige vers login
    public static function ensureAuthenticated(): void
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit;
        }
    }
}