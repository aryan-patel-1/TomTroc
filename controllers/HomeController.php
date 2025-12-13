<?php

class HomeController
{
    public function showHome()
    {
        $latestBooks = BookModel::findLatest(4);

        // precharge les proprietaires des livres recents
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