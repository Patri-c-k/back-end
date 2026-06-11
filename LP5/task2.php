<?php
$filename = "messages.txt";

// Обработка отправки формы должна быть ДО вывода HTML, чтобы работал header() редирект
if (isset($_POST['submit'])) {
    $username = htmlspecialchars(trim($_POST['username']));
    $message = htmlspecialchars(trim($_POST['message']));
    $date = date("Y-m-d H:i:s");

    if (!empty($username) && !empty($message)) {
        $logLine = $date . "|||" . $username . "|||" . $message . "\n";
        $file = fopen($filename, "a");
        if ($file) {
            if (flock($file, LOCK_EX)) {
                fwrite($file, $logLine);
                flock($file, LOCK_UN);
            }
            fclose($file);
        }
        header("Location: task2.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Задание №2 - Гостевая книга</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .back-link { display: inline-block; margin-bottom: 20px; color: #3498db; text-decoration: none; }
        .comment { background: #f4f4f4; padding: 15px; margin-bottom: 10px; border-left: 5px solid #2ecc71; border-radius: 4px; }
        .comment p { margin: 5px 0; }
        .date { font-size: 0.8em; color: #666; }
        input[type="text"], textarea { width: 100%; max-width: 400px; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        input[type="submit"] { background: #2ecc71; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; }
        input[type="submit"]:hover { background: #27ae60; }
    </style>
</head>
<body>

    <a href="index.php" class="back-link">&larr; Вернуться в меню</a>
    <h2>Задание №2: Гостевая книга (Запись и чтение из файла)</h2>
    
    <form action="task2.php" method="POST">
        <p><label>Ваше имя:<br><input type="text" name="username" required></label></p>
        <p><label>Сообщение:<br><textarea name="message" rows="4" required></textarea></label></p>
        <p><input type="submit" name="submit" value="Отправить отзыв"></p>
    </form>

    <hr>

    <h3>Отзывы пользователей</h3>

    <?php
    if (file_exists($filename)) {
        $file = fopen($filename, "r");
        if ($file) {
            if (flock($file, LOCK_SH)) {
                $comments = [];
                while (!feof($file)) {
                    $line = fgets($file);
                    if (trim($line) != "") {
                        $comments[] = $line;
                    }
                }
                flock($file, LOCK_UN);
                fclose($file);

                if (empty($comments)) {
                    echo "<p>Отзывов пока нет.</p>";
                } else {
                    $comments = array_reverse($comments);
                    foreach ($comments as $comment) {
                        $parts = explode("|||", $comment);
                        if (count($parts) == 3) {
                            echo "<div class='comment'>";
                            echo "<p><strong>" . $parts[1] . "</strong> <span class='date'>(" . $parts[0] . ")</span></p>";
                            echo "<p>" . nl2br($parts[2]) . "</p>";
                            echo "</div>";
                        }
                    }
                }
            }
        }
    } else {
        echo "<p>Отзывов пока нет. Будьте первым!</p>";
    }
    ?>

</body>
</html>