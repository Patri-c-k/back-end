<?php
if (isset($_POST['username'])) {
    $user = htmlentities($_POST['username']);
    echo "Добро пожаловать, $user!";
} else {
    echo "Нет данных";
}
?>