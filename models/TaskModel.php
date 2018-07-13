<?php

const PER_PAGE = 6;

class TaskModel {

    public static function testInput($data){
        $data = trim($data); //удаление символов из начала и конца строки
        $data = stripcslashes($data);//удаление экранирующих слэшей
        $data = htmlspecialchars($data);//преобразование специальных символов
        return $data;
    }
    // возвращает строку из таблицы
    public static function getTaskById($taskId) {

        $taskId = intval($taskId);

        $pdo = Db::pdoConnection();

        $statement = $pdo->prepare(
            "SELECT worker.wId, wLogin, wEmail, tId, tName, tContactPhone, tDescription, tPhoto 
                      FROM task INNER JOIN worker 
                      ON task.wId = worker.wId
                      WHERE tId = :id");

        $statement->bindValue(':id', (int) $taskId);
        $statement->execute();
        $result = $statement->fetch((PDO::FETCH_ASSOC));

        return $result;

    }
//--------------------------------------------
    //возвращает кол-во всех записей в таблице task
    public static function getAdminTotalTasksNumder() {

        $pdo = Db::pdoConnection();

        $statement = $pdo->query("SELECT COUNT(*) as 'total' FROM task");
        $statement->setFetchMode((PDO::FETCH_ASSOC));

        $result = $statement->fetchColumn();

        return $result;

    }
    //возвращает кол-во записей в таблице task для пользователя с таким $userId
    public static function getUserTotalTasksNumder($userId) {

        $pdo = Db::pdoConnection();

        $statement = $pdo->prepare("SELECT COUNT(*) FROM task WHERE wId = :userId");
        $statement->bindValue(':userId', (int) $userId, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchColumn();

        return $result;

    }

    //возвращает необходимое кол-во записей на соответсвующую страницу
    public static function getAdminTasksList($pageNumber) {

        $offset = ($pageNumber - 1) * PER_PAGE;


        $pdo = Db::pdoConnection();

        $statement = $pdo->prepare(
            "SELECT tId, tName, tContactPhone, tDescription, wLogin
                       FROM task INNER JOIN worker 
                       ON task.wId = worker.wId 
                       ORDER BY tId DESC 
                       LIMIT :perPage 
                       OFFSET :offset");

        $statement->bindValue(':perPage', (int) PER_PAGE, PDO::PARAM_INT);
        $statement->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll((PDO::FETCH_ASSOC));

        return $result;

    }

    //возвращает необходимое кол-во записей на соответсвующую страницу
    public static function getUserTasksList($pageNumber, $userId) {

        $offset = ($pageNumber - 1) * PER_PAGE;


        $pdo = Db::pdoConnection();

        $statement = $pdo->prepare(
            "SELECT tId, tName, tContactPhone, tDescription, wLogin
                       FROM task INNER JOIN worker 
                       ON task.wId = worker.wId
                       WHERE task.wId = :userId
                       ORDER BY tId DESC 
                       LIMIT :perPage 
                       OFFSET :offset");
        $statement->bindValue(':userId', (int) $userId, PDO::PARAM_INT);
        $statement->bindValue(':perPage', (int) PER_PAGE, PDO::PARAM_INT);
        $statement->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll((PDO::FETCH_ASSOC));

        return $result;

    }


//--------------------------------------------
    public static function checkName($name) {
        if(strlen($name) > 4) {
            return true;
        }

        return false;

    }

    public static function checkContactPhone($contactPhone) {
        $pattern = '^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$';

        if(preg_match("~$pattern~", $contactPhone)) {
            return true;
        }

        return false;

    }

    public static function checkDescription($description) {
        if(strlen($description) > 10) {
            return true;
        }

        return false;
    }

    public static function createNewTask($taskName, $contactPhone, $description, $photoPath) {

        if($_SESSION['userId']) {

            $userId = $_SESSION ['userId'];

            $pdo = Db::pdoConnection();

            $statement = $pdo->prepare(
                "INSERT INTO task (wId, tName, tContactPhone, tDescription, tPhoto)
                       VALUES (:userId, :taskName, :contactPhone, :Description, :photo)");

            $statement->bindValue(':userId', (int) $userId);

            $statement->bindValue(':taskName', (string) $taskName);

            $statement->bindValue(':contactPhone', (string) $contactPhone);

            $statement->bindValue(':Description', (string) $description);

            $statement->bindValue(':photo', (string) $photoPath);

            if($statement->execute()) {

                $lastTaskId = $pdo->lastInsertId();

                $_SESSION['lastTaskId'] = $lastTaskId;

                return $lastTaskId;
            }

        }

        return false;


    }

    public static function uploadImage() {

        //по-хорошему надо проверять еще имя файла(длина и досутпные символы)
        if($_FILES['photo']['error'] == UPLOAD_ERR_OK) {

            //$tmpName = $_FILES['photo']['tmp_name'];
            $newName = hash("md5", time());
            $_FILES['photo']['name'] = $newName;
            $uploadDir = '/lib/taskPhotos/';
            $uploadFile = $uploadDir . basename($_FILES['photo']['name']);


            if (move_uploaded_file($_FILES['photo']['tmp_name'],ROOT . $uploadFile)) {
                return $uploadFile;
            }



        }

        return false;



    }
}