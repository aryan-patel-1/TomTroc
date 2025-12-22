<?php

class UserModel
{
    public int $id;
    public string $username;
    public string $email;
    public string $passwordHash;
    public string $createdAt;
    public ?string $picture;

    public function __construct(array $row)
    {
        $this->id = $row['user_id'];
        $this->username = $row['username'];
        $this->email = $row['email'];
        $this->passwordHash = $row['password_hash'];
        $this->createdAt = $row['date_time'];
        $this->picture = $row['user_picture'] ?? null;
    }

    private static function db(): PDO
    {
        return DBManager::getConnection();
    }

    public static function findByEmail(string $email): ?UserModel
    {
        $stmt = self::db()->prepare('SELECT * FROM user WHERE email = :email LIMIT 1');
        // Exécution de la requête avec l'email passé en paramètre
        $stmt->execute(['email' => $email]);
        // Récupère la première ligne de résultat
        $row = $stmt->fetch();

        // Si une ligne est trouvée, on crée un UserModel, sinon on retourne null
        return $row ? new self($row) : null;
    }

    public static function findById(int $id): ?UserModel
    {
        // Requête préparée avec le paramètre :id
        $stmt = self::db()->prepare('SELECT * FROM user WHERE user_id = :id LIMIT 1');

        // On injecte l'id dans la requête
        $stmt->execute(['id' => $id]);

        // Récupération de la ligne
        $row = $stmt->fetch();

        // Conversion en UserModel si trouvée
        return $row ? new self($row) : null;
    }

    /*
     * Crée un nouvel utilisateur en base de données
     * Retourne l'objet UserModel correspondant à ce nouvel utilisateur
     */
    public static function createUser(string $username, string $email, string $password, ?string $picture = null): UserModel
    {
        // hash le mot de passe avant de le stocker
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // Récupération de la connexion PDO
        $db = self::db();

        // Préparation de l'INSERT avec les paramètres
        $stmt = $db->prepare(
            'INSERT INTO user (username, email, password_hash, user_picture) 
             VALUES (:username, :email, :password_hash, :user_picture)'
        );

        // Exécution de la requête avec les valeurs à insérer
        $stmt->execute([
            'username' => $username,
            'email'=> $email,
            'password_hash'=> $passwordHash,
            'user_picture' => $picture ?? '',
        ]);

        // Récupère l'id du dernier enregistrement inséré
        $lastId = $db->lastInsertId();

        // On recharge cet utilisateur pour retourner un UserModel
        return self::findById($lastId);
    }

    // Met à jour un utilisateur
    public static function updateUser(int $id, string $username, string $email, ?string $picture = null, ?string $newPassword = null): void
    {
        $fields = [
            'username' => $username,
            'email' => $email,
            'user_picture' => $picture ?? '',
        ];

        $setSql = 'username = :username, email = :email, user_picture = :user_picture';

        if ($newPassword !== null && $newPassword !== '') {
            $fields['password_hash'] = password_hash($newPassword, PASSWORD_BCRYPT);
            $setSql .= ', password_hash = :password_hash';
        }

        $fields['id'] = $id;

        $stmt = self::db()->prepare("UPDATE user SET $setSql WHERE user_id = :id");
        $stmt->execute($fields);
    }

    /*
     * Authentifie un utilisateur à partir de son email et de son mot de passe
     * - Cherche l'utilisateur par email
     * - Vérifie que le mot de passe fourni correspond au hash stocké
     * - Retourne l'objet UserModel si l'authentification est ok sinon null
     */
    public static function authenticate(string $email, string $password): ?UserModel
    {
        // récupère l'utilisateur correspondant à cet email (ou null)
        $user = self::findByEmail($email);

        // Si un utilisateur est trouvé ET que le mot de passe est correct
        if ($user && password_verify($password, $user->passwordHash)) {
            // Authentification réussie : on retourne l'objet utilisateur
            return $user;
        }
        // Si l'email n'existe pas ou le mot de passe est incorrect : échec
        return null;
    }
}