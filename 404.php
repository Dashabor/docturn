<?php
header("HTTP/1.0 404 Not Found");
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
    <link rel="stylesheet" href="../css/404.css">

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
            <div class="page-title">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12">
                        <p> <b>404</b></p>
                        <p>Ошибка!</p>
                        <p>К сожалению, запрашиваемая Вами страница не найдена...
                        </p>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <img src="img/404.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="container">
            <div class="row justify-content-center">
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
                        <a href="#" class="navbar-brand"><span class="logo-color">DOC</span><span class="main-color">TURN</span></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>