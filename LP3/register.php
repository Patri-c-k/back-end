<?php
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (!$name || !$email || !$password || !$confirm) {
        $errors[] = "Все поля обязательны";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Неверный email";
    }

    if (strlen($password) < 6) {
        $errors[] = "Пароль минимум 6 символов";
    }

    if ($password !== $confirm) {
        $errors[] = "Пароли не совпадают";
    }

    if (empty($errors)) {
    echo "Регистрация успешна!<br>";
    echo "Имя: " . htmlspecialchars($name) . "<br>";
    echo "Email: " . htmlspecialchars($email) . "<br>";
    echo "Пароли подтверждены";
    echo $password;
}
}
?>

<?php if (!empty($errors)): ?>
<ul>
    <?php foreach ($errors as $e) echo "<li>$e</li>"; ?>
</ul>
<?php endif; ?>

<form method="POST">
    Имя: <input type="text" name="name"><br>
    Email: <input type="email" name="email"><br>
    Пароль: <input type="password" name="password"><br>
    Подтверждение: <input type="password" name="confirm_password"><br>
    <button type="submit">Регистрация</button>
</form>