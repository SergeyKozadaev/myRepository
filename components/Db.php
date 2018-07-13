<?php

//создание и настройка параметров подключения к Базе данных через PDO
class Db {

    public static function pdoConnection() {

        $configPath = ROOT . '/config/dbConfig.php';
        $config = include ($configPath);

        $pdo = new PDO("mysql:host={$config['dbHost']};dbname={$config['dbName']}", $config['dbUser'], $config['dbPassword']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("set names utf8");

        return $pdo;

    }
}