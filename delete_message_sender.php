<?php
//Подключение к БД
require "db.php";
//получение отправленных данных
$data = $_POST;
if (isset($data['delete_message'])) {
    if (empty($errors)) {
        //Поиск сообщения в базе данных
        $row = R::load('sentdocs', $data['rowId']);
        $row->senderStatus = 0;
        R::store($row);
        header('location: documents.php#content-2');
    } else {
        $fsmsg = array_shift($errors);
    }
}