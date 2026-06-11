<?php
mb_internal_encoding("UTF-8");

echo "<pre><h2>Лабораторная работа №2 — Решение</h2>";

echo "<h3>Задание 1 — Синтаксис PHP</h3>";

$integerVar = 42;
$floatVar = 3.14159;
$stringVar = "100 рублей";
$boolVar = true;
$nullVar = null;
$name = "Боря Купер";
$age = 22;
$city = "Гродно";
$price = 1499.99;
$discountPercent = 15;
$counter = 5;
$fruits = ["яблоко", "банан", "апельсин"];
$user = ["login" => "john", "role" => "admin", "active" => true];

define("TAX_RATE", 0.2);
const COMPANY = "ООО «Ромашка»";

$dateString = "2025-04-10";

echo "integerVar = $integerVar\n";
echo "floatVar = $floatVar\n";
echo "stringVar = $stringVar\n";
echo "boolVar = "; var_dump($boolVar);
echo "nullVar = "; var_dump($nullVar);

echo "\nТипы переменных:\n";
echo gettype($integerVar) . "\n";
echo gettype($floatVar) . "\n";
echo gettype($stringVar) . "\n";
echo gettype($boolVar) . "\n";
echo gettype($nullVar) . "\n";

echo "\nisset(undefinedVar): ";
var_dump(isset($undefinedVar));

unset($floatVar);
echo "\nПосле unset(floatVar):\n";
var_dump($floatVar);

echo "\nКонстанты:\n";
echo TAX_RATE . "\n";
echo COMPANY . "\n";

echo "defined(TAX_RATE): ";
var_dump(defined("TAX_RATE"));

echo "__FILE__: " . __FILE__ . "\n";
echo "__LINE__: " . __LINE__ . "\n";

$int1 = (int)$stringVar;
$int2 = $stringVar + 0;

echo "\nПреобразование строки в число:\n";
var_dump($int1);
var_dump($int2);

$strFloat = (string)$price;
echo "Тип после преобразования float → string: " . gettype($strFloat) . "\n";

echo "0 == false: "; var_dump(0 == false);
echo "0 === false: "; var_dump(0 === false);

echo "\"10 лет\" + 5 = ";
var_dump("10 лет" + 5);

echo "\nСумма integerVar + floatVar = " . ($integerVar + 3.14159) . "\n";
echo "Остаток integerVar % 7 = " . ($integerVar % 7) . "\n";
echo "integerVar^3 = " . ($integerVar ** 3) . "\n";

echo "\nИнкременты:\n";
echo $counter++ . "\n";
echo ++$counter . "\n";

$i = 5;
echo "+\$i = " . +$i . "\n";
echo "\$i+ = " . ($i + 0) . "\n";

echo "\nСтроковые операции:\n";
$str = "Имя: $name, возраст: $age, город: $city";
echo $str . "\n";
$str .= " (студент)";
echo $str . "\n";

echo "\nСравнение integerVar и stringVar:\n";
var_dump($integerVar == $stringVar);
var_dump($integerVar === $stringVar);

echo "\nSpaceship age <=> 25 = " . ($age <=> 25) . "\n";

echo "\nПроверка возраста и города:\n";
var_dump($age > 18 && $city === "Гродно");

echo "\nПроверка роли:\n";
var_dump($user["role"] === "admin" || $user["active"]);

echo "\n2 + 3 * 4 - 1 = " . (2 + 3 * 4 - 1) . "\n";
echo "(2 + 3) * (4 - 1) = " . ((2 + 3) * (4 - 1)) . "\n";

$a = 5 && $b = 10;
echo "\nПриоритет && выше = : a = "; var_dump($a);
echo "b = "; var_dump($b);

echo "\nКатегория возраста:\n";
if ($age < 18) echo "ребёнок\n";
elseif ($age <= 35) echo "молодой\n";
elseif ($age <= 60) echo "взрослый\n";
else echo "пенсионер\n";

echo "\nmatch:\n";
echo match(true) {
    $age < 18 => "ребёнок",
    $age <= 35 => "молодой",
    $age <= 60 => "взрослый",
    default => "пенсионер"
} . "\n";

