<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="/lib/js/jquery.min.js"></script>
        <link href="/lib/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <script src="/lib/js/bootstrap.min.js"></script>

        <title>HelpDesk</title>
    </head>

    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand">HelpDesk</a>
                </div>

                    <?php if(empty($_SESSION)) : ?>

                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="/login"><span class="glyphicon glyphicon-log-in"></span> Войти </a></li>
                            <li><a href="/register"><span class="glyphicon glyphicon-user"></span> Зарегистрироваться </a></li>
                        </ul>

                    <?php else : ?>

                        <ul class="nav navbar-nav">
                            <li><a href="/list/1">Список заявок</a></li>
                            <li><a href="/new">Новая заявка</a></li>
                            <?php if($_SESSION["adminFlag"]) : ?>
                                <li><a href="/downloadXML">Скачать БД в XML</a></li>
                            <?php endif ; ?>
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="" class="disabled"><span class="glyphicon glyphicon-user"></span> Вы вошли как: <?php echo $_SESSION["userName"] ?> </a></li>
                            <li><a href="/logout"><span class="glyphicon glyphicon-log-out"></span> Выйти </a></li>
                        </ul>

                    <?php endif; ?>
            </div>



        </nav>
