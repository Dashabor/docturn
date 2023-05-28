<?php
require "db.php";

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
    <link rel="stylesheet" href="../css/documents.css">
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
                                    <a class="nav-link" href="access.php">Допуски</a>
                                </li>
                            <?php endif; ?>

                            <?php if (isset($_SESSION['logged_user'])) : ?>
                                <li class="nav-item">
                                    <a class="nav-link active" href="#content-1">Документы</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="cabinet.php">Личный кабинет</a>
                                </li>
                                <li class="nav-item nav-button">
                                    <a class="btn exit" href="/logout.php" onclick="if(conf()) return true; else return false">Выйти</a>
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
                <h2>Документы</h2>
            </div>

            <div class="row instruments">
                
                <div class="col-lg-7 col-md-3 p-20">
                    
                </div>

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
            <div class="tabs">

                <?php
                if ($_SESSION['logged_user']->accessStatus == 2) {

                    if($_SESSION['logged_user']->sortSettings == 1){
                        $request = R::getAll('SELECT * FROM `sentdocs` WHERE recipient_id = ? AND recipient_status = 1 ORDER BY `id` DESC', [$_SESSION['logged_user']->id]);
                    } else {
                        $request = R::getAll('SELECT * FROM `sentdocs` WHERE recipient_id = ? AND recipient_status = 1 ORDER BY `id`', [$_SESSION['logged_user']->id]);
                    }
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

                    foreach ($request as $active) {
                        echo    '<div class="row align-items-center searchRow">
                                        <div class="col-lg-3 col-md-3 p-20 p-10" >
                                            <div class="row align-items-center justify-content-center">
                                                <div class="col-lg-12 col-md-12 searchMessage">';

                        $sender = R::findOne('users',  'id = ?', [$active['sender_id']]);

                        echo '<p>' . $sender['last_name'] . ' ' . $sender['first_name'] . ' ' . $sender['patronymic_name'] .  '</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 bordered-r bordered-l p-20 p-10 searchMessage">
                                            <a href="files/' . $active['tmp_document_name'] . '" download>' . $active['document_name'] . '</a>
                                        </div>
                                        <div class="col-lg-2 col-md-2 bordered-r p-20">
                                            <p>';
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
                if ($_SESSION['logged_user']->accessStatus == 2) {
                    
                    if($_SESSION['logged_user']->sortSettings == 1){
                        $request = R::getAll('SELECT * FROM `sentdocs` WHERE sender_id = ? AND sender_status = 1 ORDER BY `id` DESC', [$_SESSION['logged_user']->id]);
                    } else {
                        $request = R::getAll('SELECT * FROM `sentdocs` WHERE sender_id = ? AND sender_status = 1 ORDER BY `id`', [$_SESSION['logged_user']->id]);
                    }
                   
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

                    foreach ($request as $active) {
                        echo    '<div class="row align-items-center searchRow">
                                            <div class="col-lg-3 col-md-3 bordered-r p-20 p-10">
                                                <div class="row align-items-center justify-content-center">
                                                    
                                                    <div class="col-10 searchMessage">';
                        $resipient = R::findOne('users',  'id = ?', [$active['recipient_id']]);
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
                    <form class="msg-form" id="documents-form" method="post" action="send_document.php" enctype="multipart/form-data">
                        <div class="row justify-content-center align-items-center new-doc">
                            <div class="col-lg-4 col-md-4 p-20">
                                <select name="recipientId" required>
                                    <option value="">Выберите отправителя</option>';


                    $request = R::getAll('SELECT * FROM `users` WHERE id != ?', [$_SESSION['logged_user']->id]);
                    foreach ($request as $active) {
                        if ($active['id'] != $id_user) {
                            echo '<option value="' . $active['id'] . '">' . $active['last_name']  . ' '
                                . $active['first_name'] . ' ' . $active['patronymic_name'] . '</option>';
                        }
                    }

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

                    echo '<button class="btn send" type="submit" name="send_docs" onlick=>Отправить</button>
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

                <?php if (isset($smsg)) { ?> <div class="alert alert-success" role="alert"> <?php echo $smsg ?> </div> <?php } ?>
                <?php if (isset($fsmsg)) { ?> <div class="alert alert-danger" role="alert"> <?php echo $fsmsg ?> </div> <?php } ?>

                <div class="tabs__links">
                    <div>
                        <a id="send" class="btn" href="#content-1">Входящие</a>
                    </div>
                    <div>
                        <a id="recip" class="btn" href="#content-2">Исходящие</a>
                    </div>
                    <div>
                        <a id="create" class="btn" href="#content-3">Создать</a>
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

    <script src="https://snipp.ru/cdn/jquery/2.1.1/jquery.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/elasticsearch.js"></script>
    <script src="js/sort.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>