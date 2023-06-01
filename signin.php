<?php
//Подключение к БД
require "db.php";
//Помещение полученных данных в переменную
$data = $_POST;
//Проверка наличия данных
if (isset($data['do_login'])) {
    //Массив ошибок
    $errors = array();
    //Поиск пользователя в базе данных
    $user = R::findOne('users', 'user_email = ?', array($data['userEmail']));
    if ($user) {
        //Проверка совпаденя паролей
        if ($user->emailConfirmed == 0) {
            $errors[] = 'Необходимо подтвердить почту';
        }
        if (password_verify($data['password'], $user->password) && empty($errors)) {
            //Авторизация пользователя
            $_SESSION['logged_user'] = $user;
            header('location: /index.php');
        } else {
            $errors[] = 'Неверный пароль!';
            //Вывод ошибок
            $fsmsg = array_shift($errors);
        }
    } else {
        $errors[] = 'Пользователь с такой почтой не найден.';
        //Вывод ошибок
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
    <link rel="stylesheet" href="../css/signin.css">
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
                    <form class="box" action="/signin.php" method="POST">
                        <!-- Заголовок страницы -->
                        <h2>Авторизация</h2>
                        <!-- Сообщение об успехе -->
                        <?php if (isset($smsg)) { ?> <div class="alert alert-success" role="alert"> <?php echo $smsg ?> </div> <?php } ?>
                        <!-- Сообщение об ошибке -->
                        <?php if (isset($fsmsg)) { ?> <div class="alert alert-danger" role="alert"> <?php echo $fsmsg ?> </div> <?php } ?>
                        <!-- Поля для авторизации -->
                        <div class="row align-items-center">
                            <!-- Email -->
                            <div class="col-lg-12">
                                <div class="text-field text-field_floating">
                                    <input class="text-field__input" type="email" id="userEmail" minlength="1" name="userEmail" placeholder=" " value="<?php echo @$data['userEmail'] ?>" required>
                                    <label class="text-field__label" for="userEmail">Email</label>
                                </div>
                            </div>
                        </div>
                        <!-- Пароль -->
                        <div class="password">
                            <div class="text-field text-field_floating">
                                <input class="text-field__input" type="password" id="password-input" name="password" placeholder=" " autocomplete="off" required>
                                <a href="#" class="password-control" onclick="return show_hide_password(this);"></a>
                                <label class="text-field__label" for="password-input">Пароль</label>
                            </div>
                        </div>
                        <!-- Кнопка отправки формы -->
                        <button class="btn" type="submit" name="do_login">Войти</button><!-- кнопка регистрации -->
                        <!-- Ссылка на регистрацию -->
                        <div class="links">
                            <a href="signup.php">Регистрация</a>
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
    <!-- Подключение скриптов дял входа -->
    <script src="js/signin.js"></script>
</body>

</html>