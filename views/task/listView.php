<?php include_once ROOT . '/views/layouts/header.php';?>

<div class="container-fluid">
    <h2>Список заявок:</h2>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Номер заявки</th>
            <th>Пользователь</th>
            <th>Проблема</th>
            <th>Описание</th>
            <th>Контактный телефон</th>
            <th></th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($taskList as $array):?>
            <?php if (!empty($_SESSION['lastTaskId']) && $array['tId'] == $_SESSION['lastTaskId']):?>
                <tr class="success">
            <?php else:?>
                <tr>
            <?php endif;?>

            <td class="col-lg-1"> <?php echo $array['tId'];?></td>
            <td class="col-lg-1"> <?php echo $array['wLogin'];?></td>
            <td class="col-lg-1"> <?php echo $array['tName'];?></td>
            <td class="col-lg-3"> <?php echo $array['tDescription'];?></td>
            <td class="col-lg-3"> <?php echo $array['tContactPhone'];?></td>
            <td>
                <p class="links" > <a href="/show/<?php echo $array['tId'];?>">Открыть</a> </p>
            </td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>

<div align="center">
    <ul class="pagination">
        <?php for ($i = 1; $i <= $pageTotal; $i++):?>
            <li <?php if ($i == $pageNumber) echo 'class="active"'?>>
                <a href="/list/<?php echo $i ?>"><?php echo $i ?></a>
            </li>
        <?php endfor;?>
    </ul>
</div>

<?php include_once ROOT . '/views/layouts/footer.php';?>