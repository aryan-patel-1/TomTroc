<?php

class BookModel
{
    public int $id;
    public string $title;
    public string $author;
    public string $description;
    public int $ownerId;
    public bool $availability;
    public string $coverUrl;

    public function __construct(array $row)
    {
        $this->id = isset($row['book_id']) ? (int) $row['book_id'] : 0;
        $this->title = $row['book_title'] ?? '';
        $this->author = $row['author'] ?? '';
        $this->description = $row['book_description'] ?? '';
        $this->ownerId = isset($row['owner_id']) ? (int) $row['owner_id'] : 0;
        $this->availability = !empty($row['availability']);
        $this->coverUrl = $row['cover_url'] ?? '';
    }

    private static function db(): PDO
    {
        return DBManager::getConnection();
    }

    public static function findAll(): array
    {
        $stmt = self::db()->query('SELECT * FROM book ORDER BY book_id DESC');

        $books = [];
        foreach ($stmt->fetchAll() as $row) {
            $books[] = new self($row);
        }

        return $books;
    }

    /**
     * Retourne les derniers livres ajoutés, limités au nombre demandé.
     */
    public static function findLatest(int $limit = 4): array
    {
        $stmt = self::db()->prepare('SELECT * FROM book ORDER BY book_id DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $books = [];
        foreach ($stmt->fetchAll() as $row) {
            $books[] = new self($row);
        }

        return $books;
    }

    public static function findById(int $id): ?self
    {
        $stmt = self::db()->prepare('SELECT * FROM book WHERE book_id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch();

        return $row ? new self($row) : null;
    }

    /**
     * Retourne tous les livres d'un propriétaire donné.
     */
    public static function findByOwnerId(int $ownerId): array
    {
        $stmt = self::db()->prepare('SELECT * FROM book WHERE owner_id = :owner ORDER BY book_id DESC');
        $stmt->execute(['owner' => $ownerId]);

        $books = [];
        foreach ($stmt->fetchAll() as $row) {
            $books[] = new self($row);
        }

        return $books;
    }

    /**
     * Met à jour un livre existant.
     */
    public static function updateBook(int $id, string $title, string $author, string $description, string $coverUrl, bool $availability): void
    {
        $stmt = self::db()->prepare(
            'UPDATE book 
             SET book_title = :title,
                 author = :author,
                 book_description = :description,
                 cover_url = :cover_url,
                 availability = :availability
                 WHERE book_id = :id'
        );

        $stmt->execute([
            'title' => $title,
            'author' => $author,
            'description' => $description,
            'cover_url' => $coverUrl,
            'availability' => $availability ? 1 : 0,
            'id' => $id,
        ]);
    }
}