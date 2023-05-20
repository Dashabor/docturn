<?php
require "db.php";
$id_user = $_SESSION['logged_user']->id;
if (isset($_POST['request'])) {

    $user = R::load('users', $id_user);
    if($_POST['request'] == 0){
        $user->sortSettings = 0;
        R::store($user);
        $_SESSION['logged_user'] = $user;
        header('location: cabinet.php');
    } else {
        $user->sortSettings = 1;
        R::store($user);
        $_SESSION['logged_user'] = $user;
        header('location: cabinet.php');
    }
}
?>
