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
    <link rel="stylesheet" href="../css/cabinet.css">
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
                                    <a class="nav-link" href="documents.php#content-1">Документы</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">Личный кабинет</a>
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
            <div class="page-title">
                <h2>Личный кабинет</h2>
            </div>

            <div class="cabinet">
                <h3>ФИО</h3><!-- Заголовок -->
                <?php if (isset($smsg)) { ?> <div class="alert alert-success" role="alert"> <?php echo $smsg ?> </div> <?php } ?>
                <!-- Сообщение об успехе -->
                <?php if (isset($fsmsg)) { ?> <div class="alert alert-danger" role="alert"> <?php echo $fsmsg ?> </div> <?php } ?>
                <!-- Сообщение об ошибке -->
                <form action="save_changes.php" method="post">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="text-field text-field_floating">
                                <input class="text-field__input" type="text" minlength="1" id="lastName" name="lastName" placeholder=" " autocomplete="off" value="<?php echo $_SESSION['logged_user']->lastName ?>" required>
                                <label class="text-field__label" for="lastName">Фамилия</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="text-field text-field_floating">
                                <input class="text-field__input" type="text" minlength="1" id="firstName" name="firstName" placeholder=" " autocomplete="off" value="<?php echo $_SESSION['logged_user']->firstName ?>" required>
                                <label class="text-field__label" for="firstName">Имя</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="text-field text-field_floating">
                                <input class="text-field__input" type="text" id="patronymicName" name="patronymicName" placeholder=" " autocomplete="off" value="<?php echo $_SESSION['logged_user']->patronymicName ?>" required>
                                <label class="text-field__label" for="patronymicName">Отчество</label>
                            </div>
                        </div>
                    </div>




                    <div class="row date">
                        <div class="col-lg-2 col-md-3">
                            <h3>Пол</h3>
                            <label class="rad-label">
                                <input type="radio" class="rad-input" name="gender" value="1" <?php if ($_SESSION['logged_user']->gendername == 1) : ?> checked <?php endif ?>>
                                <div class="rad-design"></div>
                                <div class="rad-text">Мужчина</div>
                            </label>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <h3 class="hide">а</h3>
                            <label class="rad-label">
                                <input type="radio" class="rad-input" name="gender" value="2" <?php if ($_SESSION['logged_user']->gendername == 2) : ?> checked <?php endif ?>>
                                <div class="rad-design"></div>
                                <div class="rad-text">Женщина</div>
                            </label>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <!-- <div class="birthday-date">
                                <select name="birthdayDay" size="1" class="day birthday" id="day">
                                    <?php
                                    $day = $_SESSION['logged_user']->birthdayDay;
                                    ?>

                                    <?php
                                    for ($i = 1; $i < 32; $i++) {
                                        if ($i < 10)
                                            $i = "0" . $i;
                                        if ($i == $day) {
                                            echo '<option value="' . $i . '" selected> ' . $i . '</option>';
                                        } else
                                            echo '<option value="' . $i . '"> ' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                                <select name="birthdayMonth" size="1" class="month birthday" id="month">
                                    <?php $month = $_SESSION['logged_user']->birthdayMonth ?>
                                    <option value="<?php if ($month == "01") {
                                                        echo $month;
                                                    } else echo "01" ?>" <?php if ($month == "01") : ?> selected<?php endif; ?>><?php echo "Январь" ?>
                                    </option>
                                    <option value="<?php if ($month == "02") {
                                                        echo $month;
                                                    } else echo "02" ?>" <?php if ($month == "02") : ?> selected<?php endif; ?>><?php echo "Февраль" ?></option>
                                    <option value="<?php if ($month == "03") {
                                                        echo $month;
                                                    } else echo "03" ?>" <?php if ($month == "03") : ?> selected<?php endif; ?>><?php echo "Март" ?></option>
                                    <option value="<?php if ($month == "04") {
                                                        echo $month;
                                                    } else echo "04" ?>" <?php if ($month == "04") : ?> selected<?php endif; ?>><?php echo "Апрель" ?></option>
                                    <option value="<?php if ($month == "05") {
                                                        echo $month;
                                                    } else echo "05" ?>" <?php if ($month == "05") : ?> selected<?php endif; ?>><?php echo "Май" ?></option>
                                    <option value="<?php if ($month == "06") {
                                                        echo $month;
                                                    } else echo "06" ?>" <?php if ($month == "06") : ?> selected<?php endif; ?>><?php echo "Июнь" ?></option>
                                    <option value="<?php if ($month == "07") {
                                                        echo $month;
                                                    } else echo "07" ?>" <?php if ($month == "07") : ?> selected<?php endif; ?>><?php echo "Июль" ?></option>
                                    <option value="<?php if ($month == "08") {
                                                        echo $month;
                                                    } else echo "08" ?>" <?php if ($month == "08") : ?> selected<?php endif; ?>><?php echo "Август" ?></option>
                                    <option value="<?php if ($month == "09") {
                                                        echo $month;
                                                    } else echo "09" ?>" <?php if ($month == "09") : ?> selected<?php endif; ?>><?php echo "Сентрябрь" ?></option>
                                    <option value="<?php if ($month == "10") {
                                                        echo $month;
                                                    } else echo "10" ?>" <?php if ($month == "10") : ?> selected<?php endif; ?>><?php echo "Октябрь" ?></option>
                                    <option value="<?php if ($month == "11") {
                                                        echo $month;
                                                    } else echo "11" ?>" <?php if ($month == "11") : ?> selected<?php endif; ?>><?php echo "Ноябрь" ?></option>
                                    <option value="<?php if ($month == "12") {
                                                        echo $month;
                                                    } else echo "12" ?>" <?php if ($month == "12") : ?> selected<?php endif; ?>><?php echo "Декабрь" ?></option>
                                </select>
                                <select name="birthdayYear" class="year birthday" id="year">
                                    <?php
                                    $year = $_SESSION['logged_user']->birthdayYear;
                                    ?>

                                    <?php
                                    for ($i = 1960; $i < 2005; $i++) {
                                        if ($i == $year) {
                                            echo '<option value="' . $i . '" selected> ' . $i . '</option>';
                                        } else
                                            echo '<option value="' . $i . '"> ' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                            </div> -->
                            <h3>Дата рождения</h3>
                            <?php
                            $date = date("2004-m-d");
                            $userDate = $_SESSION['logged_user']->birthdayDate;
                            ?>
                            <div>
                                <input type="date" id="start" class="calendar" name="birthdayDate" value="<?php echo $userDate ?>" min="1960-01-01" max="<?php echo $date ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <h3>Email</h3>
                            <div class="text-field text-field_floating">
                                <input class="text-field__input" type="email" id="userEmail" name="userEmail" placeholder=" " autocomplete="off" value="<?php echo $_SESSION['logged_user']->userEmail ?>" required>
                                <label class="text-field__label" for="userEmail">Email</label>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <h3>Телефон</h3>
                            <div class="text-field text-field_floating">
                                <input class="text-field__input" type="tel" id="userTel" name="userTel" placeholder=" " autocomplete="off" value="<?php echo $_SESSION['logged_user']->userTel ?>" required>
                                <label class="text-field__label" for="userTel">Телефон</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-lg-3">
                            <h3>ИНН</h3>
                            <div class="text-field text-field_floating">
                                <input class="text-field__input" type="text" id="userInn" name="userInn" placeholder=" " autocomplete="off" value="<?php echo $_SESSION['logged_user']->userInn ?>" required>
                                <label class="text-field__label" for="userInn">ИНН</label>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <h3>КПП</h3>
                            <div class="text-field text-field_floating">
                                <input class="text-field__input" type="text" id="userKpp" name="userKpp" placeholder=" " autocomplete="off" value="<?php echo $_SESSION['logged_user']->userKpp ?>" required>
                                <label class="text-field__label" for="userKpp">КПП</label>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <h3>Должность</h3>
                            <div class="text-field text-field_floating">
                                <input disabled class="text-field__input" type="text" id="userRole" name="userRole" placeholder=" " autocomplete="off" value="<?php
                                                                                                                                                                if ($_SESSION['logged_user']->role == 1) echo "Администратор";
                                                                                                                                                                if ($_SESSION['logged_user']->role == 2) echo "Пользователь";
                                                                                                                                                                ?>" required>
                                <label class="text-field__label" for="userRole">Должность</label>
                            </div>
                        </div>
                    </div><br>
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-12">
                            <button class="btn" type="submit" name="save_changes">Сохранить</button> <!-- кнопка сохранения-->
                            <a class="cancel-link" href="cabinet.php">Отменить</a> <!-- кнопка отмены -->
                        </div>
                    </div>
                </form>
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
                        <a href="index.php" class="navbar-brand"><span class="logo-color">DOC</span><span class="main-color">TURN</span></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="js/calendar.js">

    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="js/jquery.maskedinput.min.js"></script>
    <script src="js/signup.js"></script>
    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>