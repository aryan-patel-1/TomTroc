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
        $cover = $book->coverUrl ?: 'images/kinfolk.png';
        $ownerName = $owner ? $owner->username : 'Membre TomTroc';
        $ownerPicture = ($owner && !empty($owner->picture)) ? $owner->picture : 'images/hamza.png';
        $description = $book->description ?: 'Description non disponible pour le moment';

        $view = new View($book->title);
        $view->render('book', [
            'book' => $book,
            'owner' => $owner,
            'cover' => $cover,
            'ownerName' => $ownerName,
            'ownerPicture' => $ownerPicture,
            'description' => $description,
        ]);
    }
}