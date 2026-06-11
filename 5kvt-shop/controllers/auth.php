<?php
// ============================================================
// auth.php — Страница авторизации и регистрации
// ============================================================
session_start();

// Уже вошёл — на главную
if (!empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require_once 'models/UserModel.php';

$mode   = $_GET['mode'] ?? 'login';   // 'login' или 'register'
$errors = [];
$success = '';

// ---- Обработка ВХОДА ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!$email || !$password) {
        $errors[] = 'Введите e-mail и пароль.';
    } else {
        $user = UserModel::login($email, $password);
        if ($user) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            // Восстанавливаем корзину пользователя из БД
            require_once 'config/db.php';
            $db = DB::getConnection();
            $stmt = $db->prepare("SELECT cart FROM user_carts WHERE user_id = ?");
            $stmt->execute([$user['id']]);
            $row = $stmt->fetch();
            if ($row) {
                $_SESSION['cart'] = json_decode($row['cart'], true) ?? [];
            } else {
                $_SESSION['cart'] = [];
            }
            header('Location: index.php');
            exit;
        } else {
            $errors[] = 'Неверный e-mail или пароль.';
        }
    }
    $mode = 'login';
}

// ---- Обработка РЕГИСТРАЦИИ ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    $name     = trim($_POST['name']     ?? '');
    $email    = trim($_POST['email']    ?? '');
    $phone    = trim($_POST['phone']    ?? '');
    $password = trim($_POST['password'] ?? '');
    $password2= trim($_POST['password2']?? '');

    if (!$name)             $errors[] = 'Введите имя.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Некорректный e-mail.';
    if (strlen($password) < 6) $errors[] = 'Пароль должен быть не менее 6 символов.';
    if ($password !== $password2) $errors[] = 'Пароли не совпадают.';

    if (empty($errors)) {
        $result = UserModel::register($name, $email, $phone, $password);
        if ($result['ok']) {
            $success = 'Регистрация прошла успешно! Теперь войдите в аккаунт.';
            $mode    = 'login';
        } else {
            $errors[] = $result['error'];
        }
    }
    if (!$success) $mode = 'register';
}

$pageTitle = $mode === 'login' ? 'Вход в аккаунт' : 'Регистрация';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $pageTitle ?> — 5КВТ</title>
  <link rel="stylesheet" href="style(1).css">
  <style>
    body { background: #f4f6f8; font-family: 'Lato', sans-serif; }
    .auth-wrap { max-width: 460px; margin: 60px auto; padding: 0 15px; }
    .auth-box { background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,.1); padding: 36px 40px; }
    .auth-box h1 { font-size: 22px; font-weight: 700; margin: 0 0 24px; text-align: center; }
    .auth-tabs { display: flex; margin-bottom: 28px; border-bottom: 2px solid #eee; }
    .auth-tab { flex: 1; text-align: center; padding: 10px; text-decoration: none; color: #888; font-weight: 600; font-size: 15px; }
    .auth-tab.active { color: #ff9900; border-bottom: 2px solid #ff9900; margin-bottom: -2px; }
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 13px; color: #555; margin-bottom: 5px; font-weight: 600; }
    .form-group input { width: 100%; box-sizing: border-box; padding: 11px 14px; border: 1px solid #ddd; border-radius: 7px; font-size: 14px; font-family: inherit; transition: border-color .2s; }
    .form-group input:focus { outline: none; border-color: #ff9900; }
    .btn-auth { width: 100%; padding: 13px; background: #ff9900; color: #fff; font-size: 15px; font-weight: 700; border: none; border-radius: 7px; cursor: pointer; margin-top: 8px; }
    .btn-auth:hover { background: #e08800; }
    .error-box { background: #fff3f3; border: 1px solid #f5c6cb; color: #721c24; padding: 10px 14px; border-radius: 6px; margin-bottom: 16px; font-size: 13px; }
    .success-box { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 10px 14px; border-radius: 6px; margin-bottom: 16px; font-size: 13px; }
    .back-link { display: block; text-align: center; margin-top: 18px; color: #888; font-size: 13px; text-decoration: none; }
    .back-link:hover { color: #ff9900; }
  </style>
</head>
<body>
  <header style="background:#1a1a1a;padding:14px 0;">
    <div style="max-width:1200px;margin:0 auto;padding:0 20px;display:flex;align-items:center;justify-content:space-between;">
      <a href="index.php">
        <img src="images/5kvt-brand-logo.png" alt="5КВТ" style="height:36px;">
      </a>
      <a href="index.php" style="color:#fff;text-decoration:none;font-size:14px;">← На главную</a>
    </div>
  </header>

  <div class="auth-wrap">
    <div class="auth-box">
      <!-- Табы -->
      <div class="auth-tabs">
        <a href="auth.php?mode=login"    class="auth-tab <?= $mode==='login'    ? 'active':'' ?>">Вход</a>
        <a href="auth.php?mode=register" class="auth-tab <?= $mode==='register' ? 'active':'' ?>">Регистрация</a>
      </div>

      <!-- Сообщения -->
      <?php if (!empty($errors)): ?>
        <div class="error-box"><?= implode('<br>', array_map('htmlspecialchars', $errors)) ?></div>
      <?php endif; ?>
      <?php if ($success): ?>
        <div class="success-box"><?= htmlspecialchars($success) ?></div>
      <?php endif; ?>

      <!-- ===== ФОРМА ВХОДА ===== -->
      <?php if ($mode === 'login'): ?>
        <form method="POST" action="auth.php">
          <input type="hidden" name="action" value="login">
          <div class="form-group">
            <label>E-mail</label>
            <input type="email" name="email" required placeholder="example@mail.ru"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
          </div>
          <div class="form-group">
            <label>Пароль</label>
            <input type="password" name="password" required placeholder="Введите пароль">
          </div>
          <button type="submit" class="btn-auth">Войти</button>
        </form>
        <p style="text-align:center;font-size:12px;color:#aaa;margin-top:16px;">
          Тест: test@test.ru / 123456
        </p>

      <!-- ===== ФОРМА РЕГИСТРАЦИИ ===== -->
      <?php else: ?>
        <form method="POST" action="auth.php?mode=register">
          <input type="hidden" name="action" value="register">
          <div class="form-group">
            <label>Ваше имя</label>
            <input type="text" name="name" required placeholder="Иван Иванов"
                   value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
          </div>
          <div class="form-group">
            <label>E-mail</label>
            <input type="email" name="email" required placeholder="example@mail.ru"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
          </div>
          <div class="form-group">
            <label>Телефон</label>
            <input type="tel" name="phone" placeholder="+7 (999) 000-00-00"
                   value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
          </div>
          <div class="form-group">
            <label>Пароль <span style="color:#aaa;font-weight:400;">(мин. 6 символов)</span></label>
            <input type="password" name="password" required placeholder="Придумайте пароль">
          </div>
          <div class="form-group">
            <label>Повторите пароль</label>
            <input type="password" name="password2" required placeholder="Повторите пароль">
          </div>
          <button type="submit" class="btn-auth">Зарегистрироваться</button>
        </form>
      <?php endif; ?>

      <a href="index.php" class="back-link">← Продолжить без входа</a>
    </div>
  </div>
</body>
</html>
