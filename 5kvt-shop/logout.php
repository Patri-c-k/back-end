<?php
session_start();
require_once 'config/db.php';

// Если пользователь авторизован — сохраняем его корзину в БД
if (!empty($_SESSION['user_id']) && !empty($_SESSION['cart'])) {
    $db = DB::getConnection();
    $stmt = $db->prepare("
        INSERT INTO user_carts (user_id, cart) VALUES (:uid, :cart)
        ON DUPLICATE KEY UPDATE cart = :cart2
    ");
    $stmt->execute([
        ':uid'   => $_SESSION['user_id'],
        ':cart'  => json_encode($_SESSION['cart']),
        ':cart2' => json_encode($_SESSION['cart']),
    ]);
}

// Очищаем всю сессию (корзину тоже)
session_destroy();

header('Location: index.php');
exit;
