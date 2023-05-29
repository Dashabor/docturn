<?php
//Подключение к БД
    require "db.php";
//удаление сессии
    unset($_SESSION['logged_user']);
//перенаправление на главную страницу
    header('location: /index.php');
?>