<?php
//подключение к базе данных
require "db.php";
//получение отправленных данных
$data = $_POST;
$id_user = $_SESSION['logged_user']->id;
$uploaddir = "files/";
$tmp_name = $_FILES['file']['tmp_name'];
$file_name =  $_FILES['file']['name'];

$string = explode('.', $file_name);

$symbols = 30;

if (strlen($file_name) > $symbols) {
    $str = substr($file_name, 0, $symbols - 5);
    $r = end($string);
    $result =  $str . "..." . $r;
} else {
    $result = $file_name;
}


$file_up_name = time() . $file_name;

$uploadfile = $uploaddir . $file_up_name;

if (isset($data['send_docs'])) {


    if ($data['recipientId'] == 0) {
        $errors[] = 'Выберите получателя!';
    }

    if (empty($errors)) {

        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
            echo "Файл корректен и был успешно загружен.\n";
        } else {
            echo "Возможная атака с помощью файловой загрузки!\n";
        }
        $sentdoc = R::dispense('sentdocs');
        $sentdoc->recipientId = $data['recipientId'];
        $sentdoc->senderId = $id_user;
        $sentdoc->status = 1;
        $sentdoc->documentName = $result;
        $sentdoc->tmpDocumentName = $file_up_name;
        $sentdoc->date = date("d.m.Y, H:i:s");
        R::store($sentdoc);
        header('location: documents.php#content-2');
    } else {
        header('location: documents.php#content-3');
        $fsmsg = array_shift($errors);
    }
}
