<?php
//Подключение к БД
require "db.php";
//Помещение полученных данных в переменную
$data = $_POST;
//Проверка наличия данных
if (isset($data['send_to_support'])) {
    //Проверка ошибок
    if (trim($data['userName']) == '') {
        $errors[] = 'Как к Вам обращаться?';
    }
    if (trim($data['problemText']) == '') {
        $errors[] = 'Укажите проблему';
    }
    if (R::count('questions', "user_email = ?", array($_SESSION['logged_user']->userEmail)) > 0) {
        //Отправка сообщений раз в 1 час для обхода спама
        $request = R::getAll('SELECT * FROM `questions` WHERE user_email = ? ORDER BY `id` DESC', [$_SESSION['logged_user']->userEmail]);
         if($request[0]['next_date'] > date("d.m.Y, H:i:s", time())){
             $errors[] = 'Попробуйте через час';
         }
    }
    if (empty($errors)) {
        //Помещение заявки в БД
        $question = R::dispense('questions');
        $question->userName = $data['userName'];
        $question->userEmail = $_SESSION['logged_user']->userEmail;
        $question->questionText = $data['problemText'];
        $question->registrationDate = date("d.m.Y, H:i:s");
        $question->nextDate = date("d.m.Y, H:i:s", time()+60*60);
        R::store($question);
        //Формирование отправки сообщения
        $email = $data['userEmail'];
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "To: <noreply@unverified.beget.ru>\r\n";
        $headers .= "From: <$email>\r\n";
        //Формирование текста сообщения
        $message = '
                <html>
                <head>
                <title>Подтвердите Email</title>
                </head>
                <body>
                <p>Отправитель:' . $data['userName'] . '</p>
                <p>Вопрос:' . $data['problemText'] . '</p>
                </body>
                </html>
                ';
        //Отправка сообщения
        if (mail($email, "Вопрос от пользователя", $message, $headers)) {
            // Если да, то выводит сообщение
            $smsg = "Ваше обращение отправлено";
        }
    } else {
        $fsmsg = array_shift($errors);
    }
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
    <link rel="stylesheet" href="../css/signup.css">
    <link rel="stylesheet" href="../css/support.css">
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
                                <a class="nav-link active" href="about.php">О нас</a>
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
                <h2>Техническая поддержка</h2>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-4">
                </div>
                <div class="col-lg-4 col-md-6">
                    <!-- Сообщение об успехе -->
                    <?php if (isset($smsg)) { ?> <div class="alert alert-success" role="alert"> <?php echo $smsg ?> </div> <?php } ?>
                    <!-- Сообщение об ошибке -->
                    <?php if (isset($fsmsg)) { ?> <div class="alert alert-danger" role="alert"> <?php echo $fsmsg ?> </div> <?php } ?>
                    <!-- Форма отправки заявки -->
                    <form class="support-send" action="support.php" method="POST" onsubmit="if(conf()) return true; else return false">
                        <!-- Отправитель -->
                        <div class="text-field text-field_floating">
                            <input class="text-field__input" type="text" id="userName" minlength="1" name="userName" placeholder=" " value="<?php echo @$_SESSION['logged_user']->firstName ?>" required>
                            <label class="text-field__label" for="userName">Отправитель</label>
                        </div>
                        <!-- Проблема -->
                        <div class="text-field text-field_floating">
                            <input class="text-field__input" type="text" id="problemText" minlength="1" name="problemText" placeholder=" " value="<?php echo @$data['problemText'] ?>" required>
                            <label class="text-field__label" for="problemText">Опишите проблему</label>
                        </div>
                        <!-- Кнопка отправки заявки -->
                        <button class="btn" type="submit" name="send_to_support">Отправить</button>
                    </form>
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
    <!-- Подключение основных скриптов -->
    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>