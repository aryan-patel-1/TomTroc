<?php

class AuthController
{

    // Affiche la page d'inscription et gère la création d'un nouveau compte utilisateur
    public function register()
    {
        // Quand le formulaire est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Récupération des données envoyées
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // Vérification des champs obligatoires
            if ($username === '' || $email === '' || $password === '') {
                $error = 'Merci de remplir tous les champs.';

            // Vérification de la validité de l'adresse email
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Adresse email invalide.';

            // Vérifie si un compte existe déjà avec cet email
            } elseif (UserModel::findByEmail($email)) {
                $error = 'Cet email est déjà utilisé.';

            } else {
                // Création d'un nouveau compte utilisateur
                $user = UserModel::create($username, $email, $password);

                // Sécurisation de la session
                session_regenerate_id(true);

                // On stocke les infos utilisateur dans la session
                $_SESSION['user_id'] = $user->id;
                $_SESSION['username'] = $user->username;

                // Redirection vers l'accueil après succès
                header('Location: ?page=home');
                exit;
            }
        }

        // Affichage de la page d'inscription
        require_once './views/templates/header.php';
        require_once './views/templates/register.php';
        require_once './views/templates/footer.php>';
    }
    //Affiche la page de login et gère la tentative de connexion
    public function login()
    {
        // Si le formulaire est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // On récupère l'email et le password
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // Vérification des champs vides
            if ($email === '' || $password === '') {
                $error = 'Merci de remplir tous les champs.';

            // Vérification du format de l'adresse email
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Adresse email invalide.';

            } else {
                // Tentative d’authentification via UserModel
                $user = UserModel::authenticate($email, $password);

                // Si l'utilisateur existe et le mot de passe est correct
                if ($user) {
                    // Sécurise la session — empêche le vol de session
                    session_regenerate_id(true);

                    // On stocke les infos de l'utilisateur
                    $_SESSION['user_id'] = $user->id;
                    $_SESSION['username'] = $user->username;

                    // Redirection vers la page d'accueil après connexion réussie
                    header('Location: ?page=home');
                    exit;
                }
                // En cas d'échec de l'authentification
                $error = 'Email ou mot de passe incorrect.';
            }
        }

        // Inclusion des templates (header page login footer)
        require_once './views/templates/header.php';
        require_once './views/templates/login.php';
        require_once './views/templates/footer.php';
    }

    /**
     * Déconnecte l'utilisateur, détruit proprement la session et redirige vers l'accueil.
     */
    public function logout()
    {
        // On vide les variables de session
        $_SESSION = [];

        // Destruction complète de la session
        session_destroy();

        // Redirection vers la page d'accueil
        header('Location: ?page=home');
        exit;
    }
}