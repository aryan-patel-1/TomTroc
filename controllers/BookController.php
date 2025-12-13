<?php

class BookController
{
    // affiche le detail d'un livre
    public function book()
    {
        $bookId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($bookId <= 0) {
            throw new Exception('Livre introuvable');
        }

        $book = BookModel::findById($bookId);
        if (!$book) {
            throw new Exception('Livre introuvable');
        }

        $owner = $book->ownerId ? UserModel::findById($book->ownerId) : null;

        $view = new View($book->title);
        $view->render('book', [
            'book' => $book,
            'owner' => $owner,
        ]);
    }
}