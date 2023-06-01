<?php
//Подключение к БД
require "db.php";
//Проверка условия получения хэша
if ($_GET['hash']) {
    $hash = $_GET['hash'];
    //Поиск пользователя в БД по хэшу
    $request = R::findOne('users', 'hash = ?', array($hash));
    if ($request['email_confirmed'] == 0) {
        //Подтверждение пользователя в БД
        $user = R::load('users', $request['id']);
        $user->emailConfirmed = 1;
        R::store($user);
    }
} else {
    //Ошибка
    echo 'Хэш не получен.';
}
?>

<!-- Код страницы -->
<!DOCTYPE html>
<html lang="ru">

<head>
    <!-- Настройка параметров страницы и подключение стилевых файлов -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Подтверждение</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/signup.css">
    <link rel="stylesheet" href="../css/support.css">
</head>

<body>
    <!-- Шапка страницы -->
   <header>
        <!-- Общий контейнер -->
        <div class="container">
            <!-- Меню навигации -->
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <!-- Логотип -->
                    <div class="logo">
                        <a href="index.php" class="navbar-brand"><span class="logo-color">DOC</span>TURN</a>
                    </div>
                    <!-- Переключатель навигации -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Переключатель навигации">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <!-- Пункты меню -->
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                             <!-- Пункт меню "Главная" -->
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="index.php">Главная</a>
                            </li>
                            <!-- Пункт меню "О нас" -->
                            <li class="nav-item">
                                <a class="nav-link" href="about.php">О нас</a>
                            </li>
                            <!-- Пункт меню "Контакты" -->
                            <li class="nav-item">
                                <a class="nav-link" href="contacts.php">Контакты</a>
                            </li>
                            <!-- Если пользователь администратор, то отобразить вкладку "допуски" -->
                            <?php if ($_SESSION['logged_user']->role == 1) :  ?>
                                <!-- Пункт меню "Допуски" -->
                                <li class="nav-item">
                                    <a class="nav-link active" href="access.php">Допуски</a>
                                </li>
                            <?php endif; ?>
                            <!-- Если пользователь автороизован, то отобразить вкладки "документы", "личный кабинет" -->
                            <?php if (isset($_SESSION['logged_user'])) : ?>
                                <!-- Пункт меню "Документы" -->
                                <li class="nav-item">
                                    <a class="nav-link" href="documents.php#content-1">Документы</a>
                                </li>
                                <!-- Пункт меню "Личный кабинет" -->
                                <li class="nav-item">
                                    <a class="nav-link" href="cabinet.php">Личный кабинет</a>
                                </li>
                                <!-- Кнопка для завершения сессии -->
                                <li class="nav-item nav-button">
                                    <a class="btn" href="/logout.php" onclick="if(conf()) return true; else return false">Выйти</a>
                                </li>
                                <!-- Кнопка для авторизации на сайте -->
                            <?php else : ?>
                                <li class="nav-item nav-button">
                                    <a class="btn" href="/signin.php">Войти</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <!-- Конец шапки страницы -->
    <!-- Главная информация страницы -->
    <main style="height: 570px">
        <!-- Главный контейнер -->
        <div class="container">
            <div class="page-title">
                <!-- Заголовок страницы -->
                <h2>
                    <?php
                    //Поиск в пользователя в БД по хэшу
                    $request = $request = R::findOne('users', 'hash = ?', array($hash));
                    if ($request['email_confirmed'] == 1) {
                        //Подтверждение почты
                        echo 'Email подтвержден.';
                    } else {
                        //Перенаправление на 404
                        header('location: /404.php');
                    }
                    ?>
                </h2>
            </div>
        </div>
    </main>
    <!-- Конец главной информации страницы -->
    <!-- Подвал сайта -->
    <footer>
        <?php require "footer.php" ?>
    </footer>
    <!-- Конец подвала страницы -->
    <!-- Подключение скриптов -->
    <!-- Подключение библиотеки основных скриптов -->
    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>