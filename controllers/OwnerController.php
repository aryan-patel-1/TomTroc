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

        $booksCount = count($books);
        $ownerName = $owner->username ?? 'Membre TomTroc';
        $ownerPicture = !empty($owner->picture) ? $owner->picture : 'images/hamza.png';
        $memberSinceText = 'Membre TomTroc';
        if (!empty($owner->createdAt)) {
            $timestamp = strtotime($owner->createdAt);
            if ($timestamp) {
                $memberSinceText = date('d/m/Y', $timestamp);
            }
        }

        $view = new View('Profil propriétaire');
        $view->render('owner', [
            'owner' => $owner,
            'books' => $books,
            'booksCount' => $booksCount,
            'ownerName' => $ownerName,
            'ownerPicture' => $ownerPicture,
            'memberSinceText' => $memberSinceText,
        ]);
    }

}