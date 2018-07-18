<?php
    //Автоподгрузка классов из папок components и models
    spl_autoload_register(function ($className)
    {
        $arrayPaths = array(
            '/components/',
            '/models/',
            '/controllers/'
        );

        foreach ($arrayPaths as $path) {
            $path = ROOT . $path . $className . '.php';
            if(is_file($path)) {
                include_once $path;
            }
        }
    });
