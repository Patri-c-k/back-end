<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Проверяем, если форма была отправлена, обрабатываем её
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require 'phpmailer/Exception.php';
    require 'phpmailer/PHPMailer.php';
    require 'phpmailer/SMTP.php';

    $name = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['useremail']);
    $msg = htmlspecialchars($_POST['usermessage']);

    $mail = new PHPMailer(true);

    try {
        $mail->CharSet = 'UTF-8';
        $mail->setFrom('form@my-idz.local', 'Модуль ИДЗ');
        $mail->addAddress('admin-project@example.com'); // Почта админа вашего ИДЗ

        // Обработка загруженного файла (анкеты/резюме)
        if (isset($_FILES['userfile']) && $_FILES['userfile']['error'] === UPLOAD_ERR_OK) {
            $mail->addAttachment($_FILES['userfile']['tmp_name'], $_FILES['userfile']['name']);
        }

        $mail->isHTML(true);
        $mail->Subject = "ИДЗ: Новая заявка/анкета от {$name}";
        $mail->Body    = "<h2>Новое сообщение с сайта ИДЗ</h2>
                          <p><b>Имя:</b> {$name}</p>
                          <p><b>Email:</b> {$email}</p>
                          <p><b>Текст/Анкета:</b><br>{$msg}</p>";

        // Эмулируем локальное сохранение формы, обходя блокировки OpenServer v6
        $mail->preSend();
        $mimeData = $mail->getSentMIMEMessage();
        file_put_contents('mail_task3_idz_dump.eml', $mimeData);

        $status = "<p style='color: green; font-weight: bold;'>Заявка успешно обработана локально! Файл 'mail_task3_idz_dump.eml' создан в папке проекта.</p>";
    } catch (Exception $e) {
        $status = "<p style='color: red;'>Ошибка отправки: {$mail->ErrorInfo}</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Пункт 3: Модуль ИДЗ</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; background: #f4f4f4; }
        .form-box { background: white; padding: 25px; border-radius: 5px; max-width: 500px; margin: 0 auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input, textarea { width: 100%; padding: 10px; margin: 10px 0; box-sizing: border-box; }
        button { background: #2ecc71; color: white; padding: 12px; border: none; width: 100%; cursor: pointer; font-size: 16px; font-weight: bold; }
        button:hover { background: #27ae60; }
    </style>
</head>
<body>

<div class="form-box">
    <h2>Форма обратной связи / Анкета для ИДЗ</h2>
    
    <?php if(isset($status)) echo $status; ?>

    <form action="task3.php" method="POST" enctype="multipart/form-data">
        <label>Ваше имя:</label>
        <input type="text" name="username" placeholder="Имя" required>

        <label>Ваш Email:</label>
        <input type="email" name="useremail" placeholder="Email" required>

        <label>Ваше сообщение / Интересы:</label>
        <textarea name="usermessage" rows="4" placeholder="Введите текст сообщения..." required></textarea>

        <label>Прикрепить анкету (Файл):</label>
        <input type="file" name="userfile">

        <button type="submit">Отправить данные</button>
    </form>
    
    <br>
    <a href="index.php">Назад в главное меню</a>
</div>

</body>
</html>