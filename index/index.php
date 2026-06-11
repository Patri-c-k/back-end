<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель управления лабораторными</title>
    <style>
        body { font-family: Arial, sans-serif; background: #1e1e24; color: #fff; padding: 40px; }
        h1 { text-align: center; color: #4caf50; }
       .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 30px; }
        .card { background: #2a2a32; padding: 20px; border-radius: 8px; text-align: center; border: 1px solid #3f3f4e; }
        .card a { color: #00adb5; text-decoration: none; font-weight: bold; font-size: 18px; display: block; }
        .card a:hover { color: #eee; }
    </style>
</head>
<body>
    <h1>Мои лабораторные работы (Backend)</h1>
    <div class="grid">
        <div class="card"><a href="http://5kvt-shop/">Лабораторная 7-9 (5KVT)</a></div>
        <div class="card"><a href="http://mysyte/">Лабораторная 1</a></div>
        <div class="card"><a href="http://LP2/">Лабораторная 2</a></div>
        <div class="card"><a href="http://LP3/">Лабораторная 3</a></div>
        <div class="card"><a href="http://LP4/">Лабораторная 4</a></div>
        <div class="card"><a href="http://LP5/">Лабораторная 5</a></div>
        <div class="card"><a href="http://LP6/">Лабораторная 6</a></div>
    </div>
</body>
</html>