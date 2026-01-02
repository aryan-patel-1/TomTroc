<?php

class BookController
{
    // affiche le detail d'un livre
    public function book()
    {
        $book = $this->loadBookOrFail((int) ($_GET['id'] ?? 0));
        $owner = $book->ownerId ? UserModel::findById($book->ownerId) : null;

        // prépare les valeurs d'affichage avec des valeurs de repli
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

    // charge un livre ou lève une exception si l'id est invalide
    private function loadBookOrFail(int $bookId)
    {
        if ($bookId <= 0) {
            throw new Exception('Livre introuvable');
        }

        $book = BookModel::findById($bookId);
        if (!$book) {
            throw new Exception('Livre introuvable');
        }

        return $book;
    }
}