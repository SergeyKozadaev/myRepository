<?php
class UserController {

    public function actionRegister() {

        $login = '';
        $email = '';
        $password = '';
        $passwordRepeat = '';
        $result = false;

        if(isset($_POST['reset'])){
            $login = '';
            $email = '';
            $password = '';
            $passwordRepeat = '';
        }

        if(isset($_POST['submit'])){
            $login = UserModel::testInput($_POST['login']);
            $email = UserModel::testInput($_POST['email']);
            $password = UserModel::testInput($_POST['password']);
            $passwordRepeat = UserModel::testInput($_POST['passwordRepeat']);

            $errors = false;

            if(!UserModel::checkLoginLength($login)) {
                $errors [] = 'Логин должен быть длинее 2 символов';
                $login = '';
            }

            if(!UserModel::checkEmail($email)) {
                $errors[] = 'Email должен быть формата: mailbox@provider.com';
                $email = '';
            }

            if(!UserModel::checkPasswordLength($password)) {
                $errors[] = 'Пароль должен быть длиннее 4 символов';
                $password = '';
                $passwordRepeat = '';
            }

            if(!UserModel::checkPasswordRepeat($password, $passwordRepeat)) {
                $errors[] = 'Введенные пароли не совпадают';
                $password = '';
                $passwordRepeat = '';
            }

            if(UserModel::checkEmailExist($email)) {
                $errors[] = 'Пользователь с таким email уже существует';
            }

            if (empty($errors)) {
                $result = UserModel::createNewUser($login, $email, $password);
            }
        }

        require_once (ROOT . '/views/user/registerView.php');

        return true;
    }

    public function actionLogin() {

        $email = '';
        $password = '';
        $result = false;

        if(isset($_POST['reset'])){
            $email = '';
            $password = '';
        }

        if(isset($_POST['submit'])){
            $email = UserModel::testInput($_POST['email']);
            $password = UserModel::testInput($_POST['password']);

            $errors = false;

            if(!UserModel::checkEmail($email)) {
                $errors[] = 'Email должен быть формата: mailbox@provider.com';
                $email = '';
            }

            if(!UserModel::checkPasswordLength($password)) {
                $errors[] = 'Пароль должен быть длиннее 4 символов';
                $password = '';
            }

            $userId = UserModel::getUserId($email, $password);
            $adminFlag = UserModel::getUserRole($userId);
            $userName = UserModel::getUserName($userId);

            if(!$userId) {
                $errors [] = 'Неправильные данные для входа';
                $email = '';
                $password = '';
            } else {
                UserModel::setUserAuthorisation($userId, $adminFlag, $userName);
                header("Location: /list/");

            }

            if (empty($errors)) {
                $result = '';
            }
        }

        require_once (ROOT . '/views/user/loginView.php');

        return true;
    }

    public function actionLogout() {
        UserModel::unsetUserAuthorisation();
        header("Location: /");

    }
}