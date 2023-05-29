<?php
//Подключение к БД
require "db.php";
//Проверка наличия данных
$id_user = $_SESSION['logged_user']->id;
if (isset($_POST['request'])) {
    //Загрузка пользователя из БД
    $user = R::load('users', $id_user);
    if($_POST['request'] == 0){
        //Установка настройки сортировки
        $user->sortSettings = 0;
        R::store($user);
        $_SESSION['logged_user'] = $user;
        header('location: cabinet.php');
    } else {
        //Установка настройки сортировки
        $user->sortSettings = 1;
        R::store($user);
        $_SESSION['logged_user'] = $user;
        header('location: cabinet.php');
    }
}
?>
