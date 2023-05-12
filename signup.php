<?php
require "db.php";

$data = $_POST;

if (isset($data['do_signup'])) {
    //регистрируем
    //проверка имени
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

    if (trim($data['userKpp']) == '') {
        $errors[] = 'Введите КПП!';
    }

    if (trim($data['userTel']) == '') {
        $errors[] = 'Введите Телефон!';
    }

    if (trim($data['userEmail']) == '') {
        $errors[] = 'Введите Email!';
    }

    //проверка пароля
    if ($data['password'] == '') {
        $errors[] = 'Введите пароль!';
    }
    //проверка повторного пароля
    if ($data['password_2'] != $data['password']) {
        $errors[] = 'Повторый пароль введен неверно!';
    }

    if (R::count('users', "user_inn = ?", array($data['userInn'])) > 0) {
        $errors[] = 'Пользователь с таким ИНН уже существует!';
    }
    if (R::count('users', "user_kpp = ?", array($data['userKpp'])) > 0) {
        $errors[] = 'Пользователь с таким КПП уже существует!';
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
        //добавление записи в таблицу пользователей
        $user = R::dispense('users');
        $user->role = $data['role'];
        $user->accessStatus = 1;
        $user->firstName = $data['firstName'];
        $user->lastName = $data['lastName'];
        $user->patronymicName = $data['patronymicName'];
        $user->gendername = 1;
        $user->userInn = $data['userInn'];
        $user->userKpp = $data['userKpp'];
        $user->userTel = $data['userTel'];
        $user->userEmail = $data['userEmail'];
        $user->birthdayDate = date("2004-m-d");
        $user->registrationDate = date("d.m.Y, H:i:s");
        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
        R::store($user);
        $smsg = "Регистрация прошла успешно";
    } else {
        //сообщение об ошибке
        $fsmsg = array_shift($errors);
    }
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
    <link rel="stylesheet" href="../css/signup.css">
</head>

<body>
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <div class="logo">
                        <a href="index.php" class="navbar-brand"><span class="logo-color">DOC</span>TURN</a>
                    </div>

                    <a class="nav-link" aria-current="page" href="index.php">Вернуться на главную</a>
                </div>
            </nav>
        </div>
    </header>
    <main>
        <div class="container">
            <div class="main-page">
                <div class="form">
                    <form class="box" action="/signup.php" method="POST">
                        <h2>Регистрация</h2>
                        <?php if (isset($smsg)) { ?> <div class="alert alert-success" role="alert"> <?php echo $smsg ?> </div> <?php } ?>
                        <?php if (isset($fsmsg)) { ?> <div class="alert alert-danger" role="alert"> <?php echo $fsmsg ?> </div> <?php } ?>

                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="text-field text-field_floating">
                                    <input class="text-field__input" type="text" id="lastName" minlength="1" name="lastName" placeholder=" " autocomplete="off" value="<?php echo @$data['lastName'] ?>" required>
                                    <label class="text-field__label" for="lastName">Фамилия</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="text-field text-field_floating">
                                    <input class="text-field__input" type="text" id="firstName" minlength="1" name="firstName" placeholder=" " autocomplete="off" value="<?php echo @$data['firstName'] ?>" required>
                                    <label class="text-field__label" for="firstName">Имя</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="text-field text-field_floating">
                                    <input class="text-field__input" type="text" id="patronymicName" minlength="1" name="patronymicName" placeholder=" " autocomplete="off" value="<?php echo @$data['patronymicName'] ?>" required>
                                    <label class="text-field__label" for="patronymicName">Отчество</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="text-field text-field_floating">
                                    <input class="text-field__input" type="text" id="userInn" minlength="1" name="userInn" placeholder=" " autocomplete="off" value="<?php echo @$data['userInn'] ?>" required>
                                    <label class="text-field__label" for="userInn">ИНН</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="text-field text-field_floating">
                                    <input class="text-field__input" type="text" id="userKpp" minlength="1" name="userKpp" placeholder=" " autocomplete="off" value="<?php echo @$data['userKpp'] ?>" required>
                                    <label class="text-field__label" for="userKpp">КПП</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="text-field text-field_floating">
                                    <input class="text-field__input" type="tel" id="userTel" minlength="1" name="userTel" placeholder=" " autocomplete="off" value="<?php echo @$data['userTel'] ?>" required>
                                    <label class="text-field__label" for="userTel">Телефон</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="text-field text-field_floating">
                                    <input class="text-field__input" type="email" id="userEmail" name="userEmail" placeholder=" " value="<?php echo @$data['userEmail'] ?>" required>
                                    <label class="text-field__label" for="userEmail">Email</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <select name="role">
                                    <option value="0" disabled selected>Должность</option>
                                    <option value="1">Администратор</option>
                                    <option value="2">Пользователь</option>
                                </select>
                            </div>
                        </div>
                        <div class="password">
                            <div class="text-field text-field_floating">
                                <input class="text-field__input" type="password" id="password-input" name="password" placeholder=" " autocomplete="off" required>
                                <a href="#" class="password-control" onclick="return show_hide_password(this);"></a>
                                <label class="text-field__label" for="password-input">Пароль</label>
                            </div>
                        </div>
                        <div class="password">
                            <div class="text-field text-field_floating">
                                <input class="text-field__input" type="password" id="password-input-2" name="password_2" placeholder=" " autocomplete="off" required>
                                <a href="#" class="password-control" onclick="return show_hide_password_2 (this);"></a>
                                <label class="text-field__label" for="password-input-2">Повторите пароль</label>
                            </div>
                        </div>

                        <button class="btn" type="submit" name="do_signup">Зарегистрироваться</button><!-- кнопка регистрации -->
                        <div class="links">
                            <a href="signin.php">Вход в аккаунт</a>
                        </div>
                    </form>
                </div>
            </div>
    </main>
    <footer>
        <div class="container">
            <div class="row justify-content-left">
                <div class="col-lg-5 col-md-6">
                    <p>г. Санкт-Петербург, ул. Репина, д. 5</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <p>docturn@mail.com</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <p>+7(912)333-22-11</p>
                </div>
                <div class="col-lg-1 col-md-6">
                    <div class="logo">
                        <a href="index.php" class="navbar-brand"><span class="logo-color">DOC</span><span class="main-color">TURN</span></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="js/jquery.maskedinput.min.js"></script>
    <script src="js/signup.js"></script>
    <script src="../js/jquery-3.5.1.min.js"></script>
</body>

</html>