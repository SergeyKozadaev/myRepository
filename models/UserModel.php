<?php

class UserModel
{
    //Проверка выполнения требований для введенной строки email
    public static function checkEmail($email)
    {
        if(filter_var($email,FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
    // Проверка существования такого email в БД
    public static function checkEmailExist($email)
    {
        $pdo = Db::pdoConnection();
        $statement = $pdo->prepare("SELECT COUNT(*) FROM worker WHERE wEmail = :email");
        $statement->bindValue(':email', (string) $email, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetch((PDO::FETCH_NUM));
        return $result[0];
    }
    //проверка введенноо логина на соответсвие минимальным требования длины
    public static function checkLoginLength($login)
    {
        if (strlen($login)>2) {
            return true;
        }
        return false;
    }
    //проверка введенноо пароля на соответсвие минимальным требования длины
    public static function checkPasswordLength($password)
    {
        if (strlen($password)>4) {
            return true;
        }
        return false;
    }
    //проверка соответствия введенного пароля повтору этого пароля
    public static function checkPasswordRepeat($password, $passwordRepeat)
    {
        if (!strcmp($password, $passwordRepeat) ) {
            return true;
        }
        return false;
    }
    //добавление в БД нового пользователя
    public static function createNewUser($login, $email, $password)
    {
        $pdo = Db::pdoConnection();
        //пароль в БД хранится в виде хэш-функции
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $statement = $pdo->prepare(
            "INSERT INTO worker (wLogin, wEmail, wPasswordHash)
                       VALUES (:login, :email, :passwordHash)");
        $statement->bindValue(':login', (string) $login);
        $statement->bindValue(':email', (string) $email);
        $statement->bindValue(':passwordHash', (string) $passwordHash);
        return $statement->execute();
    }
    //Функция проверяет наличие в БД пользователя с такой парой email-password,
    // если такой пользователь найден - возвращает его Id, Login(Name), adminFlag(явл-ся ли админом)
    public static function getUserInfo($email, $password) {
        $pdo = Db::pdoConnection();
        $statement = $pdo->prepare(
            "SELECT wPasswordHash, wId, wLogin, wRole FROM worker WHERE wEmail = :email");
        $statement->bindValue(':email', (string) $email);
        $statement->execute();
        $result = $statement->fetch((PDO::FETCH_NUM));
        $passwordHash = array_shift($result);
        if(password_verify($password, $passwordHash)) {
            return $result;
        }
        return false;
    }
}