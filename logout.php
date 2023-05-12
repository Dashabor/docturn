<?php
//подключение к базе данных
    require "db.php";
//удаление сессии
    unset($_SESSION['logged_user']);
//перенаправление на главную страницу
    header('location: /index.php');
?>