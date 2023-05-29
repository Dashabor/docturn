<?php
//Подключение к БД
require "db.php";
//Получения id пользователя
$id_user = $_SESSION['logged_user']->id;
//Помещение полученных данных в переменную
$data = $_POST;
//Проверка наличия данных
if (isset($data['save_changes'])) {
    if (empty($errors)) {
        //Обновление данных в БД
        $user = R::load('users', $id_user);
        $user->firstName = $data['firstName'];
        $user->lastName = $data['lastName'];
        $user->patronymicName = $data['patronymicName'];
        $user->gendername = $data['gender'];
        $user->userInn = $data['userInn'];
        $user->userTel = $data['userTel'];
        $user->userEmail = $data['userEmail'];
        $user->birthdayDate = $data['birthdayDate'];
        R::store($user);
        $_SESSION['logged_user'] = $user;
        //Перенаправление
        header('location: cabinet.php');
    } else {
        //Сообщение об ошибке
        echo "Ошибка";
        header('location: cabinet.php');
        $fsmsg = array_shift($errors);
    }
}
