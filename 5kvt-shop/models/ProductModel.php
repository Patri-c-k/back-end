<?php
// ============================================================
// models/ProductModel.php
// ============================================================
require_once __DIR__ . '/../config/db.php';

class ProductModel {

    // ----------------------------------------------------------
    // Каталог: фильтр + поиск + сортировка + пагинация
    // ----------------------------------------------------------
    public static function getFiltered(
        string $search   = '',
        string $category = '',
        string $sort     = '',
        int    $limit    = 8,
        int    $offset   = 0
    ): array {
        $db   = DB::getConnection();
        $sql  = "SELECT p.*, c.name AS category_name
                 FROM products p
                 JOIN categories c ON p.category_id = c.id
                 WHERE 1=1";
        $params = [];

        if ($search !== '') {
            $sql .= " AND (p.name LIKE :search OR p.brand LIKE :search OR p.description LIKE :search)";
            $params['search'] = "%$search%";
        }
        if ($category !== '') {
            $sql .= " AND c.code = :category";
            $params['category'] = $category;
        }

        $sql .= match ($sort) {
            'price_asc'  => " ORDER BY p.price ASC",
            'price_desc' => " ORDER BY p.price DESC",
            'name_asc'   => " ORDER BY p.name ASC",
            default      => " ORDER BY p.id DESC",
        };

        $sql .= " LIMIT :limit OFFSET :offset";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        foreach ($params as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // ----------------------------------------------------------
    // Подсчёт товаров для пагинации
    // ----------------------------------------------------------
    public static function countFiltered(string $search = '', string $category = ''): int {
        $db   = DB::getConnection();
        $sql  = "SELECT COUNT(*) FROM products p
                 JOIN categories c ON p.category_id = c.id
                 WHERE 1=1";
        $params = [];

        if ($search !== '') {
            $sql .= " AND (p.name LIKE :search OR p.brand LIKE :search OR p.description LIKE :search)";
            $params['search'] = "%$search%";
        }
        if ($category !== '') {
            $sql .= " AND c.code = :category";
            $params['category'] = $category;
        }

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    // ----------------------------------------------------------
    // Один товар по ID
    // ----------------------------------------------------------
    public static function getById(int $id): ?array {
        $db   = DB::getConnection();
        $stmt = $db->prepare(
            "SELECT p.*, c.name AS category_name
             FROM products p
             JOIN categories c ON p.category_id = c.id
             WHERE p.id = :id LIMIT 1"
        );
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    // ----------------------------------------------------------
    // Несколько товаров по массиву ID (для корзины)
    // ----------------------------------------------------------
    public static function getByIds(array $ids): array {
        if (empty($ids)) return [];
        $db          = DB::getConnection();
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt        = $db->prepare(
            "SELECT p.*, c.name AS category_name
             FROM products p
             JOIN categories c ON p.category_id = c.id
             WHERE p.id IN ($placeholders)"
        );
        $stmt->execute(array_values($ids));
        // Индексируем по id для удобства
        $result = [];
        foreach ($stmt->fetchAll() as $row) {
            $result[$row['id']] = $row;
        }
        return $result;
    }

    // ----------------------------------------------------------
    // Все категории (для фильтра)
    // ----------------------------------------------------------
    public static function getCategories(): array {
        $db   = DB::getConnection();
        $stmt = $db->query("SELECT * FROM categories ORDER BY name ASC");
        return $stmt->fetchAll();
    }
}
