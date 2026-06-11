<?php
session_start();

// Инициализация счётчика
if (!isset($_SESSION['page_views'])) {
    $_SESSION['page_views'] = 0;
}
$_SESSION['page_views']++;

// Cookie "last_visit"
if (!isset($_COOKIE['last_visit'])) {
    setcookie('last_visit', date('Y-m-d H:i:s'), time() + 86400 * 30);
    $lastVisit = 'первый раз';
} else {
    $lastVisit = $_COOKIE['last_visit'];
    setcookie('last_visit', date('Y-m-d H:i:s'), time() + 86400 * 30);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Счётчик посещений</title>
</head>
<body>

<h3>Вы открыли эту страницу <?= $_SESSION['page_views'] ?> раз(а)</h3>
<p>Предыдущий визит: <?= htmlspecialchars($lastVisit) ?></p>

<a href="task1.php">Обновить</a><br><br>
<a href="index.php">Назад</a>

</body>
</html>
