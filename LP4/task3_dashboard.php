<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: task3_login.php');
    exit;
}

$timeout = 900;

if (time() - ($_SESSION['logged_at'] ?? 0) > $timeout) {
    $_SESSION = [];
    session_destroy();
    header('Location: task3_login.php?expired=1');
    exit;
}

$_SESSION['logged_at'] = time();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель</title>
</head>
<body>

<h1>Добро пожаловать, <?= htmlspecialchars($_SESSION['user']) ?></h1>
<p>Роль: <?= htmlspecialchars($_SESSION['role']) ?></p>

<a href="task3_logout.php">Выйти</a><br><br>
<a href="index.php">Назад</a>

</body>
</html>
