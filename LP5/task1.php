<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Задание №1</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; line-height: 1.6; }
        .back-link { display: inline-block; margin-bottom: 20px; color: #3498db; text-decoration: none; }
        .example-block { background: #f9f9f9; border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        h3 { margin-top: 0; color: #2c3e50; }
    </style>
</head>
<body>

    <a href="index.php" class="back-link">&larr; Вернуться в меню</a>
    <h2>Практическая часть: Задание №1</h2>

    <div class="example-block">
        <h3>Пример А: Построчное чтение файла (из Примера 3.2)</h3>
        <?php
        // Создадим проверочный файл, если его нет
        if (!file_exists("1.txt")) {
            file_put_contents("1.txt", "Первая строка из файла 1.txt\nВторая строка из файла 1.txt\nТретья строка.");
        }

        $f = fopen("1.txt", "r");
        if ($f) {
            while(!feof($f)) {
                echo htmlspecialchars(fgets($f)) . "<br />";
            }
            fclose($f);
        } else {
            echo "Не удалось открыть файл 1.txt";
        }
        ?>
    </div>

    <div class="example-block">
        <h3>Пример Б: Запись строки в файл (из Примера 4.1)</h3>
        <?php
        $f = fopen("textfile.txt", "w");
        if ($f) {
            fwrite($f, "PHP Поганец! (Данные успешно перезаписаны в " . date('H:i:s') . ")"); 
            fclose($f);
            
            // Читаем для демонстрации
            $f = fopen("textfile.txt", "r");
            echo "<strong>Содержимое textfile.txt:</strong> " . fgets($f); 
            fclose($f);
        } else {
            echo "Ошибка записи в файл textfile.txt";
        }
        ?>
    </div>

</body>
</html>