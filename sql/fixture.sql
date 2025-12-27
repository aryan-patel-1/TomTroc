-- =========================================
-- FIXTURES UTILISATEURS
-- =========================================

SET @PASSWORD_HASH := '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

INSERT INTO `user` (user_id, username, email, password_hash, date_time, user_picture) VALUES
(10,  'alice',      'alice@example.com',      @PASSWORD_HASH, '2025-01-01 10:00:00', 'images/milk.png'),
(11,  'bob',        'bob@example.com',        @PASSWORD_HASH, '2025-01-01 10:05:00', 'images/milk.png'),
(12,  'charlie',    'charlie@example.com',    @PASSWORD_HASH, '2025-01-01 10:10:00', 'images/milk.png'),
(13,  'diane',      'diane@example.com',      @PASSWORD_HASH, '2025-01-01 10:15:00', 'images/milk.png'),
(14,  'eric',       'eric@example.com',       @PASSWORD_HASH, '2025-01-01 10:20:00', 'images/milk.png'),
(15,  'fatima',     'fatima@example.com',     @PASSWORD_HASH, '2025-01-01 10:25:00', 'images/milk.png'),
(16,  'georges',    'georges@example.com',    @PASSWORD_HASH, '2025-01-01 10:30:00', 'images/milk.png'),
(17,  'hannah',     'hannah@example.com',     @PASSWORD_HASH, '2025-01-01 10:35:00', 'images/milk.png'),
(18,  'igor',       'igor@example.com',       @PASSWORD_HASH, '2025-01-01 10:40:00', 'images/milk.png'),
(19, 'julie',      'julie@example.com',      @PASSWORD_HASH, '2025-01-01 10:45:00', 'images/milk.png'),
(20, 'khaled',     'khaled@example.com',     @PASSWORD_HASH, '2025-01-01 10:50:00', 'images/milk.png'),
(21, 'lea',        'lea@example.com',        @PASSWORD_HASH, '2025-01-01 10:55:00', 'images/milk.png');

INSERT INTO book (book_id, book_title, author, book_description, owner_id, date_time, availability, cover_url) VALUES
(10, 'Livre 1',  'Auteur 1',  'Description simple du livre 1.',  10, '2025-01-02 09:00:00', 1, 'https://picsum.photos/id/1010/400/400'),
(11, 'Livre 2',  'Auteur 2',  'Description simple du livre 2.',  11, '2025-01-02 09:05:00', 1, 'https://picsum.photos/id/1011/400/400'),
(12, 'Livre 3',  'Auteur 3',  'Description simple du livre 3.',  12, '2025-01-02 09:10:00', 0, 'https://picsum.photos/id/1012/400/400'),
(13, 'Livre 4',  'Auteur 4',  'Description simple du livre 4.',  13, '2025-01-02 09:15:00', 1, 'https://picsum.photos/id/1013/400/400'),
(14, 'Livre 5',  'Auteur 5',  'Description simple du livre 5.',  14, '2025-01-02 09:20:00', 1, 'https://picsum.photos/id/1014/400/400'),
(15, 'Livre 6',  'Auteur 6',  'Description simple du livre 6.',  15, '2025-01-02 09:25:00', 0, 'https://picsum.photos/id/1015/400/400'),
(16, 'Livre 7',  'Auteur 7',  'Description simple du livre 7.',  16, '2025-01-02 09:30:00', 1, 'https://picsum.photos/id/1016/400/400'),
(17, 'Livre 8',  'Auteur 8',  'Description simple du livre 8.',  17, '2025-01-02 09:35:00', 1, 'https://picsum.photos/id/1017/400/400'),
(18, 'Livre 9',  'Auteur 9',  'Description simple du livre 9.',  18, '2025-01-02 09:40:00', 1, 'https://picsum.photos/id/1018/400/400'),
(19, 'Livre 10', 'Auteur 10', 'Description simple du livre 10.', 19, '2025-01-02 09:45:00', 0, 'https://picsum.photos/id/1019/400/400'),
(20, 'Livre 11', 'Auteur 11', 'Description simple du livre 11.', 20, '2025-01-02 09:50:00', 1, 'https://picsum.photos/id/1020/400/400'),
(21, 'Livre 12', 'Auteur 12', 'Description simple du livre 12.', 21, '2025-01-02 09:55:00', 1, 'https://picsum.photos/id/1021/400/400');
