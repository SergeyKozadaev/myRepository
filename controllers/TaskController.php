<?php

//include_once ROOT . '/models/TaskModel.php';

class TaskController {

    public function actionList($pageNumber = 1) {

        if(!empty($_SESSION["adminFlag"])) {
            $taskTotal = TaskModel::getAdminTotalTasksNumder();
            $pageTotal = ceil($taskTotal/PER_PAGE);

            if(intval($pageNumber)) {
                if($pageNumber <= $pageTotal) {
                    $taskList = array();
                    $taskList = TaskModel::getAdminTasksList($pageNumber);
                    require_once (ROOT . '/views/task/listView.php');
                    return true;
                } else {
                    header("Location: /list/1");
                    exit;
                }
            } else {
                header("Location: /list/1");
                exit;
            }
        } elseif (!empty($_SESSION["userId"])) {
            $taskTotal = TaskModel::getUserTotalTasksNumder($_SESSION["userId"]);
            $pageTotal = ceil($taskTotal/PER_PAGE);

            if(intval($pageNumber)) {
                if($pageNumber <= $pageTotal) {
                    $taskList = array();
                    $taskList = TaskModel::getUserTasksList($pageNumber, $_SESSION["userId"]);
                    require_once (ROOT . '/views/task/listView.php');
                    return true;
                } else {
                    header("Location: /list/1");
                    exit;
                }
            } else {
                header("Location: /list/1");
                exit;
            }

        } else {
            header("Location: /");
            exit;
        }


    }

    public function actionShow($taskId) {

        if($taskId) {
            $taskItem = TaskModel::getTaskById($taskId);
            if(!empty($taskItem)) {

                require_once (ROOT . '/views/task/showView.php');

            } else {
                header("Location: /list/1");
                exit;

            }

        }

        return true;
    }

    public function actionNew() {

        $name = '';
        $contactPhone = '';
        $description = '';

        $result = false;

        if(isset($_POST['reset'])){
            $name = '';
            $contactPhone = '';
            $description = '';
        }

        if(isset($_POST['submit'])){
            $name = TaskModel::testInput($_POST['name']);
            $contactPhone = TaskModel::testInput($_POST['contactPhone']);
            $description = TaskModel::testInput($_POST['description']);
            $photoPath = '';

            $errors = false;

            if (!TaskModel::checkName($name)) {
                $errors[] = 'Название должно быть длинее 4 символов';
                $name = '';
            }

            if(!TaskModel::checkContactPhone($contactPhone)) {
                $errors[] = 'Введенные данные не соответсвуют телефонному номеру';
                $contactPhone = '';
            }

            if(!TaskModel::checkDescription($description)) {
                $errors[] = 'Описание должно содержать больше 10 символов';
                $description = '';
            }

            if(!empty($_FILES['photo']['name'])) {
                $photoPath = TaskModel::uploadImage();

                if(!$photoPath) {
                    $errors[] = 'Не удается загрузить фото';
                }
            }

            if(empty($errors)) {
                $result = TaskModel::createNewTask($name, $contactPhone, $description, $photoPath);
                header("Location: /list/1");
            }


        }

        require_once (ROOT . '/views/task/newView.php');
        return true;
    }

    public function actiondownloadXML() {

        $xmlFile = TaskModel::getAllTasksListXML();

        //readfile(ROOT . $xmlFile);


        if (file_exists($xmlFile)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($xmlFile).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($xmlFile));
            readfile($xmlFile);
            exit;
        } else {
            echo 'cant find a file';
        }

        //echo $xmlFile;

        //var_dump($result);
/*
        foreach ($result as $array) {
            echo ' ' . $array['wId'];
            echo ' ' . $array['wLogin'];
            echo ' ' . $array['tName'];
            echo ' ' . $array['tContactPhone'];
            echo ' ' . $array['tDescription'];
            echo ' ' . $array['tPhoto'];
            echo '<br>';
        }
*/







        //header("Location: /list/1");
    }
}