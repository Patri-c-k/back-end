<?php
if (isset($_GET['name']) && isset($_GET['city'])) {
    $name = htmlspecialchars($_GET['name']);
    $city = htmlspecialchars($_GET['city']);

    echo "Пользователь $name проживает в городе $city";
} else {
    echo "Данные не указаны";
}
?>