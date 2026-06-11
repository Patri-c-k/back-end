<?php
// ============================================================
// index.php — Главная страница
// ============================================================
session_start();

require_once 'models/ProductModel.php';
require_once 'models/OrderModel.php';

// ---------- Добавить в корзину ----------
if (isset($_GET['action']) && $_GET['action'] === 'add_to_cart' && isset($_GET['id'])) {
    $pid = (int) $_GET['id'];
    if ($pid > 0) {
        $_SESSION['cart'] = $_SESSION['cart'] ?? [];
        $_SESSION['cart'][$pid] = ($_SESSION['cart'][$pid] ?? 0) + 1;
        $_SESSION['cart_flash'] = 'Товар добавлен в корзину!';
    }
    $params = $_GET;
    unset($params['action'], $params['id']);
    $qs = http_build_query($params);
    // Если есть параметры фильтра — возвращаем в каталог, иначе на верх страницы
    $anchor = $qs ? '#catalog' : '';
    header('Location: index.php' . ($qs ? "?$qs" : '') . $anchor);
    exit;
}

// ---------- Параметры фильтрации ----------
$search   = trim($_GET['search']   ?? '');
$category = trim($_GET['category'] ?? '');
$sort     = trim($_GET['sort']     ?? '');
$page     = max(1, (int) ($_GET['page'] ?? 1));
$limit    = 8;
$offset   = ($page - 1) * $limit;

// ---------- Данные из БД ----------
$products   = ProductModel::getFiltered($search, $category, $sort, $limit, $offset);
$totalCount = ProductModel::countFiltered($search, $category);
$totalPages = (int) ceil($totalCount / $limit);
$categories = ProductModel::getCategories();
$news       = OrderModel::getNews(3);

// Товары месяца (новинки is_new=1)
$monthProducts = ProductModel::getFiltered('', '', '', 7, 0);
// Акции недели (is_promo товары)
$promoProducts = ProductModel::getFiltered('', '', '', 5, 0);

include 'views/header.php';