$access = $boolVar ? "разрешён" : "запрещён";
echo "\nТернарный: $access\n";

echo "\nwhile 1..10:\n";
$i = 1;
while ($i <= 10) echo $i++ . " ";

echo "\nfor чётные 0..20:\n";
for ($i = 0; $i <= 20; $i += 2) echo $i . " ";

echo "\nforeach fruits:\n";
foreach ($fruits as $k => $v) echo "$k => $v\n";

foreach ($fruits as &$f) $f .= "!";
unset($f);

echo "\nfruits после изменения:\n";
print_r($fruits);

echo "\ncontinue/break:\n";
for ($i = 1; $i <= 10; $i++) {
    if ($i == 5) continue;
    if ($i == 8) break;
    echo $i . " ";
}

function greet($name) {
    return "Привет, $name!";
}

echo "\n\n" . greet($name) . "\n";

function calculateDiscount($price, $percent = 10) {
    return $price - ($price * $percent / 100);
}

echo calculateDiscount(1000) . "\n";
echo calculateDiscount(1000, 20) . "\n";

function sumAll(...$nums) {
    return array_sum($nums);
}

echo sumAll(1,2,3,4,5) . "\n";

$nums = [1,2,3,4,5];
$squares = array_map(fn($x) => $x*$x, $nums);
print_r($squares);

$evens = array_filter($nums, fn($x) => $x % 2 === 0);
print_r($evens);

function divide($a, $b) {
    if ($b == 0) return null;
    return $a / $b;
}

var_dump(divide(10, 2));
var_dump(divide(10, 0));

function noReturn() {}
var_dump(noReturn());

echo "\nabs(-15) = " . abs(-15) . "\n";
echo "ceil(4.7) = " . ceil(4.7) . "\n";
echo "floor(4.7) = " . floor(4.7) . "\n";
echo "round(3.14159,2) = " . round(3.14159,2) . "\n";

echo "rand(1,100) = " . rand(1,100) . "\n";

echo "max = " . max(34,67,12,89) . "\n";
echo "min = " . min(34,67,12,89) . "\n";

echo "\nTimestamp: " . time() . "\n";
echo "Текущая дата: " . date("d.m.Y H:i:s") . "\n";

$ts = mktime(0,0,0,1,1,2026);
echo "mktime 2026-01-01: $ts\n";

echo "Следующий понедельник: " . date("Y-m-d", strtotime("next Monday")) . "\n";

$dt = new DateTime($dateString);
$dt->modify("+2 weeks");
echo "Дата +2 недели: " . $dt->format("Y-m-d") . "\n";

$diff = (new DateTime("2026-02-11"))->diff(new DateTime());
echo "Разница в днях: " . $diff->days . "\n";

echo "<h3>Задание 2 — Массивы</h3>";

$students = [
    ["name" => "Анна", "age" => 20, "grade" => 4.5, "city" => "Минск"],
    ["name" => "Иван", "age" => 22, "grade" => 3.8, "city" => "Гродно"],
    ["name" => "Мария", "age" => 19, "grade" => 4.9, "city" => "Брест"],
    ["name" => "Петр", "age" => 21, "grade" => 4.1, "city" => "Гродно"],
    ["name" => "Елена", "age" => 20, "grade" => 4.7, "city" => "Минск"],
    ["name" => "Алексей", "age" => 23, "grade" => 3.5, "city" => "Витебск"]
];

$colors = ['red', 'green', 'blue', 'yellow', 'black', 'white'];

$capitals = [
    "Россия" => "Москва",
    "Беларусь" => "Минск",
    "Польша" => "Варшава",
    "Германия" => "Берлин"
];

echo "1. Инициализация и доступ:\n";
echo "Имя третьего: " . $students[2]["name"] . "\n";
echo "Возраст первого: " . $students[0]["age"] . "\n";
echo "Оценка последнего: " . $students[5]["grade"] . "\n";

$colors[] = "purple";
$removedFirst = array_shift($colors);
echo "Удалён первый цвет: $removedFirst\n";

