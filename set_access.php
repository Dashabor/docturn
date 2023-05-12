<?php
require "db.php";
//для запоминания айди пользователя
$data = $_POST;
$id_user = $data['userId'];
//получение отправленных аднных
if (isset($data['set_access'])) {
  if (empty($errors)) {

    $user = R::load('users', $id_user);
    $user->role = $data['role'];
    $user->accessStatus = $data['access_status'];
    R::store($user);
    if ($_SESSION['logged_user']->id == $id_user) {
      $_SESSION['logged_user'] = $user;
      if ($_SESSION['logged_user']->role != 1) {
        header("location: documents.php#content-1");
      } else {
        header("location: access.php#request$id_user");
      }
    } else
      header("location: access.php#request$id_user");
  } else {
    //сообщение об ошибке
    $fsmsg = array_shift($errors);
  }
}
