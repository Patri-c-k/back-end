<?php
// ============================================================
// models/UserModel.php
// ============================================================
require_once __DIR__ . '/../config/db.php';

class UserModel {

    // ----------------------------------------------------------
    // Регистрация нового пользователя
    // Возвращает массив ['ok'=>true,'id'=>N] или ['ok'=>false,'error'=>'...']
    // ----------------------------------------------------------
    public static function register(string $name, string $email, string $phone, string $password): array {
        $db = DB::getConnection();

        // Проверяем, нет ли уже такого email
        $stmt = $db->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        if ($stmt->fetch()) {
            return ['ok' => false, 'error' => 'Пользователь с таким e-mail уже существует.'];
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $db->prepare(
            "INSERT INTO users (name, email, phone, password) VALUES (:name, :email, :phone, :password)"
        );
        $stmt->execute([
            ':name'     => $name,
            ':email'    => $email,
            ':phone'    => $phone,
            ':password' => $hash,
        ]);

        return ['ok' => true, 'id' => (int) $db->lastInsertId()];
    }

    // ----------------------------------------------------------
    // Вход — проверка email + пароль
    // Возвращает массив с данными пользователя или false
    // ----------------------------------------------------------
    public static function login(string $email, string $password): array|false {
        $db   = DB::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    // ----------------------------------------------------------
    // Получить пользователя по ID
    // ----------------------------------------------------------
    public static function getById(int $id): ?array {
        $db   = DB::getConnection();
        $stmt = $db->prepare("SELECT id, name, email, phone, role, created_at FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row  = $stmt->fetch();
        return $row ?: null;
    }
}
