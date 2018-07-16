<?php
//класс для обработки входных данных
class Input
{
    public static function testInput($data){
        $data = trim($data); //удаление символов из начала и конца строки
        $data = stripcslashes($data);//удаление экранирующих слэшей
        $data = htmlspecialchars($data);//преобразование специальных символов
        return $data;
    }

}
