<?php
//подключение к базе данных
require "db.php";
//получение отправленных данных
$data = $_POST;
var_dump($data);

if (isset($data['set_status'])) {

    if (empty($errors)) {

        $row = R::load('sentdocs', $data['rowId']);
        $row->status = 2;
        R::store($row);
        header('location: documents.php#content-1');
    } else {
        //header('location: documents.php#content-2');
        $fsmsg = array_shift($errors);
    }
}

