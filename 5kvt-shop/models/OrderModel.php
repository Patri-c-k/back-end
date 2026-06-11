<?php
// ============================================================
// models/OrderModel.php
// ============================================================
require_once __DIR__ . '/../config/db.php';

class OrderModel {

    // ----------------------------------------------------------
    // Создать заказ
    // $cart = [ product_id => quantity, ... ]
    // $products = результат ProductModel::getByIds()
    // Возвращает ID нового заказа
    // ----------------------------------------------------------
    public static function create(array $data, array $cart, array $products): int {
        $db = DB::getConnection();

        // Считаем сумму
        $total = 0;
        foreach ($cart as $pid => $qty) {
            if (isset($products[$pid])) {
                $total += $products[$pid]['price'] * $qty;
            }
        }

        // Вставляем заголовок заказа
        $stmt = $db->prepare(
            "INSERT INTO orders (user_id, name, email, phone, address, comment, total_amount)
             VALUES (:user_id, :name, :email, :phone, :address, :comment, :total)"
        );
        $stmt->execute([
            ':user_id' => $data['user_id'] ?? null,
            ':name'    => $data['name'],
            ':email'   => $data['email'],
            ':phone'   => $data['phone'],
            ':address' => $data['address'],
            ':comment' => $data['comment'] ?? '',
            ':total'   => $total,
        ]);
        $orderId = (int) $db->lastInsertId();

        // Вставляем позиции
        $itemStmt = $db->prepare(
            "INSERT INTO order_items (order_id, product_id, product_name, price, quantity)
             VALUES (:order_id, :product_id, :product_name, :price, :quantity)"
        );
        foreach ($cart as $pid => $qty) {
            if (isset($products[$pid])) {
                $itemStmt->execute([
                    ':order_id'    => $orderId,
                    ':product_id'  => $pid,
                    ':product_name'=> $products[$pid]['name'],
                    ':price'       => $products[$pid]['price'],
                    ':quantity'    => $qty,
                ]);
            }
        }

        return $orderId;
    }

    // ----------------------------------------------------------
    // Заказы пользователя (личный кабинет)
    // ----------------------------------------------------------
    public static function getByUser(int $userId): array {
        $db   = DB::getConnection();
        $stmt = $db->prepare(
            "SELECT * FROM orders WHERE user_id = :uid ORDER BY created_at DESC"
        );
        $stmt->execute([':uid' => $userId]);
        return $stmt->fetchAll();
    }

    // ----------------------------------------------------------
    // Позиции одного заказа
    // ----------------------------------------------------------
    public static function getItems(int $orderId): array {
        $db   = DB::getConnection();
        $stmt = $db->prepare("SELECT * FROM order_items WHERE order_id = :oid");
        $stmt->execute([':oid' => $orderId]);
        return $stmt->fetchAll();
    }

    // ----------------------------------------------------------
    // Новости (контент для главной)
    // ----------------------------------------------------------
    public static function getNews(int $limit = 3): array {
        $db   = DB::getConnection();
        $stmt = $db->prepare(
            "SELECT * FROM news WHERE is_active = 1 ORDER BY created_at DESC LIMIT :lim"
        );
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
