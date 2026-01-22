<?php

// En fonction des routes utilisées, il est possible d'avoir besoin de la session ; on la démarre dans tous les cas. 
session_start();

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
    $logController = new AuthController();
    $logController->login();
    break;

    case 'register':
    $registerController = new AuthController();
    $registerController->register();
    break;

    case 'account':
    $accountController = new AccountController();
    $accountController->showAccount();
    break;

    case 'messages':
    $messagesController = new MessageController();
    $messagesController->showMessages();
    break;

    case 'owner':
    $ownerController = new OwnerController();
    $ownerController->showOwner();
    break;

    case 'booksList':
    $booksController = new BooksController();
    $booksController->showList();
    break;

    case 'book':
    $bookController = new BookController();
    $bookController->book();
    break;

    case 'bookEdit':
    $bookEditController = new BookEditController();
    $bookEditController->edit();
    break;

    case 'logout':
    $authController = new AuthController();
    $authController->logout();
    break;

        default:
            throw new Exception("La page demandée n'existe pas.");
    }
} catch (Exception $e) {
    // En cas d'erreur, on affiche la page d'erreur.
    $errorView = new View('Erreur');
    $errorView->render('errorPage', ['errorMessage' => $e->getMessage()]);
}