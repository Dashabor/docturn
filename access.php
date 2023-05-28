<?php
require "db.php";
if ($_SESSION['logged_user']->role != 1) {
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
            <div class="row instruments">

                <div class="col-lg-5 col-md-3 p-20">

                </div>

                <div class="col-lg-3 col-md-3 p-20">
                    <input id="elastic_access" class="elasticSearch" placeholder="Поиск" type="text">
                </div>

                <div class="col-lg-2 col-md-3 p-20">
                    <select class="sortDate" name="" id="sortDate">
                        <option value="1" <?php if ($_SESSION['logged_user']->sortSettings == 1) echo 'selected' ?>>Сначала новые</option>
                        <option value="0" <?php if ($_SESSION['logged_user']->sortSettings == 0) echo 'selected' ?>>Сначала старые</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-3 p-20">
                    <button class="btn" id="pdf_button">Скачать</button>
                </div>
            </div>



            <div id="requests" class="requests">
                <?php if ($_SESSION['logged_user']->role == 1) {

                    $usersCount = R::findAll('users', 'id > 0');

                    if ($_SESSION['logged_user']->sortSettings == 1) {
                        $request = R::getAll('SELECT * FROM `users` ORDER BY id DESC LIMIT ?', [count($usersCount)]);
                    } else {
                        $request = R::getAll('SELECT * FROM `users` ORDER BY id LIMIT ?', [count($usersCount)]);
                    }

                    echo  '<div id="download_pdf" style="display:none">
                    <table id="pdf" class="pdf" style="width:100%; text-align:center">
                        <caption align="top" style="font-size:30px; height:60px">Список всех контрагентов</caption> <br>
                                <thead>
                                    <tr style="height: 40px;">
                                        <th>
                                        ФИО</th>
                                        <th>
                                        Роль</th>
                                        <th>
                                        Дата регистрации</th>
                                        <th>
                                        Статус допуска</th>
                                    </tr>
                                </thead>
                                <tbody>';
                    foreach ($request as $active) {
                        echo '
                                    <tr style="height: 30px;">
                                        <td>
                                        ' . $active['last_name'], ' ', $active['first_name'], ' ', $active['patronymic_name'] . '</td>';

                        if ($active['role'] == 1) {
                            echo '<td>Администратор</td>';
                        } else {
                            echo '<td>Пользователь</td>';
                        }

                        echo '<td>' . $active['registration_date'] . '</td>';

                        if ($active['access_status'] == 1) {
                            echo '<td>Нет допуска</td>';
                        } else {
                            echo '<td>Есть допуск</td>';
                        }
                        echo

                        '</tr>';
                    }
                    echo '</tbody>
                        </table>
                        </div>';







                    foreach ($request as $active) {
                        echo
                        '<div class="request" id="request' . $active['id'] . '">
                        <form action="set_access.php" method="POST">
                        <input type="text" name="userId" value="' . $active['id'] . '" hidden>
                                <h3>Заявка №' . $active['id'] . '</h3>
                            <div class="row">
                                <div class="col-lg-3 col-md-6 area bordered-r bordered-b first">
                                    <p><b>ФИО</b></p>
                                    <p class="p-10 findName">' . $active['last_name'], ' ', $active['first_name'], ' ', $active['patronymic_name'] . '</p>
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
    <script src="https://snipp.ru/cdn/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <script src="js/script.js"></script>
    <script src="js/elasticsearchdocs.js"></script>
    <script src="js/sort.js"></script>
    <script>
        var button = document.getElementById("pdf_button");
        var makepdf = document.getElementById("download_pdf");

        button.addEventListener("click", function() {
            var mywindow = window.open("", "PRINT",
                "height=1000,width=1200");

            mywindow.document.write(makepdf.innerHTML);

            mywindow.document.close();
            mywindow.focus();

            mywindow.print();
            mywindow.close();

            return true;
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>