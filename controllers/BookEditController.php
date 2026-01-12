<?php

class BookEditController
{
    public function edit()
    {
        // verifie connexion
        AuthService::ensureAuthenticated();

        // charge livre et valeurs du formulaire
        $bookId = (int) ($_GET['id'] ?? 0);
        $book = BookEditService::loadBookForEdit($bookId, (int) $_SESSION['user_id']);
        $formValues = BookEditService::formValuesFromBook($book);
        $error = null;
        $success = false;

        // traite la soumission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            [$error, $success, $book, $formValues] = BookEditService::handleUpdate($book, $_POST);
        }

        // rendu de la page
        $view = new View('Modifier le livre');
        $view->render('editBook', [
            'book' => $book,
            'error' => $error,
            'success' => $success,
            'formValues' => $formValues,
            'coverPreview' => $formValues['cover_url'] ?: 'images/kinfolk.png',
            'availabilityValue' => $formValues['availability'],
        ]);
    }
}