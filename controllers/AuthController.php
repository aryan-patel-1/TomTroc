<?php

class AuthController
{

    // Affiche la page d'inscription et gère la création d'un nouveau compte utilisateur
    public function register()
    {
        $error = null;
        // Quand le formulaire est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // récupère et nettoie les saisies
            [$username, $email, $password] = AuthService::prepareRegisterData($_POST);

            // valide les données et vérifie l'unicité de l'email
            $error = AuthService::validateRegister($username, $email, $password);

            if (!$error) {
                $user = UserModel::createUser($username, $email, $password, null);
                AuthService::startUserSession($user);
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

            // récupère et nettoie l'email/mot de passe
            [$email, $password] = AuthService::prepareLoginData($_POST);

            $error = AuthService::validateLogin($email, $password);

            if (!$error) {
                $user = UserModel::authenticate($email, $password);

                if ($user) {
                    AuthService::startUserSession($user);
                    header('Location: ?page=home');
                    exit;
                }
                $error = 'Email ou mot de passe incorrect';
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