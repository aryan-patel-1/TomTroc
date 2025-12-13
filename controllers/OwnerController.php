<?php

class OwnerController
{
    public function showOwner()
    {
        $ownerId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($ownerId <= 0) {
            throw new Exception('Propriétaire introuvable');
        }

        $owner = UserModel::findById($ownerId);
        if (!$owner) {
            throw new Exception('Propriétaire introuvable');
        }

        $books = BookModel::findByOwnerId($ownerId);

        $view = new View('Profil propriétaire');
        $view->render('owner', [
            'owner' => $owner,
            'books' => $books,
        ]);
    }

}