$capitals["Франция"] = "Париж";
$capitals["Польша"] = "Белосток";
$capitals["Польша"] = "Варшава";

echo "\n2. Перебор:\n";
foreach ($students as $s) echo $s["name"] . "\n";

foreach ($capitals as $country => $capital) {
    echo "Столица $country — $capital\n";
}

foreach ($colors as &$c) $c = strtoupper($c);
unset($c);

echo "\nЦвета (верхний регистр):\n";
print_r($colors);

echo "\n3. Сортировка:\n";
sort($colors);
print_r($colors);

$ages = array_column($students, "age");
arsort($ages);
echo "Сортировка студентов по возрасту:\n";
foreach ($ages as $k => $v) {
    print_r($students[$k]);
}

ksort($capitals);
print_r($capitals);

echo "\n4. Поиск и проверка:\n";
if (!in_array("orange", $colors)) {
    $colors[] = "orange";
}
print_r($colors);

echo "Есть ли ключ grade: ";
var_dump(array_key_exists("grade", $students[0]));

echo "Индекс yellow: ";
var_dump(array_search("YELLOW", $colors));

echo "\n5. Работа с частью массива:\n";
$first3 = array_slice($colors, 0, 3);
print_r($first3);

$removedStudent = array_splice($students, 1, 1);
echo "Удалён студент:\n";
print_r($removedStudent);

$merged = array_merge($colors, ["pink", "brown"]);
print_r($merged);

echo "\n6. Преобразование:\n";
$ages = array_column($students, "age");
print_r($ages);

$lengths = array_map("strlen", $colors);
$colorLengths = array_combine($colors, $lengths);
print_r($colorLengths);

print_r(array_keys($capitals));
print_r(array_values($capitals));

echo "\n7. Функции высшего порядка:\n";
$filtered = array_filter($students, fn($s) => $s["age"] >= 21);
print_r($filtered);

$mapped = array_map(fn($s) => "{$s['name']} ({$s['age']} лет)", $students);
print_r($mapped);

$avg = array_reduce($students, fn($acc, $s) => $acc + $s["grade"], 0) / count($students);
echo "Средний балл: $avg\n";

echo "\nСлучайные элементы:\n";
$randKeys = array_rand($colors, 2);
echo $colors[$randKeys[0]] . ", " . $colors[$randKeys[1]] . "\n";

shuffle($colors);
print_r($colors);

echo "<h3>Задание 3 — Строки</h3>";
$text1 = "  PHP (Hypertext Preprocessor) — это скриптовый язык программирования общего назначения.  ";
$text2 = "Я люблю PHP. PHP — это мощный язык. Я учу PHP.";
$userComment = "<b>Отличный сайт!</b> <script>alert('XSS');</script>";
$priceStr = "  1 234,56 руб. ";
$slugSource = "Привет, как дела?";
$csvLine = "Иванов;Иван;ivan@mail.com;29;Минск";

$name2 = "Боря";

echo "1. Способы записи строк:\n";
echo 'Привет, $name2' . "\n";
echo "Привет, $name2\n";

echo <<<TXT
Многострочная строка:
Привет, $name2!
TXT;

echo "\n\n2. Доступ к символам:\n";
echo "Через индекс: " . $text1[0] . "\n";
echo "Через mb_substr: " . mb_substr($text1, 0, 1) . "\n";

$firstChar = mb_substr($slugSource, 0, 1);
$slugSource = mb_strtoupper($firstChar) . mb_substr($slugSource, 1);
echo "Изменённая строка: $slugSource\n";

echo "\n3. Операции со строками:\n";
$str = "Имя:";
$str .= " $name2";
echo $str . "\n";

var_dump("123" == 123);
var_dump("123" === 123);

echo "\n4. Длина строки:\n";
echo "strlen: " . strlen($text1) . "\n";
echo "mb_strlen: " . mb_strlen($text1) . "\n";

echo "\n5. Поиск подстроки:\n";
echo "Позиция PHP: " . strpos($text2, "PHP") . "\n";
var_dump(str_contains($text2, "JavaScript"));

