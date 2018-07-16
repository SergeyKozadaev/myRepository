<?php include ROOT . '/views/layouts/header.php';?>

<?php if(isset($_SESSION["userId"])) : ?>
    <?php header("Location: /list/1") ; ?>
<?php else : ?>
    <?php if($result) : ?>
        <div class="alert alert-success alert-dismissible fade in">
            <a href="/login/" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Успешно!</strong> Вы были зарегистрированы на сайте.
            Пожалуйста войдите на сайт используя введенные данные.
        </div>
    <?php else : ?>
        <div class="container">
            <form method="post" action="">
                <h2>Регистрация нового пользователя</h2>
                <br>
                <div class="form-group">
                    <span class="glyphicon glyphicon-user"></span>
                    <label for="name">Логин:</label>
                    <input type="text" class="form-control" name="login" placeholder="Введите Логин" value="<?php echo $login;?>">
                </div>

                <div class="form-group">
                    <span class="glyphicon glyphicon-envelope"></span>
                    <label for="email">E-mail:</label>
                    <input type="text" class="form-control" name="email" placeholder="Введите e-mail" value="<?php echo $email;?>">
                </div>

                <div class="form-group">
                    <span class="glyphicon glyphicon-eye-close"></span>
                    <label for="password">Пароль:</label>
                    <input type="password" class="form-control" name="password" placeholder="Введите пароль, не менее 8 символов" value="<?php echo $password;?>">
                </div>

                <div class="form-group">
                    <span class="glyphicon glyphicon-eye-close"></span>
                    <label for="passwordRepeat">Повторите пароль:</label>
                    <input type="password" class="form-control" name="passwordRepeat" placeholder="Повторите пароль" value="<?php echo $passwordRepeat;?>">
                </div>

                <div class="form-group">
                    <?php if(!empty($errors)) : ?>
                        <?php foreach ($errors as $error) : ?>
                            <p class="text-warning"> <?php echo $error;?></p>
                        <?php endforeach ; ?>
                    <?php endif ; ?>
                </div>

                <div class="form-group">
                    <input type="submit" id="submit" name="submit" value="Зарегистрироваться" class="btn btn-primary">
                    <input type="submit" id="reset" name="reset" value="Очистить" class="btn btn-primary">
                </div>
            </form>
        </div>
    <?php endif ; ?>
<?php endif ; ?>

<?php include ROOT . '/views/layouts/footer.php';?>