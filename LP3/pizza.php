<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sizes = [
        "small" => 250,
        "medium" => 350,
        "large" => 450
    ];

    $size = $_POST['size'] ?? null;
    $toppings = $_POST['toppings'] ?? [];
    $comment = htmlspecialchars($_POST['comment'] ?? '');
    $delivery = htmlspecialchars($_POST['delivery'] ?? '');

    if ($size && isset($sizes[$size])) {
        echo "Размер: $size ({$sizes[$size]} руб.)<br>";
    } else {
        echo "Размер не выбран<br>";
    }

    if (!empty($toppings)) {
        echo "Топпинги: " . implode(", ", $toppings) . "<br>";
    } else {
        echo "Без топпингов<br>";
    }

    echo "Комментарий: $comment<br>";
    echo "Доставка: $delivery<br>";
}
?>

<form method="POST">
    <h3>Размер:</h3>
    <input type="radio" name="size" value="small" checked> Маленькая<br>
    <input type="radio" name="size" value="medium"> Средняя<br>
    <input type="radio" name="size" value="large"> Большая<br>

    <h3>Топпинги:</h3>
    <input type="checkbox" name="toppings[]" value="сыр"> Сыр<br>
    <input type="checkbox" name="toppings[]" value="грибы"> Грибы<br>
    <input type="checkbox" name="toppings[]" value="колбаса"> Колбаса<br>

    <h3>Комментарий:</h3>
    <textarea name="comment"></textarea><br>

    <h3>Доставка:</h3>
    <select name="delivery">
        <option value="самовывоз">Самовывоз</option>
        <option value="курьер">Курьер</option>
    </select><br><br>

    <button type="submit">Заказать</button>
</form>