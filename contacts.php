<?php
require "db.php";
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Документооборот</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/contacts.css">
</head>

<body>
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <div class="logo">
                        <a href="index.php" class="navbar-brand"><span class="logo-color">DOC</span>TURN</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Переключатель навигации">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="index.php">Главная</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="about.php">О нас</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Контакты</a>
                            </li>
                            <?php if ($_SESSION['logged_user']->role == 1) :  ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="access.php">Допуски</a>
                                </li>
                            <?php endif; ?>

                            <?php if (isset($_SESSION['logged_user'])) : ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="documents.php#content-1">Документы</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="cabinet.php">Личный кабинет</a>
                                </li>
                                <li class="nav-item nav-button">
                                    <a class="btn" href="/logout.php">Выйти</a>
                                </li>
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
    <main>
        <div class="container">
            <div class="page-title">
                <h2>Контакты</h2>
            </div>
            <div class="row align-items-bottom">
                <h3>Связь с нами</h3>
                <div class="col-lg-6 col-md-6">
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
                <div class="col-lg-5 col-md-6 contacts-img">
                    <img src="img/contacts.jpg" width="500px" alt="">
                </div>

            </div>
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
                <h3>Вопросы и ответы</h3>
                <div class="questions">
                    <div class="col-lg-6 col-md-12 b-top">
                        <p><b>1. Как отправить документ?</b></p>
                        <p>Чтобы отправить документ, зайдите в раздел «Документы» и нажмите на кнопку «Создать».
                            Вы окажетесь на странице загрузки. Переместите сюда готовый файл с компьютера.
                            Выберите получателя и нажмите на кнопку «Отправить».</p>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <p><b>2. Технические требования к рабочему месту?</b></p>
                        <p>Рабочим местом является ПК с установленным на него необходимым программным обеспечением.
                            В Docturn можно работать, используя вход по логину и паролю.</p><p>
                            В общем случае для комфортной работы требуется: процессор с тактовой частотой не менее 1.7.ГГц,
                            оперативная память не менее 1,5 Гбайта, одна из операционных систем  Microsoft/ Mac,cвободное
                            дисковое пространство не менее 2 Гбайт.</p>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <p><b>3. Сменились реквизиты организации. Как их изменить?</b></p>
                        <p>Для того, чтобы поменять реквизиты организации (ИНН/КПП),
                            нужно зайти в «Личный кабинет», нажать на поля и изменить данные, после чего нажать кнопку «Сохранить».</p>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <footer>
        <div class="container">
            <div class="row justify-content-left">
                <div class="col-lg-3 col-md-6">
                    <p>192392, г. Санкт-Петербург, <br> ул. Репина, д. 5, кв. 382</p>
                </div>
                <div class="col-lg-2 col-md-6">
                    <p>docturn@mail.com</p>
                </div>
                <div class="col-lg-2 col-md-6">
                    <p>+7(912)333-22-11</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <p>
                        <a class="support" href="support.php">Техническая поддержка</a>
                    </p>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="logo">
                        <a href="#" class="navbar-brand"><span class="logo-color">DOC</span><span class="main-color">TURN</span></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>