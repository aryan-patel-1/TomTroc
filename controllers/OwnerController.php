<?php

class OwnerController
{
    public function show()
    {
        $ownerId = isset($_GET['id']) ? (int) $_GET['id'] : null;

        if (!$ownerId) {
            throw new Exception('Propriétaire introuvable.');
        }

        $owner = UserModel::findById($ownerId);
        if (!$owner) {
            throw new Exception('Propriétaire introuvable.');
        }

        require_once './views/templates/header.php';
        require_once './views/templates/owner.php';
        require_once './views/templates/footer.php';
    }

    // Alias pour correspondre aux routes utilisées dans index.php
    public function showOwner()
    {
        $this->show();
    }
}