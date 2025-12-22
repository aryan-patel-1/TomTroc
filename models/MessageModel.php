<?php

class MessageModel
{
    public int $id;
    public int $senderId;
    public int $receiverId;
    public string $content;
    public string $dateTime;
    public ?int $bookId;

    public function __construct(array $row)
    {
        $this->id = (int) $row['message_id'];
        $this->senderId = (int) $row['sender_id'];
        $this->receiverId = (int) $row['receiver_id'];
        $this->content = $row['message_content'];
        $this->dateTime = $row['date_time'];
    }

    private static function db(): PDO
    {
        return DBManager::getConnection();
    }

    // retourne les conversations d'un utilisateur avec le dernier message
    public static function findConversations(int $userId): array
    {
        $stmt = self::db()->prepare('SELECT * FROM message WHERE sender_id = :uid OR receiver_id = :uid ORDER BY date_time DESC');
        $stmt->execute(['uid' => $userId]);

        $conversations = [];
        foreach ($stmt->fetchAll() as $row) {
            $message = new self($row);
            $otherId = $message->senderId === $userId ? $message->receiverId : $message->senderId;

            if (isset($conversations[$otherId])) {
                continue;
            }

            $conversations[$otherId] = [
                'lastMessage' => $message,
            ];
        }

        return $conversations;
    }

    // retourne les messages entre deux utilisateurs
    public static function findThread(int $userId, int $otherId): array
    {
        $stmt = self::db()->prepare(
            'SELECT * FROM message 
            WHERE (sender_id = :uid AND receiver_id = :other) 
            OR (sender_id = :other AND receiver_id = :uid)
            ORDER BY date_time ASC'
        );
        $stmt->execute([
            'uid' => $userId,
            'other' => $otherId,
        ]);

        $messages = [];
        foreach ($stmt->fetchAll() as $row) {
            $messages[] = new self($row);
        }

        return $messages;
    }

    // ajoute un message
    public static function create(int $senderId, int $receiverId, string $content, ?int $bookId = null): void
    {
        $stmt = self::db()->prepare(
            'INSERT INTO message (sender_id, receiver_id, message_content) 
             VALUES (:sender, :receiver, :content)'
        );
        $stmt->execute([
            'sender' => $senderId,
            'receiver' => $receiverId,
            'content' => $content,
        ]);
    }
}