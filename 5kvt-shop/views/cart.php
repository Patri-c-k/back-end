<?php
// ============================================================
// cart.php — Корзина (Пункт 3 чек-листа)
// ============================================================
session_start();
require_once 'models/ProductModel.php';

$_SESSION['cart'] = $_SESSION['cart'] ?? [];

// ---- Изменить количество ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {

        $pid = (int) ($_POST['pid'] ?? 0);

        if ($_POST['action'] === 'update' && $pid > 0) {
            $qty = (int) ($_POST['qty'] ?? 0);
            if ($qty <= 0) {
                unset($_SESSION['cart'][$pid]);
            } else {
                $_SESSION['cart'][$pid] = $qty;
            }
        }

        if ($_POST['action'] === 'remove' && $pid > 0) {
            unset($_SESSION['cart'][$pid]);
        }

        if ($_POST['action'] === 'clear') {
            $_SESSION['cart'] = [];
        }
    }
    header('Location: cart.php');
    exit;
}

// ---- Загружаем данные товаров из БД ----
$cartProducts = [];
$total        = 0;

if (!empty($_SESSION['cart'])) {
    $cartProducts = ProductModel::getByIds(array_keys($_SESSION['cart']));
    foreach ($_SESSION['cart'] as $pid => $qty) {
        if (isset($cartProducts[$pid])) {
            $total += $cartProducts[$pid]['price'] * $qty;
        }
    }
}

$cartCount = array_sum($_SESSION['cart']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Корзина — 5КВТ</title>
  <link rel="stylesheet" href="style(1).css">
  <style>
    body { background: #f4f6f8; font-family: 'Lato', sans-serif; }
    .cart-wrap { max-width: 900px; margin: 40px auto; padding: 0 15px; }
    .cart-box  { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.08); padding: 30px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 12px 10px; text-align: left; font-size: 14px; }
    th { border-bottom: 2px solid #eee; color: #777; font-weight: 600; font-size: 13px; }
    tr + tr td { border-top: 1px solid #f0f0f0; }
    .qty-input { width: 58px; padding: 6px; border: 1px solid #ddd; border-radius: 5px; text-align: center; font-size: 14px; }
    .btn-sm { padding: 7px 14px; border: none; border-radius: 5px; cursor: pointer; font-size: 13px; font-weight: 600; }
    .btn-remove { background: #fff0f0; color: #c0392b; }
    .btn-update { background: #fff7e6; color: #d68910; }
    .btn-checkout { display: inline-block; padding: 14px 36px; background: #ff9900; color: #fff; font-size: 16px; font-weight: 700; border-radius: 8px; text-decoration: none; }
    .btn-clear   { background: none; border: 1px solid #ddd; color: #888; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-size: 13px; }
  </style>
</head>
<body>

  <!-- Мини-шапка -->
  <header style="background:#1a1a1a;padding:14px 0;">
    <div style="max-width:1200px;margin:0 auto;padding:0 20px;display:flex;align-items:center;justify-content:space-between;">
      <a href="index.php"><img src="images/5kvt-brand-logo.png" alt="5КВТ" style="height:36px;"></a>
      <nav style="display:flex;gap:20px;align-items:center;">
        <a href="index.php#catalog" style="color:#fff;text-decoration:none;font-size:14px;">← Продолжить покупки</a>
        <?php if (!empty($_SESSION['user_id'])): ?>
          <a href="profile.php" style="color:#ff9900;text-decoration:none;font-size:14px;">
            👤 <?= htmlspecialchars($_SESSION['user_name']) ?>
          </a>
          <a href="logout.php" style="color:#aaa;text-decoration:none;font-size:13px;">Выйти</a>
        <?php else: ?>
          <a href="auth.php" style="color:#ff9900;text-decoration:none;font-size:14px;">Войти</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <div class="cart-wrap">
    <h1 style="font-size:24px;font-weight:700;margin-bottom:24px;">
      Корзина
      <?php if ($cartCount > 0): ?>
        <span style="font-size:16px;font-weight:400;color:#888;">(<?= $cartCount ?> шт.)</span>
      <?php endif; ?>
    </h1>

    <div class="cart-box">
      <?php if (empty($_SESSION['cart'])): ?>
        <!-- Пустая корзина -->
        <div style="text-align:center;padding:50px 0;">
          <div style="font-size:64px;">🛒</div>
          <p style="font-size:18px;color:#888;margin:16px 0;">Ваша корзина пуста.</p>
          <a href="index.php#catalog" class="btn-checkout">Перейти в каталог</a>
        </div>

      <?php else: ?>
        <!-- Таблица товаров -->
        <table>
          <thead>
            <tr>
              <th style="width:60px;"></th>
              <th>Товар</th>
              <th>Цена</th>
              <th style="width:130px;">Количество</th>
              <th>Сумма</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($_SESSION['cart'] as $pid => $qty): ?>
              <?php $p = $cartProducts[$pid] ?? null; if (!$p) continue; ?>
              <tr>
                <td>
                  <img src="<?= htmlspecialchars($p['image']) ?>" alt=""
                       style="width:52px;height:52px;object-fit:contain;border-radius:4px;">
                </td>
                <td>
                  <strong style="font-size:14px;"><?= htmlspecialchars($p['name']) ?></strong><br>
                  <span style="font-size:12px;color:#aaa;"><?= htmlspecialchars($p['brand']) ?></span>
                </td>
                <td style="white-space:nowrap;">
                  <?= number_format($p['price'], 0, '.', ' ') ?> ₽
                </td>
                <td>
                  <form method="POST" action="cart.php" style="display:inline-flex;gap:4px;align-items:center;">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="pid"    value="<?= $pid ?>">
                    <input type="number" name="qty" value="<?= $qty ?>" min="0" max="99" class="qty-input">
                    <button type="submit" class="btn-sm btn-update">✓</button>
                  </form>
                </td>
                <td style="font-weight:700;white-space:nowrap;">
                  <?= number_format($p['price'] * $qty, 0, '.', ' ') ?> ₽
                </td>
                <td>
                  <form method="POST" action="cart.php">
                    <input type="hidden" name="action" value="remove">
                    <input type="hidden" name="pid"    value="<?= $pid ?>">
                    <button type="submit" class="btn-sm btn-remove">✕</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <!-- Итог -->
        <div style="margin-top:28px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;">
          <form method="POST" action="cart.php">
            <input type="hidden" name="action" value="clear">
            <button type="submit" class="btn-clear">🗑 Очистить корзину</button>
          </form>

          <div style="text-align:right;">
            <p style="font-size:20px;font-weight:700;margin:0 0 14px;">
              Итого: <span style="color:#ff9900;"><?= number_format($total, 0, '.', ' ') ?> ₽</span>
            </p>
            <a href="checkout.php" class="btn-checkout">Оформить заказ →</a>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>

</body>
</html>
