<?php
//Подключение к БД
require "db.php";
//Помещение полученных данных в переменную
$data = $_POST;
//Получение id пользователя
$id_user = $_SESSION['logged_user']->id;
//Указание пути загрузки фалйов
$uploaddir = "files/";
//Загрузка имени файла
$tmp_name = $_FILES['file']['tmp_name'];
$file_name =  $_FILES['file']['name'];
//Задание параметров для обрезки названия файла
$string = explode('.', $file_name);
$symbols = 30;
//Обрезка строки
if (strlen($file_name) > $symbols) {
    $str = substr($file_name, 0, $symbols - 5);
    $r = end($string);
    $result =  $str . "..." . $r;
} else {
    $result = $file_name;
}
//Обновленное имя файла
$file_up_name = time() . $file_name;
$uploadfile = $uploaddir . $file_up_name;
//Проверка наличия данных
if (isset($data['send_docs'])) {
    if ($data['recipientId'] == 0) {
        $errors[] = 'Выберите получателя!';
    }
    if (empty($errors)) {
        //Загрузка файлов на сервер
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
            echo "Файл корректен и был успешно загружен.\n";
        } else {
            echo "Возможная атака с помощью файловой загрузки!\n";
        }
        //Обновление данных в БД
        $sentdoc = R::dispense('sentdocs');
        $sentdoc->recipientId = $data['recipientId'];
        $sentdoc->senderId = $id_user;
        $sentdoc->status = 1;
        $sentdoc->senderStatus = 1;
        $sentdoc->recipientStatus = 1;
        $sentdoc->documentName = $result;
        $sentdoc->tmpDocumentName = $file_up_name;
        $sentdoc->comment = $data['comment'];
        $sentdoc->date = date("d.m.Y, H:i:s");
        R::store($sentdoc);
        header('location: documents.php#content-2');
    } else {
        header('location: documents.php#content-3');
        $fsmsg = array_shift($errors);
    }
}
