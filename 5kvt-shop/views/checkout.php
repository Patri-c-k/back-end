<?php
// ============================================================
// checkout.php — Оформление заказа (Пункт 4 чек-листа)
// ============================================================
session_start();
require_once 'models/ProductModel.php';
require_once 'models/OrderModel.php';

// Пустая корзина — назад
if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

$cartProducts = ProductModel::getByIds(array_keys($_SESSION['cart']));
$total = 0;
foreach ($_SESSION['cart'] as $pid => $qty) {
    if (isset($cartProducts[$pid])) {
        $total += $cartProducts[$pid]['price'] * $qty;
    }
}

$errors  = [];
$success = false;
$orderId = null;

// ---- Пред-заполнение из профиля ----
$prefill = [
    'name'    => '',
    'email'   => '',
    'phone'   => '',
    'address' => '',
    'comment' => '',
];
if (!empty($_SESSION['user_id'])) {
    require_once 'models/UserModel.php';
    $user = UserModel::getById((int) $_SESSION['user_id']);
    if ($user) {
        $prefill['name']  = $user['name'];
        $prefill['email'] = $user['email'];
        $prefill['phone'] = $user['phone'] ?? '';
    }
}

// ---- Обработка формы ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name']    ?? '');
    $email   = trim($_POST['email']   ?? '');
    $phone   = trim($_POST['phone']   ?? '');
    $address = trim($_POST['address'] ?? '');
    $comment = trim($_POST['comment'] ?? '');

    if (!$name)    $errors[] = 'Введите имя.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Введите корректный e-mail.';
    if (!$phone)   $errors[] = 'Введите телефон.';
    if (!$address) $errors[] = 'Введите адрес доставки.';

    if (empty($errors)) {
        $orderId = OrderModel::create(
            [
                'user_id' => $_SESSION['user_id'] ?? null,
                'name'    => $name,
                'email'   => $email,
                'phone'   => $phone,
                'address' => $address,
                'comment' => $comment,
            ],
            $_SESSION['cart'],
            $cartProducts
        );

        // Очищаем корзину после успешного заказа
        unset($_SESSION['cart']);
        $success = true;
    } else {
        $prefill = compact('name','email','phone','address','comment');
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Оформление заказа — 5КВТ</title>
  <link rel="stylesheet" href="style(1).css">
  <style>
    body { background: #f4f6f8; font-family: 'Lato', sans-serif; }
    .co-wrap { max-width: 860px; margin: 40px auto; padding: 0 15px; display: grid; grid-template-columns: 1fr 340px; gap: 24px; }
    @media(max-width:700px){ .co-wrap{ grid-template-columns:1fr; } }
    .co-box { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.08); padding: 28px 30px; }
    .co-box h2 { font-size: 18px; font-weight: 700; margin: 0 0 22px; padding-bottom: 12px; border-bottom: 1px solid #f0f0f0; }
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: #555; margin-bottom: 5px; }
    .form-group input,
    .form-group textarea { width: 100%; box-sizing: border-box; padding: 11px 13px; border: 1px solid #ddd; border-radius: 7px; font-size: 14px; font-family: inherit; }
    .form-group input:focus,
    .form-group textarea:focus { outline: none; border-color: #ff9900; }
    .form-group textarea { resize: vertical; min-height: 80px; }
    .btn-place { width: 100%; padding: 14px; background: #ff9900; color: #fff; font-size: 16px; font-weight: 700; border: none; border-radius: 8px; cursor: pointer; }
    .btn-place:hover { background: #e08800; }
    .error-box  { background: #fff3f3; border: 1px solid #f5c6cb; color: #721c24; padding: 10px 14px; border-radius: 6px; margin-bottom: 16px; font-size: 13px; }
    .order-item { display: flex; gap: 10px; align-items: center; padding: 8px 0; border-bottom: 1px solid #f5f5f5; font-size: 13px; }
    .order-item img { width: 44px; height: 44px; object-fit: contain; flex-shrink: 0; }
    .success-wrap { max-width: 520px; margin: 80px auto; padding: 0 15px; text-align: center; }
    .success-icon { font-size: 72px; }
    .success-box-big { background:#fff; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,.08); padding:40px; }
  </style>
</head>
<body>

  <!-- Шапка -->
  <header style="background:#1a1a1a;padding:14px 0;">
    <div style="max-width:1200px;margin:0 auto;padding:0 20px;display:flex;align-items:center;justify-content:space-between;">
      <a href="index.php"><img src="images/5kvt-brand-logo.png" alt="5КВТ" style="height:36px;"></a>
      <nav style="display:flex;gap:20px;align-items:center;">
        <a href="cart.php" style="color:#fff;text-decoration:none;font-size:14px;">← Корзина</a>
        <?php if (!empty($_SESSION['user_id'])): ?>
          <a href="profile.php" style="color:#ff9900;text-decoration:none;font-size:14px;">
            👤 <?= htmlspecialchars($_SESSION['user_name']) ?>
          </a>
        <?php else: ?>
          <a href="auth.php" style="color:#ff9900;text-decoration:none;font-size:14px;">Войти</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <?php if ($success): ?>
  <!-- ===== УСПЕШНО ОФОРМЛЕН ===== -->
  <div class="success-wrap">
    <div class="success-box-big">
      <div class="success-icon">✅</div>
      <h1 style="font-size:22px;font-weight:700;margin:20px 0 10px;">Заказ №<?= $orderId ?> оформлен!</h1>
      <p style="color:#666;font-size:15px;margin-bottom:28px;">
        Мы свяжемся с вами для подтверждения. Спасибо за покупку!
      </p>
      <a href="index.php" style="display:inline-block;padding:12px 30px;background:#ff9900;color:#fff;border-radius:7px;text-decoration:none;font-weight:700;">
        Вернуться в каталог
      </a>
      <?php if (!empty($_SESSION['user_id'])): ?>
        <br><a href="profile.php" style="display:inline-block;margin-top:12px;color:#888;font-size:13px;text-decoration:none;">
          История заказов →
        </a>
      <?php endif; ?>
    </div>
  </div>

  <?php else: ?>
  <!-- ===== ФОРМА ОФОРМЛЕНИЯ ===== -->
  <div style="max-width:860px;margin:32px auto;padding:0 15px;">
    <h1 style="font-size:22px;font-weight:700;margin-bottom:24px;">Оформление заказа</h1>
  </div>

  <div class="co-wrap">

    <!-- ЛЕВАЯ КОЛОНКА: форма -->
    <div class="co-box">
      <h2>Контактные данные и доставка</h2>

      <?php if (!empty($errors)): ?>
        <div class="error-box"><?= implode('<br>', array_map('htmlspecialchars', $errors)) ?></div>
      <?php endif; ?>

      <form method="POST" action="checkout.php">
        <div class="form-group">
          <label>Ваше имя *</label>
          <input type="text" name="name" required
                 value="<?= htmlspecialchars($prefill['name']) ?>"
                 placeholder="Иван Иванов">
        </div>
        <div class="form-group">
          <label>E-mail *</label>
          <input type="email" name="email" required
                 value="<?= htmlspecialchars($prefill['email']) ?>"
                 placeholder="example@mail.ru">
        </div>
        <div class="form-group">
          <label>Телефон *</label>
          <input type="tel" name="phone" required
                 value="<?= htmlspecialchars($prefill['phone']) ?>"
                 placeholder="+7 (999) 000-00-00">
        </div>
        <div class="form-group">
          <label>Адрес доставки *</label>
          <input type="text" name="address" required
                 value="<?= htmlspecialchars($prefill['address']) ?>"
                 placeholder="г. Москва, ул. Ленина, д. 1, кв. 1">
        </div>
        <div class="form-group">
          <label>Комментарий к заказу</label>
          <textarea name="comment" placeholder="Удобное время доставки, особые пожелания..."><?= htmlspecialchars($prefill['comment']) ?></textarea>
        </div>

        <!-- Способ оплаты (для демонстрации) -->
        <div class="form-group">
          <label>Способ оплаты</label>
          <select style="width:100%;padding:11px 13px;border:1px solid #ddd;border-radius:7px;font-size:14px;font-family:inherit;">
            <option>Оплата при получении</option>
            <option>Банковская карта онлайн</option>
            <option>Перевод на карту</option>
          </select>
        </div>

        <button type="submit" class="btn-place">Подтвердить заказ</button>
      </form>
    </div>

    <!-- ПРАВАЯ КОЛОНКА: состав заказа -->
    <div>
      <div class="co-box" style="position:sticky;top:20px;">
        <h2>Ваш заказ</h2>

        <?php foreach ($_SESSION['cart'] as $pid => $qty): ?>
          <?php $p = $cartProducts[$pid] ?? null; if (!$p) continue; ?>
          <div class="order-item">
            <img src="<?= htmlspecialchars($p['image']) ?>" alt="">
            <div style="flex:1;">
              <div style="font-weight:600;"><?= htmlspecialchars($p['name']) ?></div>
              <div style="color:#999;"><?= $qty ?> шт. × <?= number_format($p['price'], 0, '.', ' ') ?> ₽</div>
            </div>
            <div style="font-weight:700;white-space:nowrap;">
              <?= number_format($p['price'] * $qty, 0, '.', ' ') ?> ₽
            </div>
          </div>
        <?php endforeach; ?>

        <div style="margin-top:18px;padding-top:14px;border-top:2px solid #f0f0f0;
                    display:flex;justify-content:space-between;align-items:center;">
          <span style="font-size:15px;font-weight:600;">Итого:</span>
          <span style="font-size:20px;font-weight:700;color:#ff9900;">
            <?= number_format($total, 0, '.', ' ') ?> ₽
          </span>
        </div>

        <div style="margin-top:14px;font-size:12px;color:#aaa;">
          🚚 Доставка рассчитывается менеджером при подтверждении заказа.
        </div>
      </div>
    </div>

  </div>
  <?php endif; ?>

</body>
</html>
