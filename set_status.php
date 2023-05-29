<?php
//Подключение к БД
require "db.php";
//Помещение полученных данных в переменную
$data = $_POST;
//Проверка наличия данных
if (isset($data['set_status'])) {
    if (empty($errors)) {
        //Обновление в БД
        $row = R::load('sentdocs', $data['rowId']);
        $row->status = 2;
        R::store($row);
        header('location: documents.php#content-1');
    } else {
        $fsmsg = array_shift($errors);
    }
}

