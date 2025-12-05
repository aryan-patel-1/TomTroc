<?php

class UserModel
{
    public int $id;
    public string $username;
    public string $email;
    public string $passwordHash;
    public string $createdAt;

    public function __construct(array $row)
    {
        $this->id = (int) $row['user_id'];
        $this->username = $row['username'];
        $this->email = $row['email'];
        $this->passwordHash = $row['password_hash'];
        $this->createdAt = $row['date_time'];
    }

    // Accès  à la connexion PDO
    private static function db(): PDO
    {
        return DBManager::getConnection();
    }

    public static function findByEmail(string $email): ?UserModel
    {
        $stmt = self::db()->prepare('SELECT * FROM user WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();

        return $row ? new self($row) : null;
    }

    public static function findById(int $id): ?UserModel
    {
        $stmt = self::db()->prepare('SELECT * FROM user WHERE user_id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ? new self($row) : null;
    }

    public static function create(string $username, string $email, string $password): UserModel
    {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $db = self::db();

        $stmt = $db->prepare('INSERT INTO user (username, email, password_hash) VALUES (:username, :email, :password_hash)');
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password_hash' => $passwordHash,
        ]);

        return self::findById((int) $db->lastInsertId());
    }

    public static function authenticate(string $email, string $password): ?UserModel
    {
        $user = self::findByEmail($email);

        if ($user && password_verify($password, $user->passwordHash)) {
            return $user;
        }

        return null;
    }

    // Liste des utilisateurs, à l'exception d'un éventuel utilisateur exclu (ex : l'expéditeur).
    public static function getAllExcept(?int $excludedId = null): array
    {
        if ($excludedId) {
            $stmt = self::db()->prepare('SELECT * FROM user WHERE user_id != :id ORDER BY username');
            $stmt->execute(['id' => $excludedId]);
        } else {
            $stmt = self::db()->query('SELECT * FROM user ORDER BY username');
        }

        return array_map(fn($row) => new self($row), $stmt->fetchAll());
    }
}