<?php
//Подключение к БД
require "db.php";
//Если не авторизован, то перенаправление на страницу авторизации
if (isset($_SESSION['logged_user'])) {
} else {
    header('location: signin.php');
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
    <title>Личный кабинет</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/cabinet.css">
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
                                    <a class="nav-link" href="#">Личный кабинет</a>
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
                <h2>Личный кабинет</h2>
            </div>
            <div class="cabinet">
                <!-- Заголовок -->
                <h3>ФИО</h3>
                <!-- Сообщение об успехе -->
                <?php if (isset($smsg)) { ?> <div class="alert alert-success" role="alert"> <?php echo $smsg ?> </div> <?php } ?>
                <!-- Сообщение об ошибке -->
                <?php if (isset($fsmsg)) { ?> <div class="alert alert-danger" role="alert"> <?php echo $fsmsg ?> </div> <?php } ?>
                <!-- Форма для отправки измененных данных -->
                <form action="save_changes.php" method="post" onsubmit="if(conf()) return true; else return false">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <!-- Фамилия -->
                            <div class="text-field text-field_floating">
                                <input class="text-field__input" type="text" minlength="1" id="lastName" name="lastName" placeholder=" " autocomplete="off" value="<?php echo $_SESSION['logged_user']->lastName ?>" required>
                                <label class="text-field__label" for="lastName">Фамилия</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <!-- Имя -->
                            <div class="text-field text-field_floating">
                                <input class="text-field__input" type="text" minlength="1" id="firstName" name="firstName" placeholder=" " autocomplete="off" value="<?php echo $_SESSION['logged_user']->firstName ?>" required>
                                <label class="text-field__label" for="firstName">Имя</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <!-- Отчество -->
                            <div class="text-field text-field_floating">
                                <input class="text-field__input" type="text" id="patronymicName" name="patronymicName" placeholder=" " autocomplete="off" value="<?php echo $_SESSION['logged_user']->patronymicName ?>" required>
                                <label class="text-field__label" for="patronymicName">Отчество</label>
                            </div>
                        </div>
                    </div>
                    <div class="row date">
                        <!-- Измнение пола -->
                        <div class="col-lg-2 col-md-3">
                            <h3>Пол</h3>
                            <!-- Переключатель на мужчину -->
                            <label class="rad-label">
                                <input type="radio" class="rad-input" name="gender" value="1" <?php if ($_SESSION['logged_user']->gendername == 1) : ?> checked <?php endif ?>>
                                <div class="rad-design"></div>
                                <div class="rad-text">Мужчина</div>
                            </label>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <h3 class="hide">а</h3>
                            <!-- Переключатель на женщину -->
                            <label class="rad-label">
                                <input type="radio" class="rad-input" name="gender" value="2" <?php if ($_SESSION['logged_user']->gendername == 2) : ?> checked <?php endif ?>>
                                <div class="rad-design"></div>
                                <div class="rad-text">Женщина</div>
                            </label>
                        </div>
                        <!-- Дата рождения -->
                        <div class="col-lg-4 col-md-4">
                            <h3>Дата рождения</h3>
                            <?php
                            // Установка границ даты
                            $date = date("2004-m-d");
                            // Получение даты рождения пользователя
                            $userDate = $_SESSION['logged_user']->birthdayDate;
                            ?>
                            <!-- Вывод календаря -->
                            <div>
                                <input type="date" id="start" class="calendar" name="birthdayDate" value="<?php echo $userDate ?>" min="1960-01-01" max="<?php echo $date ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Почта -->
                        <div class="col-lg-3 col-md-6">
                            <h3>Email <span style="font-size: 16px; color:grey"> <?php if($_SESSION['logged_user']->emailConfirmed == 0) echo 'Не подтверждено'; else echo 'Подтверждено'?></span></h3> 
                            <div class="text-field text-field_floating">
                                <input class="text-field__input" type="email" id="userEmail" name="userEmail" placeholder=" " autocomplete="off" value="<?php echo $_SESSION['logged_user']->userEmail ?>" required>
                                <label class="text-field__label" for="userEmail">Email</label>
                            </div>
                        </div>
                        <!-- Телефон -->
                        <div class="col-lg-3 col-md-6">
                            <h3>Телефон</h3>
                            <div class="text-field text-field_floating">
                                <input class="text-field__input" type="tel" id="userTel" name="userTel" placeholder=" " autocomplete="off" value="<?php echo $_SESSION['logged_user']->userTel ?>" required>
                                <label class="text-field__label" for="userTel">Телефон</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Инн -->
                        <div class="col-lg-3">
                            <h3>ИНН</h3>
                            <div class="text-field text-field_floating">
                                <input class="text-field__input" type="text" id="userInn" name="userInn" placeholder=" " autocomplete="off" value="<?php echo $_SESSION['logged_user']->userInn ?>" required>
                                <label class="text-field__label" for="userInn">ИНН</label>
                            </div>
                        </div>
                        <!-- Должность -->
                        <div class="col-lg-3">
                            <h3>Должность</h3>
                            <div class="text-field text-field_floating">
                                <input disabled class="text-field__input" type="text" id="userRole" name="userRole" placeholder=" " autocomplete="off" value="<?php
                                        if ($_SESSION['logged_user']->role == 1) echo "Администратор";
                                        if ($_SESSION['logged_user']->role == 2) echo "Пользователь";
                                        ?>" required>
                                <label class="text-field__label" for="userRole">Должность</label>
                            </div>
                        </div>
                    </div><br>
                    <!-- Кнопки действий -->
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-12">
                            <!-- Кнопка сохранения-->
                            <button class="btn" type="submit" name="save_changes">Сохранить</button> 
                            <!-- Кнопка отмены -->
                            <a class="cancel-link" href="cabinet.php">Отменить</a>
                        </div>
                    </div>
                </form>
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
    <!-- Подключение скрипта для работы с календарем -->
    <script src="js/calendar.js"></script>
    <!-- Подключение библиотеки основных скриптов -->
    <script src="js/script.js"></script>
    <!-- Подключение библиотеки jquery  2.2.0-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <!-- Подключение библиотеки maskedinput -->
    <script src="js/jquery.maskedinput.min.js"></script>
    <!-- Подключение скриптов для входа -->
    <script src="js/signup.js"></script>
    <!-- Подключение библиотеки jquery  3.5.1-->
    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>