<?php
session_start();

if (isset($_SESSION['user'])) {
    header('Location: task3_dashboard.php');
    exit;
}

$error = '';
$expired = isset($_GET['expired']) ? 'Сессия истекла. Войдите снова.' : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $pass  = $_POST['password'] ?? '';

    $validLogin = 'admin';
    $validPassword = '12345';
    $validHash = password_hash($validPassword, PASSWORD_DEFAULT);

    if ($login === $validLogin && password_verify($pass, $validHash)) {
        session_regenerate_id(true);
        $_SESSION['user'] = $login;
        $_SESSION['role'] = 'admin';
        $_SESSION['logged_at'] = time();
        header('Location: task3_dashboard.php');
        exit;
    } else {
        $error = 'Неверный логин или пароль';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
</head>
<body>

<h2>Задание 3 — Авторизация</h2>

<?php if ($expired): ?>
    <p style="color:orange"><?= $expired ?></p>
<?php endif; ?>

<?php if ($error): ?>
    <p style="color:red"><?= $error ?></p>
<?php endif; ?>

<form method="post">
    <input type="text" name="login" placeholder="Логин" required><br><br>
    <input type="password" name="password" placeholder="Пароль" required><br><br>
    <button type="submit">Войти</button>
</form>

<br><a href="index.php">Назад</a>

</body>
</html>
