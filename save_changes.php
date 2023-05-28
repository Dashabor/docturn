<?php
require "db.php";
$id_user = $_SESSION['logged_user']->id;
$data = $_POST;

//получение отправленных аднных
if (isset($data['save_changes'])) {

    if (empty($errors)) {

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
        header('location: cabinet.php');
    } else {
        //сообщение об ошибке
        echo "Ошибка";
        header('location: cabinet.php');
        $fsmsg = array_shift($errors);
    }
}
