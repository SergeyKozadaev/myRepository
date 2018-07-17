<?php
//записей на страниц
const PER_PAGE = 6;
const LIMIT_BYTES = 1024 * 1024 * 2;
const PHOTO_PATH = '/lib/taskPhotos/';
const XML_PATH = '/lib/XML/';

class TaskModel
{
    // получает задачу из БД по ее id
    public static function getTaskById($taskId)
    {
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
    //возвращает кол-во всех записей в таблице task
    public static function getAdminTotalTasksNumder()
    {
        $pdo = Db::pdoConnection();
        $statement = $pdo->query("SELECT COUNT(*) as 'total' FROM task");
        $statement->setFetchMode((PDO::FETCH_ASSOC));
        $result = $statement->fetchColumn();
        return $result;
    }
    //возвращает кол-во записей в таблице task для пользователя с таким $userId
    public static function getUserTotalTasksNumder($userId)
    {
        $pdo = Db::pdoConnection();
        $statement = $pdo->prepare("SELECT COUNT(*) FROM task WHERE wId = :userId");
        $statement->bindValue(':userId', (int) $userId, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchColumn();
        return $result;
    }
    //для Администратора, выводит список записей всех пользователей
    //возвращает необходимое кол-во записей на соответсвующую страницу
    public static function getAdminTasksList($pageNumber)
    {
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
    //для Пользователя, выводит список записей ля пользователя с таким $userId
    //возвращает необходимое кол-во записей на соответсвующую страницу
    public static function getUserTasksList($pageNumber, $userId)
    {
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
    //создает XML-файл, в который экспортирует базу заявок из БД
    public static function getAllTasksListXML()
    {
        $pdo = Db::pdoConnection();
        $statement = $pdo->prepare(
            "SELECT task.wId, wLogin, tId, tName, tContactPhone, tDescription, tPhoto
                       FROM task INNER JOIN worker 
                       ON task.wId = worker.wId 
                       ORDER BY tId DESC");
        $statement->execute();
        $result = $statement->fetchAll((PDO::FETCH_ASSOC));
        $filename = "export_xml_".date("Y-m-d_H-i",time()).".xml";
        $dom = new DOMDocument('1.0','utf-8');
        $dom->preserveWhiteSpace = FALSE;
        $table = $dom->appendChild($dom->createElement('table'));
        foreach($result as $row) {
            $data = $dom->createElement('row');
            $table->appendChild($data);
            foreach($row as $name => $value) {
                $col = $dom->createElement('column', $value);
                $data->appendChild($col);
                $colattribute = $dom->createAttribute('name');
                $colattribute->value = $name;
                $col->appendChild($colattribute);
            }
        }
        $dom->formatOutput = true;
        $filePath = ROOT . XML_PATH . $filename;
        $dom->save($filePath);
        return $filePath;
    }
    //Проверка выполнения требований для введенной строки name
    public static function checkName($name)
    {
        if(strlen($name) > 4) {
            return true;
        }
        return false;
    }
    //Проверка выполнения требований для введенной строки contactPhone
    public static function checkContactPhone($contactPhone)
    {
        //паттерн регулярного выражения для номера телефона
        $pattern = '^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$';
        if(preg_match("~$pattern~", $contactPhone)) {
            return true;
        }
        return false;
    }
    //Проверка выполнения требований для введенной строки Description
    public static function checkDescription($description)
    {
        if(strlen($description) > 10) {
            return true;
        }
        return false;
    }
    //добавляет в БД новую заявку, использую введенные пользователем данные
    public static function createNewTask($userId, $taskName, $contactPhone, $description, $photoPath)
    {
        $userId = $userId;
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
            return $lastTaskId;
        }
        return false;
    }
    //проверяем тип фото, его размер, загружаем фото на сервер, при этом переименовываем его - хэш от времени
    public static function uploadImage()
    {
        $fi = finfo_open(FILEINFO_MIME_TYPE);
        $mime = (string)finfo_file($fi, $_FILES['photo']['tmp_name']);
        var_dump($mime);
        finfo_close($fi);
        //проверка на содержание image в mime
        if (strpos($mime, 'image') === false) {
            return false;
        }
        //проверка на превышение допустимого размера
        if(filesize($_FILES['photo']['tmp_name']) > LIMIT_BYTES){
            return false;
        }
        // переименовываем и загружаем фото на сервер
        if($_FILES['photo']['error'] == UPLOAD_ERR_OK) {
            $newName = hash("md5", time());
            $_FILES['photo']['name'] = $newName;
            $uploadFile = PHOTO_PATH . basename($_FILES['photo']['name']);
            if (move_uploaded_file($_FILES['photo']['tmp_name'],ROOT . $uploadFile)) {
                return $uploadFile;
            }
        }
        return false;
    }
}