<?php

class BooksController
{
    // affiche la liste des livres
    public function showList()
    {
        $books = BookModel::findAll();

        // precharge les proprietaires
        $owners = [];
        foreach ($books as $book) {
            if ($book->ownerId && !isset($owners[$book->ownerId])) {
                $owners[$book->ownerId] = UserModel::findById($book->ownerId);
            }
        }

        $view = new View('Nos livres à l\'échange');
        $view->render('booksList', [
            'bookList' => $books,
            'ownersById' => $owners,
        ]);
    }
}