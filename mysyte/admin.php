<?php
session_start();
// ДЕЙСТВИЕ: выход из системы
if (isset($_GET["logout"])) {
    session_unset();
    session_destroy();
    header("Location: admin.php");
    exit;
}
// Если пользователь уже авторизован — показываем админку
if (isset($_SESSION["admin"])) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Админ панель</title>
    </head>
    <body>
        <h1>Админ панель</h1>
        <p>Добро пожаловать, <?php echo htmlspecialchars($_SESSION["email"]); ?>!</p>
        <a href="admin.php?logout=1">Выйти</a>
    </body>
    </html>
    <?php
    exit;
}
// Если отправлена форма — проверяем логин/пароль
if (!empty($_POST["email"]) && !empty($_POST["password"])) {
    // Данные "админа"
    $correctEmail = "patrick@example.com";
    $correctPass = "12345";
    if ($_POST["email"] === $correctEmail && $_POST["password"] === $correctPass) {
        // Создаём сессию
        $_SESSION["admin"] = true;
        $_SESSION["email"] = $_POST["email"];
        // Перезагружаем страницу, чтобы показать админку
        header("Location: admin.php");
        exit;
    } else {
        $error = "Неверный логин или пароль";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Авторизация</title>
</head>
<body>
<h2>Авторизация</h2>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST" autocomplete="off">
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
