<?php

//контроллер страницы-приветсвия сайта, просто подключает View
class SiteController
{
    public function actionIndex()
    {
        require_once(ROOT . '/views/site/indexView.php');
        return true;
    }

    public function actionPage404()
    {
        require_once(ROOT . '/views/site/404View.php');
        return true;
    }
}