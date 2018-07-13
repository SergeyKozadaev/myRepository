<?php

class UserModel {

    public static function testInput($data){
        $data = trim($data); //удаление символов из начала и конца строки
        $data = stripcslashes($data);//удаление экранирующих слэшей
        $data = htmlspecialchars($data);//преобразование специальных символов
        return $data;
    }

    public static function checkEmail($email) {

        if(filter_var($email,FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }

    public static function checkEmailExist($email) {

        $pdo = Db::pdoConnection();
        $statement = $pdo->prepare("SELECT COUNT(*) AS 'count' FROM worker WHERE wEmail = :email");
        $statement->bindValue(':email', (string) $email, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetch((PDO::FETCH_ASSOC));

        if(!empty($result['count'])) {
            return true;
        }

        return false;
    }

    public static function checkLoginLength($login) {

        if (strlen($login)>2) {
            return true;
        }

        return false;
    }

    public static function checkPasswordLength($password) {

        if (strlen($password)>4) {
            return true;
        }

        return false;
    }

    public static function checkPasswordRepeat($password, $passwordRepeat) {

        if (!strcmp($password, $passwordRepeat) ) {
            return true;
        }

        return false;
    }

    public static function createNewUser($login, $email, $password) {

        $pdo = Db::pdoConnection();

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $statement = $pdo->prepare(
            "INSERT INTO worker (wLogin, wEmail, wPasswordHash)
                       VALUES (:login, :email, :passwordHash)");

        $statement->bindValue(':login', (string) $login);

        $statement->bindValue(':email', (string) $email);

        $statement->bindValue(':passwordHash', (string) $passwordHash);

        return $statement->execute();
    }

    public static function getUserId($email, $password) {

        $pdo = Db::pdoConnection();

        $statement = $pdo->prepare(
            "SELECT wId FROM worker WHERE wEmail = :email");
        $statement->bindValue(':email', (string) $email);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_NUM);
        $userId = $statement->fetchColumn();
        $userId = intval($userId);

        $statement2 = $pdo->prepare("SELECT wPasswordHash FROM worker WHERE wId = :id");
        $statement2->bindValue(':id', (int) $userId);
        $statement2->execute();
        $passwordHash = $statement2->fetchColumn();

        if(password_verify($password, $passwordHash)) {
            return $userId;
        }

        return false;
    }

    public static function getUserName($userId) {
        $pdo = Db::pdoConnection();

        $statement = $pdo->prepare(
            "SELECT wLogin FROM worker WHERE wId = :userId");
        $statement->bindValue(':userId', (string) $userId);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_NUM);
        $userName = $statement->fetchColumn();

        return $userName;

    }

    public static function getUserRole($userId) {
        $pdo = Db::pdoConnection();

        $statement = $pdo->prepare(
            "SELECT wRole FROM worker WHERE wId = :userId");
        $statement->bindValue(':userId', (string) $userId);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_NUM);
        $userRole = $statement->fetchColumn();

        return $userRole;
    }

    public static function setUserAuthorisation($userId, $adminFlag, $userName) {

        $_SESSION['userId'] = $userId;
        $_SESSION['userName'] = $userName;
        $_SESSION['adminFlag'] = $adminFlag;

    }

    public static function unsetUserAuthorisation() {

        session_unset();

    }



}