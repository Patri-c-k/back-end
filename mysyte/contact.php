<!DOCTYPE html>
<html>
<head>
    <title>Напиши мне</title>
</head>
<body>
<?php
if (!empty($_POST["contact_name"]) || !empty($_POST["contact_email"]) || !empty($_POST["contact_message"])) {

    echo "<h3>Сообщение из формы 'Напиши мне':</h3>";

    echo "<p>Имя: " . htmlspecialchars($_POST["contact_name"]) . "</p>";
    echo "<p>Email: " . htmlspecialchars($_POST["contact_email"]) . "</p>";
    echo "<p>Тема: " . htmlspecialchars($_POST["contact_topic"]) . "</p>";
    echo "<p>Срочно: " . (isset($_POST["urgent"]) ? htmlspecialchars($_POST["urgent"]) : "Нет") . "</p>";

    if (!empty($_POST["need"])) {
        echo "<p>Что нужно: " . implode(", ", array_map("htmlspecialchars", $_POST["need"])) . "</p>";
    } else {
        echo "<p>Что нужно: ничего не выбрано</p>";
    }

    echo "<p>Сообщение: " . nl2br(htmlspecialchars($_POST["contact_message"])) . "</p>";
}
?>
<h2>Напиши мне</h2>
<form method="POST" autocomplete="off">

    <label>Имя:</label><br>
    <input type="text" name="contact_name"><br><br>

    <label>Email:</label><br>
    <input type="email" name="contact_email"><br><br>

    <label>Тема:</label><br>
    <select name="contact_topic">
        <option value="Вопрос">Вопрос</option>
        <option value="Предложение">Предложение</option>
    </select><br><br>

    <label>Срочно?</label><br>
    <input type="radio" name="urgent" value="Да"> Да<br>
    <input type="radio" name="urgent" value="Нет"> Нет<br><br>

    <label>Что нужно:</label><br>
    <input type="checkbox" name="need[]" value="Сайт"> Сайт<br>
    <input type="checkbox" name="need[]" value="Помощь"> Помощь<br><br>

    <label>Сообщение:</label><br>
    <textarea rows="3" cols="30" name="contact_message"></textarea><br><br>

    <button type="submit">Отправить</button>
</form>

</body>
</html>
