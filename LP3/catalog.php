<?php
$products = [
    ['name' => 'Ноутбук', 'category' => 'электроника', 'price' => 55000],
    ['name' => 'Книга PHP', 'category' => 'книги', 'price' => 1200],
    ['name' => 'Мышь', 'category' => 'электроника', 'price' => 1500],
    ['name' => 'Клавиатура', 'category' => 'электроника', 'price' => 3000],
    ['name' => 'Роман', 'category' => 'книги', 'price' => 800],
    ['name' => 'Телефон', 'category' => 'электроника', 'price' => 30000],
];

$min = $_GET['min_price'] ?? null;
$max = $_GET['max_price'] ?? null;
$category = $_GET['category'] ?? '';

$categories = array_unique(array_column($products, 'category'));

echo "<form method='GET'>
Мин цена: <input name='min_price'><br>
Макс цена: <input name='max_price'><br>

Категория:
<select name='category'>
<option value=''>Все</option>";

foreach ($categories as $cat) {
    echo "<option value='$cat'>$cat</option>";
}

echo "</select><br>
<button>Фильтр</button>
</form>";

$filtered = array_filter($products, function($p) use ($min, $max, $category) {
    if ($min && $p['price'] < $min) return false;
    if ($max && $p['price'] > $max) return false;
    if ($category && $p['category'] != $category) return false;
    return true;
});

echo "<h3>Товары:</h3>";
foreach ($filtered as $p) {
    echo "{$p['name']} | {$p['category']} | {$p['price']}<br>";
}

echo "<br><a href='?min_price=1000'>Дороже 1000</a>";
echo "<br><a href='?category=книги'>Только книги</a>";
?>