<?php
//Подключение к БД
require "db.php";
?>

<!-- Код страницы -->
<!DOCTYPE html>
<html lang="ru">

<head>
    <!-- Настройка параметров страницы и подключение стилевых файлов -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Документооборот</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
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
                                <a class="nav-link" aria-current="page" href="#">Главная</a>
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
    <main>
        <!-- Главный контейнер -->
        <div class="container">
            <div class="main-page">
                <!-- Заголовок страницы -->
                <h1>DOCTURN - ЭТО</h1>
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-md-4">
                        <!-- Карточка с преимуществом -->
                        <div class="main-card ">
                            <h2>Работа с документами</h2>
                            <p>Cервис электронного документооборота, который позволит вам обмениваться любыми электронными документами</p>
                            <img src="img/1.png" alt="">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <!-- Карточка с преимуществом -->
                        <div class="main-card">
                            <h2>Сотрудники</h2>
                            <p>В Docturn для вашей организации доступно неограниченное количество пользователей без доплаты</p>
                            <img src="img/3.png" alt="">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <!-- Карточка с преимуществом -->
                        <div class="main-card">
                            <h2>Доступность</h2>
                            <p>Не требуется установка на ваших компьютерах, не нужно беспокоиться о сохранности данных, можно пользоваться с любого настроенного рабочего места или из дома</p>
                            <img src="img/2.png" alt="">
                        </div>
                    </div>
                </div>
                <!-- Проверка авторизованного пользователя -->
                <?php if(!isset($_SESSION['logged_user'])) : ?>
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-md-4">
                        <!-- Кнопка "Подключиться" -->
                        <div class="main-button">
                            <a class="btn" href="signup.php">Подключиться</a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <!-- Конец главной информации страницы -->
    <!-- Подвал сайта -->
    <footer>
        <!-- Основной контейнер -->
        <div class="container">
            <div class="row justify-content-left">
                <!-- Контактная информация -->
                <div class="col-lg-3 col-md-6">
                    <p>192392, г. Санкт-Петербург, <br> ул. Репина, д. 5, кв. 382</p>
                </div>
                <!-- Почта для связи -->
                <div class="col-lg-2 col-md-6">
                    <p>docturn@mail.com</p>
                </div>
                <!-- Номер для связи -->
                <div class="col-lg-2 col-md-6">
                    <p>+7(912)333-22-11</p>
                </div>
                <!-- Ссылка на техническую поддержку -->
                <div class="col-lg-3 col-md-6">
                    <p>
                        <a class="support" href="support.php">Техническая поддержка</a>
                    </p>
                </div>
                <!-- Ссылка на главную страницу -->
                <div class="col-lg-2 col-md-6">
                    <!-- Логотип -->
                    <div class="logo">
                        <a href="index.php" class="navbar-brand"><span class="logo-color">DOC</span><span class="main-color">TURN</span></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Конец подвала страницы -->
    <!-- Подключение скриптов -->
    <!-- Подключение библиотеки основных скриптов -->
    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>