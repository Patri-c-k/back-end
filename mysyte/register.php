<!DOCTYPE html>
<html>
<head>
    <title>Регистрация</title>
</head>
<body>

<?php
if (!empty($_POST["reg_email"]) && !empty($_POST["reg_password"])) {
    echo "<h3>Регистрация (POST):</h3>";
    echo "<p>Email: " . htmlspecialchars($_POST["reg_email"]) . "</p>";
    echo "<p>Пароль: " . htmlspecialchars($_POST["reg_password"]) . "</p>";
    echo "<p>Повтор пароля: " . htmlspecialchars($_POST["reg_password2"]) . "</p>";
}
?>

<h2>Регистрация</h2>
<form method="POST" autocomplete="off">

    <input type="text" style="display:none">
    <input type="password" style="display:none">

    <label>Имя пользователя:</label><br>
    <input type="text" name="username" autocomplete="new-username" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="reg_email" autocomplete="new-email" required><br><br>

    <label>Пароль:</label><br>
    <input type="password" name="reg_password" autocomplete="new-password" required><br><br>

    <label>Повторите пароль:</label><br>
    <input type="password" name="reg_password2" autocomplete="new-password" required><br><br>

    <button type="submit">Зарегистрироваться</button>
</form>

</body>
</html>
