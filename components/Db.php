<?php

//создание и настройка параметров подключения к Базе данных через PDO
class Db
{
    private static $dbHost = 'localhost';
    private static $dbName = 'helpdesk';
    private static $dbUser = 'root';
    private static $dbPassword = 'l2jdb2l';

    public static function pdoConnection()
    {
        $dsn = "mysql:host=".self::$dbHost.";dbname=".self::$dbName;
        $pdo = new PDO($dsn, self::$dbUser, self::$dbPassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("set names utf8");
        return $pdo;
    }
}