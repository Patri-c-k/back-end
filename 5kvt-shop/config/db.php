<?php
// ============================================================
// config/db.php — Подключение к базе данных (PDO singleton)
// ============================================================

class DB {
    private static $instance = null;

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            // --- Настройки подключения ---
            $host     = 'localhost';
            $dbname   = '5kvt_db';
            $user     = 'root';
            $password = 'patrik4970';   // ← замените на свой пароль
            $charset  = 'utf8mb4';

            $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

            // Для OS Panel / OpenServer с именованным каналом раскомментируйте строку ниже
            // и закомментируйте строку выше:
            // $dsn = "mysql:charset=$charset;unix_socket=\\\\.\\pipe\\MySQL-8.0;dbname=$dbname";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instance = new PDO($dsn, $user, $password, $options);
            } catch (PDOException $e) {
                // В продакшне замените на красивую страницу ошибки
                http_response_code(503);
                die('<h2 style="font-family:sans-serif;color:red">Ошибка подключения к базе данных.</h2><p>' . htmlspecialchars($e->getMessage()) . '</p>');
            }
        }
        return self::$instance;
    }
}
