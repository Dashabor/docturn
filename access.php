<?php
require "db.php";
if($_SESSION['logged_user']->role != 1)
{
    header('location: documents.php#content-1');
}

if (isset($_SESSION['logged_user'])) {

} else {
    header('location: signin.php');
}

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
    <link rel="stylesheet" href="../css/access.css">
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
                                <a class="nav-link" href="contacts.php">Контакты</a>
                            </li>
                            <?php if ($_SESSION['logged_user']->role == 1) :  ?>
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">Допуски</a>
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
                <h2>Допуски</h2>
            </div>
            <div class="requests">
                <?php if ($_SESSION['logged_user']->role == 1) {
                    $usersCount = R::findAll('users', 'id > 0');

                    $request = R::getAll('SELECT * FROM `users` ORDER BY id DESC LIMIT ?', [count($usersCount)]);

                    foreach ($request as $active) {
                        echo
                        '<div class="request" id="request' . $active['id'] . '">
                        <form action="set_access.php" method="POST">
                        <input type="text" name="userId" value="' . $active['id'] . '" hidden>
                                <h3>Заявка №' . $active['id'] . '</h3>
                            <div class="row">
                                <div class="col-lg-3 col-md-6 area bordered-r bordered-b first">
                                    <p><b>ФИО</b></p>
                                    <p class="p-10">' . $active['last_name'], ' ', $active['first_name'], ' ', $active['patronymic_name'] . '</p>
                                </div>
                            
                                <div class="col-lg-3 col-md-6 area bordered-r bordered-b second">
                                    <p><b>Должность</b></p>
                                    <p>
                                        <select name="role" id="">';
                        if ($active['role'] == 1) {
                            echo
                            '<option value="1" selected>Администратор</option>
                                                 <option value="2" >Пользователь</option>';
                        }
                        if ($active['role'] == 2) {
                            echo
                            '<option value="1" >Администратор</option>
                                                 <option value="2" selected>Пользователь</option>';
                        }
                        echo
                        '</select>
                                    </p>
                                </div>
                                <div class="col-lg-3 col-md-6 area  bordered-r bordered-b third">
                                    <p><b>Дата отправки</b></p>
                                    <p class="p-10">' . $active['registration_date'] . '</p>
                                </div>

                                <div class="col-lg-3 col-md-6 area fourth">
                                    <p><b>Статус допуска</b></p>
                                    <p>
                                        <select name="access_status" id="">';
                        if ($active['access_status'] == 1) {
                            echo
                            '<option value="1" selected>Нет допуска</option>
                                            <option value="2" >Есть допуск</option>';
                        }

                        if ($active['access_status'] == 2) {
                            echo
                            '<option value="1">Нет допуска</option>
                                            <option value="2" selected>Есть допуск</option>';
                        }
                        echo
                        '</select>
                                    </p>
                                </div>
                            </div><br>
                            <div class="row justify-content-center">
                                <div class="col-lg-3 col-md-6">
                                    <button class="btn" type="submit" name="set_access">Сохранить</button>
                                </div>
                            </div>
                            </form>
                        </div>
                            
                        ';
                    }
                }; ?>
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
    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>