<?php
//контроллер работает с пользовательскими задачами(заявками) - создает, выводит список, выводит информацию о конкретной задаче
class TaskController
{
    //получение информации о списке задач, для последующего отображения этой информации
    public function actionList($pageNumber = 1)
    {
        // если администратор - выводим постранично список задач всех пользвоателей
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
                    header("Location: /list/");
                }
            } else {
                header("Location: /list/");
            }
        // если пользователь - выводим постранично список задач этого пользователя
        } elseif (!empty($_SESSION["userId"])) {
            $taskTotal = TaskModel::getUserTotalTasksNumder($_SESSION["userId"]);
            //Если у пользователя нет в БД заявок, то его перенаправит на страницу с сообщением
            if(!$taskTotal) {
                require_once(ROOT . '/views/site/noTasksView.php');
                exit;
            }

            $pageTotal = ceil($taskTotal/PER_PAGE);
            if(intval($pageNumber)) {
                if($pageNumber <= $pageTotal) {
                    $taskList = array();
                    $taskList = TaskModel::getUserTasksList($pageNumber, $_SESSION["userId"]);
                    require_once (ROOT . '/views/task/listView.php');
                    return true;
                // параметр номер страницы за пределами диапазона
                } else {
                    header("Location: /list/");
                }
            // параметр номер страницы не типа инт
            } else {
                header("Location: /list/");
            }
        // если нет авторизации - перенаправляем на начальную страницу
        } else {
            header("Location: /");
        }
    }
    //получение информации о конкретной задаче для последующего отображения этой информации
    public function actionShow($taskId)
    {
        if($taskId) {
            $taskItem = TaskModel::getTaskById($taskId);
            if(!empty($taskItem)) {
                require_once (ROOT . '/views/task/showView.php');
                return true;
            // нет задачи с таким id
            } else {
                header("Location: /list/");
            }
        }
    }
    //добавление новой задачи в БД
    public function actionNew()
    {
        $name = '';
        $contactPhone = '';
        $description = '';
        $result = false;

        if(isset($_POST['reset'])) {
            $name = '';
            $contactPhone = '';
            $description = '';
        }

        if(isset($_POST['submit'])) {
            $name = Input::testInput($_POST['name']);
            $contactPhone = Input::testInput($_POST['contactPhone']);
            $description = Input::testInput($_POST['description']);
            $photoPath = '';
            //массив с ошибками ввода
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
                    $errors[] = 'Не удается загрузить фото. Размер не должен превышать 2мб, файл должен иметь расширение jpg, gif, png.';
                }
            }
            // нет ошибок - создаем новую задачу и перенаправляем на страницу со списком задач
            if(empty($errors)) {
                $userId = $_SESSION ['userId'];
                $result = TaskModel::createNewTask($userId, $name, $contactPhone, $description, $photoPath);
                if($result) {
                    $_SESSION['lastTaskId'] = $result;
                }
                //по-хорошему надо сделать страницы с ошибками
                header("Location: /list/");
            }
        }

        require_once (ROOT . '/views/task/newView.php');
        return true;
    }
    //создание XML-файла и его скачивание пользователем
    public function actionDownloadXML()
    {
        $xmlFile = TaskModel::getAllTasksListXML();
        if (file_exists($xmlFile)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($xmlFile).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($xmlFile));
            readfile($xmlFile);
            return true;
        } else {
            header("Location: /list/");
        }
    }
}