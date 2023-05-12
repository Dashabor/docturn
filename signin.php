<?php
require "db.php";

$data = $_POST;
if (isset($data['do_login'])) {
    //массив ошибок
    $errors = array();
    //поиск пользователя в базе данных
    $user = R::findOne('users', 'user_email = ?', array($data['userEmail']));
    if ($user) {
        //проверка совпаденя паролей
        if (password_verify($data['password'], $user->password)) {
            $_SESSION['logged_user'] = $user;
            header('location: /index.php');
        } else {
            $errors[] = 'Неверный пароль!';
            //вывод ошибок
            $fsmsg = array_shift($errors);
        }
    } else {
        $errors[] = 'Пользователь с такой почтой не найден.';
        //вывод ошибок
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
    <link rel="stylesheet" href="../css/signin.css">
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
                    <form class="box" action="/signin.php" method="POST">
                        <h2>Авторизация</h2>
                        <?php if (isset($smsg)) { ?> <div class="alert alert-success" role="alert"> <?php echo $smsg ?> </div> <?php } ?>
                        <?php if (isset($fsmsg)) { ?> <div class="alert alert-danger" role="alert"> <?php echo $fsmsg ?> </div> <?php } ?>

                        <div class="row align-items-center">
                            <div class="col-lg-12">
                                <div class="text-field text-field_floating">
                                    <input class="text-field__input" type="email" id="userEmail" minlength="1" name="userEmail" placeholder=" " value="<?php echo @$data['userEmail'] ?>" required>
                                    <label class="text-field__label" for="userEmail">Email</label>
                                </div>
                            </div>
                        </div>
                        <div class="password">
                            <div class="text-field text-field_floating">
                                <input class="text-field__input" type="password" id="password-input" name="password" placeholder=" " autocomplete="off" required>
                                <a href="#" class="password-control" onclick="return show_hide_password(this);"></a>
                                <label class="text-field__label" for="password-input">Пароль</label>
                            </div>
                        </div>
                        <button class="btn" type="submit" name="do_login">Войти</button><!-- кнопка регистрации -->
                        <div class="links">
                            <a href="signup.php">Регистрация</a>
                        </div>
                    </form>
                </div>
            </div>
    </main>
    <footer>
        <div class="container">
            <div class="row justify-content-center">
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
    <script src="js/signin.js"></script>
</body>

</html>