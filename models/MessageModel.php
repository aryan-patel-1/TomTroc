<?php

class MessageModel
{
    public int $id;
    public int $senderId;
    public int $receiverId;
    public string $content;
    public string $dateTime;
    public ?int $bookId;
    public ?bool $isRead;

    public function __construct(array $row)
    {
        $this->id = (int) $row['message_id'];
        $this->senderId = (int) $row['sender_id'];
        $this->receiverId = (int) $row['receiver_id'];
        $this->content = $row['message_content'];
        $this->dateTime = $row['date_time'];
        $this->isRead = array_key_exists('is_read', $row) ? (bool) $row['is_read'] : null;
    }

    private static function db(): PDO
    {
        return DBManager::getConnection();
    }

    // retourne les conversations d'un utilisateur avec le dernier message
    public static function findGroupByConversation(int $userId): array
    {
        $stmt = self::db()->prepare('SELECT * FROM message WHERE sender_id = :uid OR receiver_id = :uid ORDER BY date_time DESC');
        $stmt->execute(['uid' => $userId]);

        $groupedByConversation = [];
        foreach ($stmt->fetchAll() as $row) {
            $message = new self($row);
            $conversationUserId = $message->senderId === $userId ? $message->receiverId : $message->senderId;

            if (isset($groupedByConversation[$conversationUserId])) {
                continue;
            }
            $groupedByConversation[$conversationUserId] = [
                'lastMessage' => $message,
            ];
        }

        return $groupedByConversation;
    }

    // retourne les messages entre deux utilisateurs
    public static function findThread(int $userId, int $conversationUserId): array
    {
        self::markThreadAsRead($userId, $conversationUserId);

        $stmt = self::db()->prepare(
            'SELECT * FROM message 
            WHERE (sender_id = :uid AND receiver_id = :other) 
            OR (sender_id = :other AND receiver_id = :uid)
            ORDER BY date_time ASC'
        );
        $stmt->execute([
            'uid' => $userId,
            'other' => $conversationUserId,
        ]);

        $messages = [];
        foreach ($stmt->fetchAll() as $row) {
            $messages[] = new self($row);
        }

        return $messages;
    }

    // marque une conversation comme lue pour l'utilisateur connecte
    public static function markThreadAsRead(int $userId, int $conversationUserId): void
    {
        if ($conversationUserId <= 0) {
            return;
        }

        try {
            $stmt = self::db()->prepare(
                'UPDATE message 
                 SET is_read = 1 
                 WHERE receiver_id = :uid 
                 AND sender_id = :other
                 AND (is_read = 0 OR is_read IS NULL)'
            );
            $stmt->execute([
                'uid' => $userId,
                'other' => $conversationUserId,
            ]);
        } catch (PDOException $e) {
            // si la colonne is_read n'existe pas encore, on essaie de l'ajouter puis on relance
            if (str_contains($e->getMessage(), 'is_read')) {
                if (self::ensureIsReadColumn()) {
                    self::markThreadAsRead($userId, $conversationUserId);
                }
                return;
            }
            throw $e;
        }
    }

    // compte les nouveaux messages (non lus) d'un utilisateur
    public static function countUnreadForUser(int $userId): int
    {
        try {
            $stmt = self::db()->prepare(
                'SELECT COUNT(*) 
                 FROM message 
                 WHERE receiver_id = :uid 
                 AND (is_read = 0 OR is_read IS NULL)'
            );
            $stmt->execute(['uid' => $userId]);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            // si la colonne is_read n'est pas presente, on l'ajoute puis on relance la requete
            if (str_contains($e->getMessage(), 'is_read')) {
                if (self::ensureIsReadColumn()) {
                    return self::countUnreadForUser($userId);
                }
                return 0;
            }
            throw $e;
        }
    }

    // ajoute un message
    public static function create(int $senderId, int $receiverId, string $content, ?int $bookId = null): void
    {
        try {
            $stmt = self::db()->prepare(
                'INSERT INTO message (sender_id, receiver_id, message_content, is_read) 
                 VALUES (:sender, :receiver, :content, 0)'
            );
            $stmt->execute([
                'sender' => $senderId,
                'receiver' => $receiverId,
                'content' => $content,
            ]);
        } catch (PDOException $e) {
            // si la colonne is_read n'existe pas encore, on l'ajoute puis on relance l'insert
            if (str_contains($e->getMessage(), 'is_read')) {
                if (self::ensureIsReadColumn()) {
                    self::create($senderId, $receiverId, $content, $bookId);
                    return;
                }
            }
            throw $e;
        }
    }

    // ajoute la colonne is_read si elle est absente pour permettre le suivi des nouveaux messages
    private static function ensureIsReadColumn(): bool
    {
        try {
            $check = self::db()->query("SHOW COLUMNS FROM message LIKE 'is_read'");
            $exists = $check->fetch();
            if ($exists) {
                return true;
            }

            self::db()->exec(
                'ALTER TABLE message 
                 ADD COLUMN is_read TINYINT(1) NOT NULL DEFAULT 0'
            );
            return true;
        } catch (PDOException $e) {
            // on ne bloque pas l'application si on ne peut pas modifier le schéma
            return false;
        }
    }
}