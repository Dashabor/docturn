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
    <link rel="stylesheet" href="../css/contacts.css">
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
                                <a class="nav-link active" href="#">Контакты</a>
                            </li>
                            <!-- Если пользователь администратор, то отобразить вкладку "допуски" -->
                            <?php if ($_SESSION['logged_user']->role == 1) :  ?>
                                <!-- Пункт меню "Допуски" -->
                                <li class="nav-item">
                                    <a class="nav-link" href="access.php">Допуски</a>
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
            <!-- Заголовок страницы -->
            <div class="page-title">
                <h2>Контакты</h2>
            </div>
            <div class="row align-items-bottom">
                <!-- Заголовок блока -->
                <h3>Связь с нами</h3>
                <div class="col-lg-6 col-md-6">
                    <!-- Информация -->
                    <div class="contacts">
                        <p>
                            Адрес: г. Санкт-Петербург, ул. Репина, д. 5 <br>
                            Телефон:+7(912) 333-22-11 <br>
                            ИНН: 6734783645 <br>
                            КПП: 454455445 <br>
                            Почта: docturn@mail.com - общие вопросы <br>
                            docturn.marketing@mail.com - по вопросам сотрудничества <br>

                        </p>
                    </div>
                </div>
                <!-- Картинка -->
                <div class="col-lg-5 col-md-6 contacts-img">
                    <img src="img/contacts.jpg" width="500px" alt="">
                </div>
            </div>
            <!-- Вывод блока "подключиться" если пользователь не авторизован -->
            <?php if (!isset($_SESSION['logged_user'])) {
                echo '<div class="action">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12">
                        <div class="action-text">
                            <p>Работа с нами начинается с регистрации в <br>
                                Личном кабинете DOCTURN
                            </p>
                            <a class="btn" href="signup.php">Подключиться</a>
                        </div>
                    </div>
                </div>
                </div><br><br>';
            } else echo '<br><br><br><br>';
                ?> 
            <div class="row">
                <!-- Блок вопросы и ответы -->
                <h3>Вопросы и ответы</h3>
                <div class="questions">
                    <div class="col-lg-6 col-md-12 b-top">
                        <!-- Вопрос 1 -->
                        <p><b>1. Как отправить документ?</b></p>
                        <p>Чтобы отправить документ, зайдите в раздел «Документы» и нажмите на кнопку «Создать».
                            Вы окажетесь на странице загрузки. Переместите сюда готовый файл с компьютера.
                            Выберите получателя и нажмите на кнопку «Отправить».</p>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <!-- Вопрос 2 -->
                        <p><b>2. Технические требования к рабочему месту?</b></p>
                        <p>Рабочим местом является ПК с установленным на него необходимым программным обеспечением.
                            В Docturn можно работать, используя вход по логину и паролю.</p><p>
                            В общем случае для комфортной работы требуется: процессор с тактовой частотой не менее 1.7.ГГц,
                            оперативная память не менее 1,5 Гбайта, одна из операционных систем  Microsoft/ Mac,cвободное
                            дисковое пространство не менее 2 Гбайт.</p>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <!-- Вопрос 3 -->
                        <p><b>3. Сменились реквизиты организации. Как их изменить?</b></p>
                        <p>Для того, чтобы поменять реквизиты организации (ИНН/КПП),
                            нужно зайти в «Личный кабинет», нажать на поля и изменить данные, после чего нажать кнопку «Сохранить».</p>
                    </div>
                </div>
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