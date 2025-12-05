<?php

class BookController
{
    public function books()
    {
        require_once './views/templates/header.php';
        require_once './views/templates/booksList.php';
        require_once './views/templates/footer.php';
    }

    public function book()
    {
        require_once './views/templates/header.php';
        require_once './views/templates/book.php';
        require_once './views/templates/footer.php';
    }
}
