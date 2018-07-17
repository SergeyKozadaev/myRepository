<?php
    //FRONT CONTROLLER
    //ОБЩИЕ НАСТРОЙКИ
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    //ПОДКЛЮЧЕНИЕ ФАЙЛОВ КАРКАСА
    define('ROOT', dirname(__FILE__));
    require_once (ROOT . '/components/Autoload.php');
    //запускаем сессию и роутер
    session_start();
    $router = new Router();
    $router->run();