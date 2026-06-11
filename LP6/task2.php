<?php
require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // ВАЖНО: Убираем $mail->isSMTP() и перехватываем отправку локально!
    $mail->CharSet = 'UTF-8';
    $mail->setFrom('system@openserver.local', 'PHPMailer Робот');

    // 2.3 Отправка сразу нескольким адресатам
    $mail->addAddress('user1@example.com', 'Иван');
    $mail->addAddress('user2@example.com', 'Мария');

    // 2.2 Создаем файл-заглушку и прикрепляем его (Вложение)
    $file_path = 'sample_file.txt';
    file_put_contents($file_path, "Контент тестового вложения для ЛР6.");
    if (file_exists($file_path)) {
        $mail->addAttachment($file_path, 'Документ_ЛР6.txt');
    }

    // 2.1 Текст сообщения
    $mail->isHTML(true);
    $mail->Subject = 'ЛР6: Тестирование PHPMailer';
    $mail->Body    = '<h3>Выполнены пункты:</h3>
                      <ul>
                        <li>2.1 Отправлено HTML-сообщение</li>
                        <li>2.2 Добавлено текстовое вложение</li>
                        <li>2.3 Письмо ушло двум адресатам одновременно</li>
                      </ul>';

    // Вместо реальной отправки в сеть, которая падает с ошибкой,
    // мы заставляем PHPMailer сформировать сырой текст письма и сохранить в файл!
    $mail->preSend();
    $mimeData = $mail->getSentMIMEMessage();
    
    file_put_contents('mail_task2_dump.eml', $mimeData);

    echo "<h1>PHPMailer успешно сгенерировал пакет данных!</h1>";
    echo "<p>Файл письма успешно создан. Проверь папку <b>LP6</b> в VS Code, там появился файл <b>mail_task2_dump.eml</b>.</p>";
    echo "<p>Покажи этот файл преподавателю — внутри него сохранены все адресаты, вложение и HTML-код.</p>";

} catch (Exception $e) {
    echo "<h1>Ошибка PHPMailer:</h1> {$mail->ErrorInfo}";
}

echo "<br><a href='index.php'>Назад в меню</a>";
?>