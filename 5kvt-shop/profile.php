<?php
// ============================================================
// profile.php — Личный кабинет
// ============================================================
session_start();

if (empty($_SESSION['user_id'])) {
    header('Location: auth.php');
    exit;
}

require_once 'models/UserModel.php';
require_once 'models/OrderModel.php';

$user   = UserModel::getById((int) $_SESSION['user_id']);
$orders = OrderModel::getByUser((int) $_SESSION['user_id']);

$statusLabels = [
    'new'        => ['label' => 'Новый',      'color' => '#007bff'],
    'processing' => ['label' => 'В работе',   'color' => '#fd7e14'],
    'shipped'    => ['label' => 'Отправлен',  'color' => '#6f42c1'],
    'completed'  => ['label' => 'Выполнен',   'color' => '#28a745'],
    'cancelled'  => ['label' => 'Отменён',    'color' => '#dc3545'],
];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Личный кабинет — 5КВТ</title>
  <link rel="stylesheet" href="style(1).css">
  <style>
    body { background: #f4f6f8; font-family: 'Lato', sans-serif; }
    .profile-wrap { max-width: 880px; margin: 40px auto; padding: 0 15px; }
    .box { background: #fff; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,.07); padding: 28px 30px; margin-bottom: 22px; }
    .box h2 { font-size: 17px; font-weight: 700; margin: 0 0 18px; padding-bottom: 12px; border-bottom: 1px solid #f0f0f0; }
    .info-row { display: flex; gap: 6px; font-size: 14px; margin-bottom: 8px; }
    .info-row span:first-child { color: #888; width: 100px; flex-shrink: 0; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 10px 8px; text-align: left; font-size: 13px; }
    th { color: #888; font-size: 12px; border-bottom: 2px solid #eee; font-weight: 600; }
    tr + tr td { border-top: 1px solid #f5f5f5; }
    .badge { display: inline-block; padding: 3px 9px; border-radius: 12px; font-size: 11px; font-weight: 700; color: #fff; }
    .detail-btn { background: none; border: 1px solid #ddd; border-radius: 5px; padding: 5px 12px; font-size: 12px; cursor: pointer; color: #555; }
    .detail-row { background: #fafafa; }
    .detail-inner { padding: 10px 16px; font-size: 13px; color: #555; }
    .detail-inner table th { color: #aaa; }
  </style>
</head>
<body>

  <header style="background:#1a1a1a;padding:14px 0;">
    <div style="max-width:1200px;margin:0 auto;padding:0 20px;display:flex;align-items:center;justify-content:space-between;">
      <a href="index.php"><img src="images/5kvt-brand-logo.png" alt="5КВТ" style="height:36px;"></a>
      <nav style="display:flex;gap:20px;align-items:center;">
        <a href="index.php#catalog" style="color:#fff;text-decoration:none;font-size:14px;">Каталог</a>
        <a href="cart.php" style="color:#fff;text-decoration:none;font-size:14px;">
          🛒 Корзина
          <?php if (!empty($_SESSION['cart'])): ?>
            <span style="background:#ff9900;color:#fff;border-radius:50%;padding:2px 6px;font-size:11px;">
              <?= array_sum($_SESSION['cart']) ?>
            </span>
          <?php endif; ?>
        </a>
        <a href="logout.php" style="color:#aaa;text-decoration:none;font-size:13px;">Выйти</a>
      </nav>
    </div>
  </header>

  <div class="profile-wrap">
    <h1 style="font-size:22px;font-weight:700;margin-bottom:22px;">Личный кабинет</h1>

    <!-- Данные пользователя -->
    <div class="box">
      <h2>👤 Мои данные</h2>
      <div class="info-row"><span>Имя:</span>      <strong><?= htmlspecialchars($user['name']) ?></strong></div>
      <div class="info-row"><span>E-mail:</span>   <?= htmlspecialchars($user['email']) ?></div>
      <div class="info-row"><span>Телефон:</span>  <?= htmlspecialchars($user['phone'] ?? '—') ?></div>
      <div class="info-row"><span>Роль:</span>     <?= $user['role'] === 'admin' ? '🔑 Администратор' : 'Покупатель' ?></div>
      <div class="info-row"><span>С нами с:</span> <?= date('d.m.Y', strtotime($user['created_at'])) ?></div>
    </div>

    <!-- История заказов -->
    <div class="box">
      <h2>📦 История заказов</h2>

      <?php if (empty($orders)): ?>
        <p style="color:#aaa;font-size:14px;">У вас пока нет заказов.
          <a href="index.php#catalog" style="color:#ff9900;">Перейти в каталог →</a>
        </p>
      <?php else: ?>
        <table>
          <thead>
            <tr>
              <th>№</th>
              <th>Дата</th>
              <th>Сумма</th>
              <th>Статус</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orders as $order): ?>
              <tr>
                <td><strong>#<?= $order['id'] ?></strong></td>
                <td><?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></td>
                <td style="font-weight:700;"><?= number_format($order['total_amount'], 0, '.', ' ') ?> ₽</td>
                <td>
                  <?php $s = $statusLabels[$order['status']] ?? ['label'=>$order['status'],'color'=>'#888']; ?>
                  <span class="badge" style="background:<?= $s['color'] ?>;"><?= $s['label'] ?></span>
                </td>
                <td>
                  <button class="detail-btn" onclick="toggleDetail(<?= $order['id'] ?>)">Детали</button>
                </td>
              </tr>
              <!-- Раскрывающийся блок деталей -->
              <tr class="detail-row" id="detail-<?= $order['id'] ?>" style="display:none;">
                <td colspan="5">
                  <div class="detail-inner">
                    <?php $items = OrderModel::getItems($order['id']); ?>
                    <?php if (!empty($items)): ?>
                      <table style="margin-bottom:8px;">
                        <thead>
                          <tr><th>Товар</th><th>Цена</th><th>Кол-во</th><th>Сумма</th></tr>
                        </thead>
                        <tbody>
                          <?php foreach ($items as $item): ?>
                            <tr>
                              <td><?= htmlspecialchars($item['product_name']) ?></td>
                              <td><?= number_format($item['price'], 0, '.', ' ') ?> ₽</td>
                              <td><?= $item['quantity'] ?></td>
                              <td><?= number_format($item['price'] * $item['quantity'], 0, '.', ' ') ?> ₽</td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    <?php endif; ?>
                    <p style="margin:4px 0;"><strong>Адрес:</strong> <?= htmlspecialchars($order['address']) ?></p>
                    <?php if ($order['comment']): ?>
                      <p style="margin:4px 0;"><strong>Комментарий:</strong> <?= htmlspecialchars($order['comment']) ?></p>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>

    <a href="logout.php"
       style="display:inline-block;padding:10px 24px;border:1px solid #ddd;color:#888;
              border-radius:7px;text-decoration:none;font-size:14px;">
      Выйти из аккаунта
    </a>
  </div>

  <script>
    function toggleDetail(id) {
      const row = document.getElementById('detail-' + id);
      row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
    }
  </script>
</body>
</html>
