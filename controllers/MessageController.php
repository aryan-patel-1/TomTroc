<?php

class MessageController
{
    public function showMessages() : void
    {
        $view = new View('Messagerie');
        $view->render('messages');
    }
}