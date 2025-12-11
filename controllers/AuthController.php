<?php

class AuthController
{

    // Affiche la page d'inscription et gère la création d'un nouveau compte utilisateur
    public function register()
    {
        $error = null;
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
                // Création d'un nouveau compte utilisateur (photo non fournie à l'inscription)
                $user = UserModel::createUser($username, $email, $password, null);

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

        // Affichage de la page d'inscription via le système de vues
        $view = new View('Inscription');
        $view->render('register', ['error' => $error]);
    }
    //Affiche la page de login et gère la tentative de connexion
    public function login()
    {
        $error = null;
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

        // Rendu de la page de connexion via le système de vues
        $view = new View('Connexion');
        $view->render('login', ['error' => $error]);
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