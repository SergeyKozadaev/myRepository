<?php include ROOT . '/views/layouts/header.php';?>

<?php if(empty($_SESSION)) : ?>
    <?php header("Location: /");?>
<?php endif ; ?>

<?php if($_SESSION["adminFlag"] || $taskItem['wId'] == $_SESSION['userId']) : ?>
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

<?php else : ?>
    <?php header("Location: /list/1");?>
<?php endif ; ?>











<?php include ROOT . '/views/layouts/footer.php';?>
