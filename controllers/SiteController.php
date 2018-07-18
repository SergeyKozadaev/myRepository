<?php
//контроллер страницы-приветсвия сайта, просто подключает View
class SiteController
{
    //вызов страницы приветсвия
    public function actionIndex()
    {
        require_once(ROOT . '/views/site/indexView.php');
        return true;
    }
    //вызов страницы 404 ошибки
    public function actionPage404()
    {
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
        require_once(ROOT . '/views/site/404View.php');
        return true;
    }
    //вызов страницы с сообщением, что у пользователя нет заявок в БД
    public function actionNoTasks()
    {
        require_once(ROOT . '/views/site/noTasksView.php');
        return true;
    }
}