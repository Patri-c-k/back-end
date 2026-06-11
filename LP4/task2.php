<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    if ($name !== '') {
        setcookie('user_name', $name, time() + 86400 * 30);
        header('Location: task2.php');
        exit;
    }
}

$userName = $_COOKIE['user_name'] ?? null;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Работа с cookies</title>
</head>
<body>

<h2>Задание 2 — Работа с cookies</h2>

<?php if ($userName): ?>
    <p>Привет, <?= htmlspecialchars($userName) ?>! Cookie уже установлена.</p>
<?php else: ?>
    <p>Cookie с именем пользователя ещё не установлена.</p>
<?php endif; ?>

<form method="post">
    <input type="text" name="name" placeholder="Введите имя" required>
    <button type="submit">Сохранить</button>
</form>

<br><a href="index.php">Назад</a>

</body>
</html>
