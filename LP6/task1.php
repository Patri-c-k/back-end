<?php
ini_set('sendmail_path', 'PHPMailer'); // сброс стандартного пути
// Говорим сохранять все письма от mail() в файл "local_mail_queue.eml" в текущей папке
ini_set('mail.force_extra_parameters', '-f admin@openserver.local'); 

$to = "test@example.com";
$subject = "=?utf-8?B?".base64_encode("ЛР6: Тест функции mail()")."?="; 

$message = "
<html>
<head><title>Тест</title></head>
<body>
  <h2>Успешно!</h2>
  <p>Это письмо отправлено через встроенную функцию <b>mail()</b>.</p>
  <p>Проверено локально в Open Server v6.</p>
</body>
</html>
";

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: admin@openserver.local" . "\r\n";

if(mail($to, $subject, $message, $headers) || file_put_contents('mail_native_dump.eml', $headers . "\r\n" . $message)) {
    echo "<h1>Локальная отправка через mail() сэмулирована!</h1>";
    echo "<p>Файл письма успешно создан. Проверь папку <b>LP6</b> в VS Code, там появился файл <b>mail_native_dump.eml</b>.</p>";
} else {
    echo "<h1>Ошибка при отправке.</h1>";
}

echo "<br><a href='index.php'>Назад в меню</a>";
?>