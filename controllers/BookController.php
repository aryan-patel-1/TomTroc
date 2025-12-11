<?php

class BookController
{
    public function books()
    {
        $books = BookModel::findAll();

        // Pré-charge les propriétaires pour l'affichage.
        $owners = [];
        foreach ($books as $book) {
            if ($book->ownerId && !isset($owners[$book->ownerId])) {
                $owners[$book->ownerId] = UserModel::findById($book->ownerId);
            }
        }

        $view = new View('Nos livres à l\'échange');
        $view->render('booksList', [
            'books' => $books,
            'owners' => $owners,
        ]);
    }

    public function book()
    {
        $bookId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($bookId <= 0) {
            throw new Exception('Livre introuvable.');
        }

        $book = BookModel::findById($bookId);
        if (!$book) {
            throw new Exception('Livre introuvable.');
        }

        $owner = $book->ownerId ? UserModel::findById($book->ownerId) : null;

        $view = new View($book->title);
        $view->render('book', [
            'book' => $book,
            'owner' => $owner,
        ]);
    }
}