<?php

class AuthController
{
    public function login()
    {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validation rapide du formulaire de connexion avant authentification
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($email === '' || $password === '') {
                $error = 'Merci de remplir tous les champs.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Adresse email invalide.';
            } else {
                $user = UserModel::authenticate($email, $password);
                if ($user) {
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $user->id;
                    $_SESSION['username'] = $user->username;
                    header('Location: ?page=home');
                    exit;
                }
                $error = 'Email ou mot de passe incorrect.';
            }
        }

        require_once './views/templates/header.php';
        require_once './views/templates/login.php';
        require_once './views/templates/footer.php';
    }

    public function register()
    {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Création d'un compte avec contrôles de base et enregistrement du nouvel utilisateur
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($username === '' || $email === '' || $password === '') {
                $error = 'Merci de remplir tous les champs.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Adresse email invalide.';
            } elseif (UserModel::findByEmail($email)) {
                $error = 'Cet email est déjà utilisé.';
            } else {
                $user = UserModel::create($username, $email, $password);
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user->id;
                $_SESSION['username'] = $user->username;
                header('Location: ?page=home');
                exit;
            }
        }

        require_once './views/templates/header.php';
        require_once './views/templates/register.php';
        require_once './views/templates/footer.php';
    }

    public function logout()
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
        header('Location: ?page=home');
        exit;
    }
}