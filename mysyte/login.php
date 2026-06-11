<!DOCTYPE html>
<html>
<head>
    <title>Авторизация</title>
</head>
<body>
<?php
if (!empty($_GET["email"]) && !empty($_GET["password"])) {
    echo "<h3>Авторизация (GET):</h3>";
    echo "<p>Логин: " . htmlspecialchars($_GET["email"]) . "</p>";
    echo "<p>Пароль: " . htmlspecialchars($_GET["password"]) . "</p>";
}
?>
<h2>Авторизация</h2>
<form method="GET" autocomplete="off">
    <input type="text" style="display:none">
    <input type="password" style="display:none">
    <label>Email:</label><br>
    <input type="email" name="email" autocomplete="new-email" required><br><br>
    <label>Пароль:</label><br>
    <input type="password" name="password" autocomplete="new-password" required><br><br>
    <button type="submit">Войти</button>
</form>
</body>
</html>
