<?php
//контроллер отвечает за регистрацию, авторизацию и выход пользователя из системы
class UserController
{
    //регистрация пользователя
    public function actionRegister()
    {
        $login = '';
        $email = '';
        $password = '';
        $passwordRepeat = '';
        $result = false;

        //проверка на авторизацию пользователя
        if (UserModel::checkUserAuthorisation()) {
            header("Location: /list");
            exit;
        }

        if (isset($_POST['reset'])){
            $login = '';
            $email = '';
            $password = '';
            $passwordRepeat = '';
        }

        if (isset($_POST['submit'])){
            $login = Input::testInput($_POST['login']);
            $email = Input::testInput($_POST['email']);
            $password = Input::testInput($_POST['password']);
            $passwordRepeat = Input::testInput($_POST['passwordRepeat']);
            //массив ошибок
            $errors = false;

            if (!UserModel::checkLoginLength($login)) {
                $errors [] = 'Логин должен быть длинее 2 символов';
                $login = '';
            }

            if (!UserModel::checkEmail($email)) {
                $errors[] = 'Email должен быть формата: mailbox@provider.com';
                $email = '';
            }

            if (!UserModel::checkPasswordLength($password)) {
                $errors[] = 'Пароль должен быть не менее 5 символов';
                $password = '';
                $passwordRepeat = '';
            }

            if (!UserModel::checkPasswordRepeat($password, $passwordRepeat)) {
                $errors[] = 'Введенные пароли не совпадают';
                $password = '';
                $passwordRepeat = '';
            }

            if (UserModel::checkEmailExist($email)) {
                $errors[] = 'Пользователь с таким email уже существует';
            }

            if (empty($errors)) {
                $result = UserModel::createNewUser($login, $email, $password);
            }
        }

        require_once (ROOT . '/views/user/registerView.php');
        return true;
    }
    //авторизация пользователя
    public function actionLogin()
    {
        $email = '';
        $password = '';
        $result = false;

        //проверка на авторизацию пользователя
        if (UserModel::checkUserAuthorisation()) {
            header("Location: /list");
            exit;
        }

        if (isset($_POST['reset'])) {
            $email = '';
            $password = '';
        }

        if (isset($_POST['submit'])) {
            $email = Input::testInput($_POST['email']);
            $password = Input::testInput($_POST['password']);
            //массив с ошибками ввода
            $errors = false;

            if (!UserModel::checkEmail($email)) {
                $errors[] = 'Email должен быть формата: mailbox@provider.com';
                $email = '';
            }

            if (!UserModel::checkPasswordLength($password)) {
                $errors[] = 'Пароль должен быть не менее 5 символов';
                $password = '';
            }

            if (empty($errors)) {
                $result = UserModel::getUserInfo($email, $password);
                if (!$result) {
                    $errors [] = 'Неправильные данные для входа';
                    $email = '';
                    $password = '';
                }
            }

            if (empty($errors)) {
                $userId = intval(array_shift($result));
                $userName = array_shift($result);
                $adminFlag = intval(array_shift($result));
                UserModel::setUserAuthorisation($userId, $userName, $adminFlag);
                header("Location: /list/");
                exit;
            }
        }

        require_once (ROOT . '/views/user/loginView.php');
        return true;
    }
    //выход пользователя из системы
    public function actionLogout()
    {
        UserModel::unsetUserAuthorisation();
        header("Location: /");
        return true;
    }

}