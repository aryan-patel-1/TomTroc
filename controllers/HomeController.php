<?php

class HomeController
{
    public function showHome()
    {
        $latestBooks = BookModel::findLatest(4);

        // Pré-charge les propriétaires des livres récents.
        $owners = [];
        foreach ($latestBooks as $book) {
            if ($book->ownerId && !isset($owners[$book->ownerId])) {
                $owners[$book->ownerId] = UserModel::findById($book->ownerId);
            }
        }

        $view = new View('Accueil');
        $view->render('home', [
            'books' => $latestBooks,
            'owners' => $owners,
        ]);
    }
}
