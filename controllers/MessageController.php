<?php

class MessageController
{
    public function showMessages() : void
    {
        require_once './views/templates/header.php';
        require_once './views/templates/messages.php';
        require_once './views/templates/footer.php';
    }
}