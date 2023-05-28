<?php
require "db.php";
$data = $_POST;

var_dump($data['userEmail']);

if (isset($data['send_to_support'])) {
    if (trim($data['userName']) == '') {
        $errors[] = 'Как к Вам обращаться?';
    }


    if (trim($data['problemText']) == '') {
        $errors[] = 'Укажите проблему';
    }

    if (R::count('questions', "user_email = ?", array($_SESSION['logged_user']->userEmail)) > 0) {
        $request = R::getAll('SELECT * FROM `questions` WHERE user_email = ? ORDER BY `id` DESC', [$_SESSION['logged_user']->userEmail]);
        
        var_dump($request[0]);
        var_dump($request[0]['next_date']);
        var_dump(date("d.m.Y, H:i:s", time()));
         if($request[0]['next_date'] > date("d.m.Y, H:i:s", time())){
             $errors[] = 'Попробуйте через час';
         }
        
    }

    if (empty($errors)) {


        $question = R::dispense('questions');
        $question->userName = $data['userName'];
        $question->userEmail = $_SESSION['logged_user']->userEmail;
        $question->questionText = $data['problemText'];
        $question->registrationDate = date("d.m.Y, H:i:s");
        $question->nextDate = date("d.m.Y, H:i:s", time()+60*60);
        R::store($question);

        $email = $data['userEmail'];
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "To: <$email>\r\n";
        $headers .= "From: <docturn@business.com>\r\n";

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
        if (mail($email, "Вопрос от пользователя", $message, $headers)) {
            // Если да, то выводит сообщение
            $smsg = "Ваше обращение отправлено";
        }
        unset($data);
    } else {
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
    <link rel="stylesheet" href="../css/support.css">
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
                                <a class="nav-link active" href="contacts.php">Контакты</a>
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
                <h2>Техническая поддержка</h2>
            </div>
            <div class="row align-items-center">

                <div class="col-lg-4">

                </div>
                <div class="col-lg-4 col-md-6">
                    <?php if (isset($smsg)) { ?> <div class="alert alert-success" role="alert"> <?php echo $smsg ?> </div> <?php } ?>
                    <?php if (isset($fsmsg)) { ?> <div class="alert alert-danger" role="alert"> <?php echo $fsmsg ?> </div> <?php } ?>
                    <form class="support-send" action="support.php" method="POST" onsubmit="if(conf()) return true; else return false">
                        <div class="text-field text-field_floating">
                            <input class="text-field__input" type="text" id="userName" minlength="1" name="userName" placeholder=" " value="<?php echo @$_SESSION['logged_user']->firstName ?>" required>
                            <label class="text-field__label" for="userName">Отправитель</label>
                        </div>
                        <div class="text-field text-field_floating">
                            <input class="text-field__input" type="text" id="problemText" minlength="1" name="problemText" placeholder=" " value="<?php echo @$data['problemText'] ?>" required>
                            <label class="text-field__label" for="problemText">Опишите проблему</label>
                        </div>
                        <button class="btn" type="submit" name="send_to_support">Отправить</button>
                    </form>
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
                        <a class="support" href="#">Техническая поддержка</a>
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