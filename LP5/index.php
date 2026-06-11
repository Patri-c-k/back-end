<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Лабораторная работа №5</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .menu-container {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        h1 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            color: #2c3e50;
        }
        p {
            color: #7f8c8d;
            margin-bottom: 30px;
        }
        .btn {
            display: block;
            background: #3498db;
            color: #fff;
            padding: 12px;
            margin: 15px 0;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.2s ease;
        }
        .btn:hover {
            background: #2980b9;
        }
        .btn-alt {
            background: #2ecc71;
        }
        .btn-alt:hover {
            background: #27ae60;
        }
    </style>
</head>
<body>

<div class="menu-container">
    <h1>Лабораторная работа №5</h1>
    <p>Тема: Работа с файлами в PHP</p>
    
    <a href="task1.php" class="btn">Задание №1 (Типовые действия)</a>
    <a href="task2.php" class="btn btn-alt">Задание №2 (Гостевая книга)</a>
</div>

</body>
</html>