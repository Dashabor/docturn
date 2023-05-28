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
    <link rel="stylesheet" href="../css/about.css">
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
                                <a class="nav-link active" href="#">О нас</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="contacts.php">Контакты</a>
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
                                    <a class="btn" href="/logout.php" onclick="if(conf()) return true; else return false">Выйти</a>
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
                <h2>О нашей компании</h2>
            </div>
            <br><br>
            <div class="row">
                <h3>О нас</h3>
                <div class="col-lg-6 col-md-6">
                    <p>Docturn занимается поставкой и внедрением интеллектуальной системы управления документами.
                        Представляем решения для сдачи электронной отчётности чтобы вы могли сдавать её
                        в два клика и без ошибок. </p>
                    <p>Онлайн-сервис электронного документооборота (ЭДО)
                        для обмена юридически значимыми документами с контрагентами без дублирования на бумаге.
                    </p>
                </div>
            </div>
            <div class="about-background">
                <img src="img/about-background.svg" alt="">
            </div>
            <div class="row align-items-center advantages">
                <div class="col-lg-4 col-md-12">
                    <div class="advantage bordered-r">
                        <img src="img/about-adv1.svg" width="90px" alt="">
                        <p>Стоимость ЭДО дешевле расходов на бумагу, отправку почтой и курьером</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="advantage bordered-r">
                        <img src="img/about-adv2.svg" width="90px" alt="">
                        <p>Стоимость ЭДО дешевле расходов на бумагу, отправку почтой и курьером</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="advantage">
                        <img src="img/about-adv3.svg" width="90px" alt="">
                        <p>Стоимость ЭДО дешевле расходов на бумагу, отправку почтой и курьером</p>
                    </div>
                </div>
            </div>
            <?php if (!isset($_SESSION['logged_user']))     
        {
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
                </div>';
        }?>
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
    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>