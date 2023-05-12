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
                                <a class="nav-link active" aria-current="page" href="#">Главная</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="about.php">О нас</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="contacts.php">Контакты</a>
                            </li>
                            <?php if ($_SESSION['logged_user']->role == 1) :  ?>
                                <li class="nav-item">
                                <a class="nav-link" href="access.php">Допуски</a>
                            </li>
                            <?php endif; ?>

                            <?php if(isset($_SESSION['logged_user'])) : ?>
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
            <div class="main-page">
                <h1>DOCTURN - ЭТО</h1>
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-md-4">
                        <div class="main-card ">
                            <h2>Работа с документами</h2>
                            <p>Cервис электронного документооборота, который позволит вам обмениваться любыми электронными документами</p>
                            <img src="img/1.png" alt="">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="main-card">
                            <h2>Сотрудники</h2>
                            <p>В Docturn для вашей организации доступно неограниченное количество пользователей без доплаты</p>
                            <img src="img/3.png" alt="">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="main-card">
                            <h2>Доступность</h2>
                            <p>Не требуется установка на ваших компьютерах, не нужно беспокоиться о сохранности данных, можно пользоваться с любого настроенного рабочего места или из дома</p>
                            <img src="img/2.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-md-4">
                        <div class="main-button">
                            <a class="btn" href="signup.php">Подключиться</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="container">
            <div class="row justify-content-left">
                <div class="col-lg-4 col-md-6">
                    <p>г. Санкт-Петербург, ул. Репина, д. 5</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <p>docturn@mail.com</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <p>+7(912)333-22-11</p>
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