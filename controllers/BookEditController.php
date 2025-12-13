<?php

class BookEditController
{
    // affiche et traite l'edition d'un livre
    public function edit()
    {
        // verifie que l'utilisateur est connecte
        if (empty($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit;
        }

        $bookId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($bookId <= 0) {
            throw new Exception('Livre introuvable');
        }

        $book = BookModel::findById($bookId);
        if (!$book) {
            throw new Exception('Livre introuvable');
        }

        // verifie que l'utilisateur est le proprietaire
        if ($book->ownerId !== (int) $_SESSION['user_id']) {
            throw new Exception('Vous ne pouvez pas éditer ce livre');
        }

        $error = null;
        $success = false;
        $formTitle = $book->title;
        $formAuthor = $book->author;
        $formDescription = $book->description;
        $formCover = $book->coverUrl;
        $formAvailability = $book->availability ? '1' : '0';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // lit les champs envoyes
            $formTitle = trim($_POST['title'] ?? '');
            $formAuthor = trim($_POST['author'] ?? '');
            $formDescription = trim($_POST['description'] ?? '');
            $formCover = trim($_POST['cover_url'] ?? $book->coverUrl ?? '');
            $formAvailability = (isset($_POST['availability']) && $_POST['availability'] === '1') ? '1' : '0';

            // gere le fichier envoye
            $uploadedCover = $_FILES['cover_file'] ?? null;
            if ($uploadedCover && !empty($uploadedCover['tmp_name'])) {
                $publicDir = 'images/uploads/';
                $diskDir = __DIR__ . '/../' . $publicDir;
                $ext = pathinfo($uploadedCover['name'], PATHINFO_EXTENSION);
                if ($ext === '') {
                    $ext = 'jpg';
                }
                $filename = 'cover_' . time() . '.' . $ext;
                $target = $diskDir . $filename;
                if (move_uploaded_file($uploadedCover['tmp_name'], $target)) {
                    // enregistre le chemin public
                    $formCover = $publicDir . $filename;
                } else {
                    $error = 'Échec du téléversement de la photo';
                }
            }

            if ($formTitle === '' || $formAuthor === '') {
                $error = 'Titre et auteur sont obligatoires';
            } elseif (!$error) {
                BookModel::updateBook(
                    $book->id,
                    $formTitle,
                    $formAuthor,
                    $formDescription,
                    $formCover,
                    $formAvailability === '1'
                );
                $success = true;
                // recharge les donnees
                $book = BookModel::findById($bookId);
                $formTitle = $book->title;
                $formAuthor = $book->author;
                $formDescription = $book->description;
                $formCover = $book->coverUrl;
                $formAvailability = $book->availability ? '1' : '0';
            }
        }

        $coverPreview = $formCover ?: 'images/kinfolk.png';

        $view = new View('Modifier le livre');
        $view->render('editBook', [
            'book' => $book,
            'error' => $error,
            'success' => $success,
            'formValues' => [
                'title' => $formTitle,
                'author' => $formAuthor,
                'description' => $formDescription,
                'cover_url' => $formCover,
                'availability' => $formAvailability,
            ],
            'coverPreview' => $coverPreview,
        ]);
    }
}