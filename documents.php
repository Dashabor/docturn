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
    <title>Документооборот</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/documents.css">
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
                                    <a class="nav-link" href="access.php">Допуски</a>
                                </li>
                            <?php endif; ?>
                            <!-- Если пользователь автороизован, то отобразить вкладки "документы", "личный кабинет" -->
                            <?php if (isset($_SESSION['logged_user'])) : ?>
                                <!-- Пункт меню "Документы" -->
                                <li class="nav-item">
                                    <a class="nav-link active" href="#content-1">Документы</a>
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
                <h2>Документы</h2>
            </div>
            <!-- Поиск и сортировка по дате -->
            <div class="row instruments">
                <div class="col-lg-7 col-md-3 p-20"></div>
                <div class="col-lg-3 col-md-3 p-20">
                    <input id="elastic" class="elasticSearch" placeholder="Поиск" type="text">
                </div>
                <div class="col-lg-2 col-md-3 p-20">
                    <select class="sortDate" name="" id="sortDate">
                        <option value="1" <?php if ($_SESSION['logged_user']->sortSettings == 1) echo 'selected'?>>Сначала новые</option>
                        <option value="0" <?php if ($_SESSION['logged_user']->sortSettings == 0) echo 'selected'?>>Сначала старые</option>
                    </select>
                </div>
            </div>
            <!-- Вкладки "Входящие", "Отправленные" и "Создать" -->
            <div class="tabs">
                <?php
                //Проверка доступа пользователя
                if ($_SESSION['logged_user']->accessStatus == 2) {
                    //Проверка настроек пользователя
                    if($_SESSION['logged_user']->sortSettings == 1){
                        $request = R::getAll('SELECT * FROM `sentdocs` WHERE recipient_id = ? AND recipient_status = 1 ORDER BY `id` DESC', [$_SESSION['logged_user']->id]);
                    } else {
                        $request = R::getAll('SELECT * FROM `sentdocs` WHERE recipient_id = ? AND recipient_status = 1 ORDER BY `id`', [$_SESSION['logged_user']->id]);
                    }
                    //Вывод списка документов
                    echo '<div class="documents" id="content-1">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 bordered-r p-20">
                                            <p>Контрагент</p>
                                        </div>
                                        <div class="col-lg-3 col-md-3 bordered-r  p-20">
                                            <p>Название документа</p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 bordered-r p-20">
                                            <p>Статус</p>
                                        </div>
                                        <div class="col-lg-4 col-md-4 bordered-b  p-20">
                                            <p>Комментарий</p>
                                        </div> 
                                    </div>';
                    //Вывод каждого документа через цикл
                    foreach ($request as $active) {
                        echo    '<div class="row align-items-center searchRow">
                                        <div class="col-lg-3 col-md-3 p-20 p-10" >
                                            <div class="row align-items-center justify-content-center">
                                                <div class="col-lg-12 col-md-12 searchMessage">';
                        $sender = R::findOne('users',  'id = ?', [$active['sender_id']]);
                        //Вывод отправителя
                        echo '<p>' . $sender['last_name'] . ' ' . $sender['first_name'] . ' ' . $sender['patronymic_name'] .  '</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 bordered-r bordered-l p-20 p-10 searchMessage">
                                            <a href="files/' . $active['tmp_document_name'] . '" download>' . $active['document_name'] . '</a>
                                        </div>
                                        <div class="col-lg-2 col-md-2 bordered-r p-20">
                                            <p>';
                        //Проверка статуса сообщения
                        if ($active['status'] == 1) {
                            echo
                            '<form action="set_status.php" method="post" onsubmit="if(conf()) return true; else return false">
                                                        <input type="text" name="rowId" value="' . $active['id'] . '" hidden>    
                                                        <button class="set-status" type="submit" name="set_status">Прочитать</button>
                                                    </form>';
                        }
                        if ($active['status'] == 2) {
                            echo '<p style="padding-top:7px;">Прочитано</p>';
                        }
                        echo
                        '</p>
                                        </div>
                                        <div class="col-lg-3 col-md-3 bordered-b  p-20 p-10">
                                            <p> <span style="font-size:12px; text-align:right; color:grey">' . $active['date'] . '</span><br>' . $active['comment'] . '</p>
                                        </div>
                                        <div class="col-lg-1 col-md-1 bordered-b">
                                            <form action="delete_message_recipient.php" method="post" onsubmit="if(conf()) return true; else return false">
                                                <input type="text" name="rowId" value="' . $active['id'] . '" hidden>    
                                                <button class="delete-message" type="submit" name="delete_message">X</button>
                                            </form>
                                        </div>
                                    </div>';
                    }
                    echo '</div>';
                } else {
                    echo '<div class="documents" id="content-1">
                        <div class="row justify-content-center">
                            <div class="col-6 p-20 access-deny">
                                <p>Доступ отсутствует</p>
                            </div>
                        </div>
                    </div>';
                } ?>
                
                <?php
                //Проверка доступа пользователя
                if ($_SESSION['logged_user']->accessStatus == 2) {
                    //Проверка настроек пользователя
                    if($_SESSION['logged_user']->sortSettings == 1){
                        $request = R::getAll('SELECT * FROM `sentdocs` WHERE sender_id = ? AND sender_status = 1 ORDER BY `id` DESC', [$_SESSION['logged_user']->id]);
                    } else {
                        $request = R::getAll('SELECT * FROM `sentdocs` WHERE sender_id = ? AND sender_status = 1 ORDER BY `id`', [$_SESSION['logged_user']->id]);
                    }
                    //Вывод списка документов
                    echo    '<div class="documents" id="content-2">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 bordered-r p-20">
                                        <p>Контрагент</p>
                                    </div>
                                    <div class="col-lg-3 col-md-3 bordered-r  p-20">
                                        <p>Название документа</p>
                                    </div>
                                    <div class="col-lg-2 col-md-3 bordered-r p-20">
                                        <p>Статус</p>
                                    </div>
                                    <div class="col-lg-4 col-md-3 bordered-b  p-20">
                                        <p>Комментарий</p>
                                    </div>
                                </div>';
                    //Вывод каждого документа через цикл
                    foreach ($request as $active) {
                        echo    '<div class="row align-items-center searchRow">
                                            <div class="col-lg-3 col-md-3 bordered-r p-20 p-10">
                                                <div class="row align-items-center justify-content-center">                     
                                                    <div class="col-10 searchMessage">';
                        $resipient = R::findOne('users',  'id = ?', [$active['recipient_id']]);
                        //Вывод получателя
                        echo
                        '<p>' . $resipient['last_name'] . ' ' . $resipient['first_name'] . ' ' . $resipient['patronymic_name'] .  '</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 bordered-r  p-20 p-10 searchMessage">
                                                <p><a href="files/' . $active['tmp_document_name'] . '" download> ' . $active['document_name'] . ' </a></p>
                                            </div>
                                            <div class="col-lg-2 col-md-3 bordered-r p-20 p-10">
                                                <p>';
                        //Проверка статуса сообщения
                        if ($active['status'] == 1)
                            echo 'Не прочитано';
                        if ($active['status'] == 2)
                            echo 'Прочитано';
                        echo '</p>
                                            </div>
                                            <div class="col-lg-3 col-md-3 bordered-b  p-20 p-10">
                                            <p> <span style="font-size:12px; text-align:right; color:grey">' . $active['date'] . '</span><br>' . $active['comment'] . '</p>
                                        </div>
                                        <div class="col-lg-1 col-md-1 bordered-b">
                                            <form action="delete_message_sender.php" method="post" onsubmit="if(conf()) return true; else return false">
                                                <input type="text" name="rowId" value="' . $active['id'] . '" hidden>    
                                                <button class="delete-message" type="submit" name="delete_message">X</button>
                                            </form>
                                        </div>
                                        </div>';
                    }
                    echo '</div>';
                } else {
                    echo '<div class="documents" id="content-2">
                        <div class="row justify-content-center">
                                <div class="col-6 p-20 access-deny">
                                    <p>Доступ отсутствует</p>
                                </div>
                        </div>
                    </div>';
                }
                ?>
                <?php
                //Проверка доступа пользователя
                if ($_SESSION['logged_user']->accessStatus == 2) {
                    echo '
                <div class="documents" id="content-3">
                    <div class="row justify-content-center">
                        <div class="col-4 bordered-r p-20">
                            <p>Получатель</p>
                        </div>
                        <div class="col-4 bordered-r p-20">
                            <p>Файл</p>
                        </div>
                        <div class="col-4 p-20">
                            <p>Комментарий</p>
                        </div>
                    </div>
                    <form class="msg-form" id="documents-form" method="post" action="send_document.php" enctype="multipart/form-data" onsubmit="if(conf()) return true; else return false">
                        <div class="row justify-content-center align-items-center new-doc">
                            <div class="col-lg-4 col-md-4 p-20">
                                <select name="recipientId" required>
                                    <option value="">Выберите отправителя</option>';
                    $request = R::getAll('SELECT * FROM `users` WHERE id != ?', [$_SESSION['logged_user']->id]);
                    //Вывод всех отправителей
                    foreach ($request as $active) {
                        if ($active['id'] != $id_user) {
                            echo '<option value="' . $active['id'] . '">' . $active['last_name']  . ' '
                                . $active['first_name'] . ' ' . $active['patronymic_name'] . '</option>';
                        }
                    }
                    //Вывод кнопки "прикрепите файл" и комментария
                    echo ' </select>
                            </div>
                            <div class="col-lg-4 col-md-4 bordered-b  p-20">
                                <div class="input-file-row">
                                    <label class="input-file">
                                        <input type="file" name="file" required>
                                        <span class="btn">Выберите файл</span>
                                    </label>
                                    <div class="input-file-list"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 bordered-b  p-20">
                                <div>
                                    <textarea class="comment" name="comment" id="" cols="40" rows="2" ></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center align-items-center new-doc">
                            <div class="col-lg-4 col-md-12">';
                    echo '<button class="btn send" type="submit" name="send_docs" >Отправить</button>
                            </div>
                        </div>
                    </form>
                </div>';
                } else {
                    echo '<div class="documents" id="content-3">
                                    <div class="row justify-content-center">
                                            <div class="col-6 p-20 access-deny">
                                                <p>Доступ отсутствует</p>
                                            </div>
                                            </div>
                                        </div>';
                }
                ?>
                <!-- Переключатели -->
                <div class="tabs__links">
                    <!-- Входящие -->
                    <div>
                        <a id="send" class="btn" href="#content-1">Входящие</a>
                    </div>
                    <!-- Исходящие -->
                    <div>
                        <a id="recip" class="btn" href="#content-2">Исходящие</a>
                    </div>
                    <!-- Создать -->
                    <div>
                        <a id="create" class="btn" href="#content-3">Создать</a>
                    </div>
                </div>
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
    <!-- Подключение библиотеки jquery -->
    <script src="https://snipp.ru/cdn/jquery/2.1.1/jquery.min.js"></script>
    <!-- Подключение библиотеки основных скриптов -->
    <script src="js/script.js"></script>
    <!-- Подключение библотеки для поиска -->
    <script src="js/elasticsearch.js"></script>
    <!-- Подключение библотеки для добавления файла -->
    <script src="js/addfile.js"></script>
    <!-- Подключение библотеки для сортировки -->
    <script src="js/sort.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>