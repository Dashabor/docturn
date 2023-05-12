<?php
//подключение библиотеки
require "libs/rb-mysql.php";
//подключение к базе данных
R::setup( 'mysql:host=localhost;dbname=docturn','root', '' );
//отвечает за сессию
session_start();