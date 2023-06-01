<?php
//Подключение к БД
require "db.php";
//Помещение полученных данных в переменную
$data = $_POST;
//Проверка наличия данных
if (isset($data['do_signup'])) {
    //Регистрируем
    //Проверка имени
    if (trim($data['lastName']) == '') {
        $errors[] = 'Введите Фамилию!';
    }
    if (trim($data['firstName']) == '') {
        $errors[] = 'Введите Имя!';
    }
    if (trim($data['patronymicName']) == '') {
        $errors[] = 'Введите Отчество!';
    }
    if (trim($data['userInn']) == '') {
        $errors[] = 'Введите ИНН!';
    }
    if (trim($data['userTel']) == '') {
        $errors[] = 'Введите Телефон!';
    }
    if (trim($data['userEmail']) == '') {
        $errors[] = 'Введите Email!';
    }
    //Проверка пароля
    if ($data['password'] == '') {
        $errors[] = 'Введите пароль!';
    }
    //Проверка повторного пароля
    if ($data['password_2'] != $data['password']) {
        $errors[] = 'Повторый пароль введен неверно!';
    }
    if (R::count('users', "user_inn = ?", array($data['userInn'])) > 0) {
        $errors[] = 'Пользователь с таким ИНН уже существует!';
    }
    if (R::count('users', "user_tel = ?", array($data['userTel'])) > 0) {
        $errors[] = 'Пользователь с таким номером уже существует!';
    }
    if (R::count('users', "user_email = ?", array($data['userEmail'])) > 0) {
        $errors[] = 'Пользователь с таким email уже существует!';
    }
    if (empty($errors)) {
        if ($data['role'] == 0) {
            $data['role'] = 2;
        }
        $inn = $data['userInn'];
        $email = $data['userEmail'];
        //Формирование хэша для дальнейшего подтверждения
        $hash = md5($inn . time());
        //Формирование сообщения на почту
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "To: <$email>\r\n";
        $headers .= "From: <docturn@business.com>\r\n";
        //Формирование текста сообщения
        $message = '
                <html>
                <head>
                <title>Подтвердите Email</title>
                </head>
                <body>
                <p>Что бы подтвердить Email, перейдите по <a href="http://docturn/confirmed.php?hash=' . $hash . '">ссылке</a></p>
                </body>
                </html>
                ';
        //Отправка сообщения на почту
        if (mail($email, "Подтвердите Email на сайте", $message, $headers)) {
            // Если да, то выводит сообщение
            $smsg = "Необходимо подтверждение почты.";
        }
        //Добавление записи в таблицу пользователей
        $user = R::dispense('users');
        $user->role = $data['role'];
        $user->emailConfirmed = 0;
        $user->accessStatus = 1;
        $user->firstName = $data['firstName'];
        $user->lastName = $data['lastName'];
        $user->patronymicName = $data['patronymicName'];
        $user->gendername = 1;
        $user->userInn = $data['userInn'];
        $user->userTel = $data['userTel'];
        $user->userEmail = $data['userEmail'];
        $user->birthdayDate = date("2004-m-d");
        $user->registrationDate = date("d.m.Y, H:i:s");
        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
        $user->hash = $hash;
        $user->sortSettings = 0;
        R::store($user);
    } else {
        //сообщение об ошибке
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
                    <!-- Ссылка на главную -->
                    <a class="nav-link" aria-current="page" href="index.php">Вернуться на главную</a>
                </div>
            </nav>
        </div>
    </header>
    <!-- Конец шапки страницы -->
    <!-- Главная информация страницы -->
    <main>
        <!-- Главный контейнер -->
        <div class="container">
            <div class="main-page">
                <div class="form">
                    <form class="box" action="/signup.php" method="POST">
                        <!-- Заголовок страницы -->
                        <h2>Регистрация</h2>
                        <!-- Сообщение об успехе -->
                        <?php if (isset($smsg)) { ?> <div class="alert alert-success" style="color: #51510f; background-color:#e6e7d1; border:1px solid #dbdaba" role="alert"> <?php echo $smsg ?> </div> <?php } ?>
                        <!-- Сообщение об ошибке -->
                        <?php if (isset($fsmsg)) { ?> <div class="alert alert-danger" role="alert"> <?php echo $fsmsg ?> </div> <?php } ?>
                        <!-- Поля для авторизации -->
                        <div class="row justify-content-center">
                            <!-- Фамилия -->
                            <div class="col-lg-12">
                                <div class="text-field text-field_floating">
                                    <input class="text-field__input" type="text" id="lastName" minlength="1" name="lastName" placeholder=" " autocomplete="off" value="<?php echo @$data['lastName'] ?>" required>
                                    <label class="text-field__label" for="lastName">Фамилия</label>
                                </div>
                            </div>
                            <!-- Имя -->
                            <div class="col-lg-12">
                                <div class="text-field text-field_floating">
                                    <input class="text-field__input" type="text" id="firstName" minlength="1" name="firstName" placeholder=" " autocomplete="off" value="<?php echo @$data['firstName'] ?>" required>
                                    <label class="text-field__label" for="firstName">Имя</label>
                                </div>
                            </div>
                            <!-- Отчество -->
                            <div class="col-lg-12">
                                <div class="text-field text-field_floating">
                                    <input class="text-field__input" type="text" id="patronymicName" minlength="1" name="patronymicName" placeholder=" " autocomplete="off" value="<?php echo @$data['patronymicName'] ?>" required>
                                    <label class="text-field__label" for="patronymicName">Отчество</label>
                                </div>
                            </div>
                            <!-- ИНН -->
                            <div class="col-lg-12">
                                <div class="text-field text-field_floating">
                                    <input class="text-field__input" type="text" id="userInn" minlength="1" name="userInn" placeholder=" " autocomplete="off" value="<?php echo @$data['userInn'] ?>" required>
                                    <label class="text-field__label" for="userInn">ИНН</label>
                                </div>
                            </div>
                            <!-- Телефон -->
                            <div class="col-lg-12">
                                <div class="text-field text-field_floating">
                                    <input class="text-field__input" type="tel" id="userTel" minlength="1" name="userTel" placeholder=" " autocomplete="off" value="<?php echo @$data['userTel'] ?>" required>
                                    <label class="text-field__label" for="userTel">Телефон</label>
                                </div>
                            </div>
                            <!-- Email -->
                            <div class="col-lg-12">
                                <div class="text-field text-field_floating">
                                    <input class="text-field__input" type="email" id="userEmail" name="userEmail" placeholder=" " value="<?php echo @$data['userEmail'] ?>" required>
                                    <label class="text-field__label" for="userEmail">Email</label>
                                </div>
                            </div>
                            <!-- Список должностей -->
                            <div class="col-lg-12">
                                <select name="role">
                                    <option value="0" disabled selected>Должность</option>
                                    <option value="1">Администратор</option>
                                    <option value="2">Пользователь</option>
                                </select>
                            </div>
                        </div>
                        <!-- Пароль 1 -->
                        <div class="password">
                            <div class="text-field text-field_floating">
                                <input class="text-field__input" type="password" id="password-input" name="password" placeholder=" " autocomplete="off" required>
                                <a href="#" class="password-control" onclick="return show_hide_password(this);"></a>
                                <label class="text-field__label" for="password-input">Пароль</label>
                            </div>
                        </div>
                        <!-- Пароль 2 -->
                        <div class="password">
                            <div class="text-field text-field_floating">
                                <input class="text-field__input" type="password" id="password-input-2" name="password_2" placeholder=" " autocomplete="off" required>
                                <a href="#" class="password-control" onclick="return show_hide_password_2 (this);"></a>
                                <label class="text-field__label" for="password-input-2">Повторите пароль</label>
                            </div>
                        </div>
                        <!-- Кнопка регистрации -->
                        <button class="btn" type="submit" name="do_signup">Зарегистрироваться</button>
                        <div class="links">
                            <!-- Кнопка входа -->
                            <a href="signin.php">Вход в аккаунт</a>
                        </div>
                    </form>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <!-- Подключение скриптов ввода -->
    <script src="js/jquery.maskedinput.min.js"></script>
    <!-- Подключение скриптов для входа -->
    <script src="js/signup.js"></script>
    <!-- Подключение библиотеки jquery -->
    <script src="../js/jquery-3.5.1.min.js"></script>
</body>
</html>