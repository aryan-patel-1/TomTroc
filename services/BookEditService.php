<?php

class BookEditService
{
    public static function loadBookForEdit(int $bookId, int $userId): BookModel
    {
        if ($bookId <= 0) {
            throw new Exception('Livre introuvable');
        }

        $book = BookModel::findById($bookId);
        if (!$book) {
            throw new Exception('Livre introuvable');
        }

        if ($book->ownerId !== $userId) {
            throw new Exception('Vous ne pouvez pas éditer ce livre');
        }

        return $book;
    }

    public static function formValuesFromBook(BookModel $book): array
    {
        return [
            'title' => $book->title,
            'author' => $book->author,
            'description' => $book->description,
            'cover_url' => $book->coverUrl,
            'availability' => $book->availability ? '1' : '0',
        ];
    }

    public static function handleUpdate(BookModel $book, array $post): array
    {
        $formValues = [
            'title' => trim($post['title'] ?? ''),
            'author' => trim($post['author'] ?? ''),
            'description' => trim($post['description'] ?? ''),
            'cover_url' => $book->coverUrl,
            'availability' => (isset($post['availability']) && $post['availability'] === '1') ? '1' : '0',
        ];

        $upload = EditPictures::upload('cover_file');

        if ($formValues['title'] === '' || $formValues['author'] === '') {
            return ['Titre et auteur sont obligatoires', false, $book, $formValues];
        }

        if (!empty($upload['error'])) {
            return [$upload['error'], false, $book, $formValues];
        }

        $formValues['cover_url'] = $upload['path'] ?? $book->coverUrl;

        BookModel::updateBook(
            $book->id,
            $formValues['title'],
            $formValues['author'],
            $formValues['description'],
            $formValues['cover_url'],
            $formValues['availability'] === '1'
        );

        $book = BookModel::findById($book->id) ?? $book;
        $formValues = self::formValuesFromBook($book);

        return [null, true, $book, $formValues];
    }
}