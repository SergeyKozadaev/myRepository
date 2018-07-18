<?php include_once ROOT . '/views/layouts/header.php';?>

    <?php if ($result):?>
        <p class="text-success">Вы были успешно авторизованы</p>
    <?php else:?>
        <div class="container">
            <form method="post" action="">
                <h2>Вход в систему</h2>
                <br>
                <div class="form-group">
                    <span class="glyphicon glyphicon-envelope"></span>
                    <label for="email">E-mail:</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Введите e-mail" value="<?php echo $email;?>">
                </div>

                <div class="form-group">
                    <span class="glyphicon glyphicon-eye-close"></span>
                    <label for="password">Пароль:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Введите пароль, не менее 8 символов" value="<?php echo $password;?>">
                </div>

                <div class="form-group">
                    <?php if (!empty($errors)):?>
                        <?php foreach ($errors as $error):?>
                            <p class="text-warning"> <?php echo $error ?></p>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>

                <div class="form-group">
                    <input type="submit" id="submit" name="submit" value="Войти" class="btn btn-primary">
                    <input type="submit" id="reset" name="reset" value="Очистить" class="btn btn-primary">
                </div>
            </form>
        </div>
    <?php endif;?>

<?php include_once ROOT . '/views/layouts/footer.php';?>