echo "Количество PHP: " . substr_count(mb_strtolower($text2), "php") . "\n";

echo "\n6. Извлечение подстроки:\n";
$start = mb_strpos($text1, "скриптовый");
$end = mb_strpos($text1, "общего");
echo mb_substr($text1, $start, $end - $start) . "\n";

echo "Последние 10 символов: " . mb_substr($text1, -10) . "\n";

echo "\n7. Замена:\n";
echo str_replace("PHP", "РНР", $text2) . "\n";
echo str_replace(".", "", $text1) . "\n";

echo "\n8. Удаление пробелов:\n";
$clean = trim($priceStr);
echo "trim: $clean\n";

$clean = str_replace(["руб.", " "], "", $clean);
$clean = str_replace(",", ".", $clean);
echo "float: " . (float)$clean . "\n";

echo "\n9. Регистр:\n";
echo mb_strtolower($slugSource) . "\n";
echo mb_strtoupper($slugSource) . "\n";
echo mb_convert_case($slugSource, MB_CASE_TITLE) . "\n";

echo "\n10. Разбиение:\n";
$csv = explode(";", $csvLine);
echo "Фамилия: $csv[0]\nИмя: $csv[1]\nEmail: $csv[2]\n";

echo implode("|", $csv) . "\n";

$chars = mb_str_split($slugSource);
echo implode(", ", $chars) . "\n";

echo "\n11. Безопасность:\n";
echo htmlspecialchars($userComment) . "\n";
echo strip_tags($userComment) . "\n";

echo "\n12. Форматирование:\n";
echo sprintf("Студент %s, возраст %d, оценка %.1f", 
    $students[1]["name"], 
    $students[1]["age"], 
    $students[1]["grade"]
) . "\n";

echo number_format(12345.6789, 2, ",", " ") . "\n";

echo "<h3>Теоретическая часть</h3>";

echo "1. Условный оператор if/else:\n";
echo "Синтаксис:\n";
echo "if (условие) { ... } elseif (...) { ... } else { ... }\n";

$x = 10;
if ($x > 5) {
    echo "x больше 5\n";
} else {
    echo "x меньше или равно 5\n";
}

echo "\n2. Оператор switch:\n";
$day = 1;
switch ($day) {
    case 1:
        echo "Понедельник\n";
        break;
    case 2:
        echo "Вторник\n";
        break;
    default:
        echo "Другой день\n";
}

echo "\n3. Циклы:\n";

echo "while:\n";
$i = 1;
while ($i <= 3) {
    echo $i . " ";
    $i++;
}

echo "\ndo..while:\n";
$i = 1;
do {
    echo $i . " ";
    $i++;
} while ($i <= 3);

echo "\nfor:\n";
for ($i = 1; $i <= 3; $i++) {
    echo $i . " ";
}

echo "\n\n4. break и continue:\n";
for ($i = 1; $i <= 5; $i++) {
    if ($i == 2) continue;
    if ($i == 4) break;
    echo $i . " ";
}

echo "\n\n5. include / require:\n";
echo "include подключает файл (ошибка не критична)\n";
echo "require подключает файл (фатальная ошибка)\n";
echo "include_once / require_once — подключают один раз\n";

echo "\n6. Пользовательские функции:\n";
echo "Функции нужны для повторного использования кода\n";

function hello($name) {
    return "Привет, $name";
}
echo hello("Боря") . "\n";

echo "\n7. Локальные и глобальные переменные:\n";
$globalVar = 100;

function testGlobal() {
    global $globalVar;
    echo $globalVar . "\n";
}
testGlobal();

echo "return возвращает значение из функции\n";

echo "\n8. Математические функции:\n";
echo "abs(-10)=" . abs(-10) . "\n";
echo "round(3.5)=" . round(3.5) . "\n";
echo "max(1,5,3)=" . max(1,5,3) . "\n";

echo "\n9. Дата и время:\n";
echo "time()=" . time() . "\n";
echo "date()=" . date("Y-m-d") . "\n";
echo "strtotime(next day)=" . date("Y-m-d", strtotime("+1 day")) . "\n";
echo "</pre>";
?>