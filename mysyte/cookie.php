<?php
$dataFile = "guestbook.txt";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['message'])) {
    $name = trim(strip_tags($_POST['name']));
    $message = trim(strip_tags($_POST['message']));
    
    if ($name && $message) {
        $time = date("Y-m-d H:i:s"); // время отправки
        $fp = fopen($dataFile, 'a');
        flock($fp, LOCK_EX);
        fwrite($fp, "<b>$name</b> <small>[$time]</small><br>$message<hr>\n");
        flock($fp, LOCK_UN);
        fclose($fp);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Гостевая книга</title>
</head>
<body>
    <h1>Гостевая книга</h1>
    
    <form method="POST">
        <input type="text" name="name" placeholder="Ваше имя" required><br>
        <textarea name="message" rows="4" placeholder="Ваше сообщение" required></textarea><br>
        <button type="submit">Отправить</button>
    </form>

    <h2>Сообщения:</h2>
    <?php
    if (file_exists($dataFile)) {
        echo file_get_contents($dataFile);
    } else {
        echo "Пока нет сообщений";
    }
    ?>
</body>
</html>