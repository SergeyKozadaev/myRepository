<?php include ROOT . '/views/layouts/header.php';?>

<?php if(empty($_SESSION)) : ?>
    <?php header("Location: /");?>
<?php endif ; ?>

    <div class="container">
        <form enctype="multipart/form-data" method="post" action="">
            <h2>Создание новой заявки</h2>
            <br>
            <div class="form-group" >
                <span class="glyphicon glyphicon-pencil"></span>
                <label for="name">Название</label>
                <input type="text" class="form-control" name="name" placeholder="Введите название заявки" value="<?php echo $name;?>">
            </div>

            <div class="form-group">
                <span class="glyphicon glyphicon-phone"></span>
                <label for="contactPhone">Контактный телефон</label>
                <input type="text" class="form-control" name="contactPhone" placeholder="Введите номер телефона для связи" value="<?php echo $contactPhone;?>">
            </div>

            <div class="form-group">
                <span class="glyphicon glyphicon-pencil"></span>
                <label for="description">Описание</label>
                <textarea class="form-control" rows="5" name="description" placeholder="Постарайтесь доходчиво описать проблему"><?php echo $description;?></textarea>
            </div>

            <div class="form-group">
                <span class="glyphicon glyphicon-download"></span>
                <label for="photo">Фото (по желанию)</label>
                <input type="file" name="photo" multiple accept="image/*">
            </div>

            <div class="form-group">
                <?php if(!empty($errors)) : ?>
                    <?php foreach ($errors as $error) : ?>
                        <p class="text-warning"><?php echo $error; ?></p>
                    <?php endforeach ; ?>
                <?php endif ; ?>
            </div>

            <div class="form-group">
                <input type="submit" id="submit" name="submit" value="Сохранить" class="btn btn-primary">
                <input type="submit" id="reset" name="reset" value="Очистить" class="btn btn-primary">
            </div>
        </form>
    </div>

<?php include ROOT . '/views/layouts/footer.php';?>