<?php include_once ROOT . '/views/layouts/header.php';?>

    <div class="container">
        <form method="" action="">
            <h2>Просмотр заявки</h2>
            <br>
            <div class="form-group" >
                <span class="glyphicon glyphicon-pencil"></span>
                <label>Номер заявки</label>
                <input type="text" class="form-control" value="<?php echo $taskItem['tId'];?>" disabled>
            </div>

            <div class="form-group" >
                <span class="glyphicon glyphicon-pencil"></span>
                <label>Название</label>
                <input type="text" class="form-control" value="<?php echo $taskItem['tName'];?>" disabled>
            </div>

            <div class="form-group" >
                <span class="glyphicon glyphicon-pencil"></span>
                <label>Пользователь</label>
                <input type="text" class="form-control" value="<?php echo $taskItem['wLogin'];?>" disabled>
            </div>

            <div class="form-group" >
                <span class="glyphicon glyphicon-phone"></span>
                <label>Контактный телефон:</label>
                <input type="text" class="form-control" value="<?php echo $taskItem['tContactPhone'];?>" disabled>
            </div>

            <div class="form-group">
                <span class="glyphicon glyphicon-pencil"></span>
                <label>Описание</label>
                <textarea class="form-control" rows="5" disabled> <?php echo $taskItem['tDescription'];?> </textarea>
            </div>

            <div class="form-group">
                <span class="glyphicon glyphicon-picture"></span>
                <label>Фото</label>
                <img src="<?php echo $taskItem['tPhoto'];?>" class="img-rounded img-responsive" alt="No photo" width="300">
            </div>
        </form>
    </div>

<?php include_once ROOT . '/views/layouts/footer.php';?>
