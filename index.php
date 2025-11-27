<?php

require_once 'config/database.php';
require_once 'config/autoload.php';

$page = $_GET['page'] ?? 'home';

try {
    switch ($page) {

    case 'home':
        $homeController = new HomeController();
        $homeController->showHome();
        break;

    case 'login':
    $controller = new AuthController();
    $controller->login();
    break;

    case 'register':
    $controller = new AuthController();
    $controller->register();
    break;


        default:
            throw new Exception("La page demandée n'existe pas.");
    }
} catch (Exception $e) {
    // En cas d'erreur, on affiche la page d'erreur.
    $errorView = new View('Erreur');
    $errorView->render('errorPage', ['errorMessage' => $e->getMessage()]);
}
