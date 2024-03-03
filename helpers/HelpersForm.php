<?php
include "../database/ConnectionDb.php";
class HelpersForm{

    public function register($db)
    {
        session_start();
        if(!empty($_POST['login']) && !empty($_POST['email']) && !empty($_POST['phone']) && !empty($_POST['password']) && !empty($_POST['password_again'])){
            if($_POST['password'] !== $_POST['password_again']){
                $_SESSION['MESSAGE'] = "Пароль не совпадает с подтверждением пароля";
                header("Location: /");
                exit;
            }
            $name = trim(htmlspecialchars($_POST['login']));
            $email = trim(htmlspecialchars($_POST['email']));
            $phone = trim(htmlspecialchars($_POST['phone']));
            $password = trim(htmlspecialchars($_POST['password']));

            $sql = "SELECT `login`,`email`,`phone` FROM `users` WHERE `login` = ? OR `email` = ? OR `phone` = ?";
            $query = $db->PDO->prepare($sql);
            $query->execute([$name,$email,$phone]);

            while($result = $query->fetch(PDO::FETCH_ASSOC)) {
                if ($result['login'] === $name || $result['email'] === $email || $result['phone'] === $phone) {
                    $_SESSION['MESSAGE'] = "К сожалению такой логин, email или телефон уже существует!";
                    header("Location: /");
                    exit;
                }else{
                    continue;
                }
            }
                $_SESSION["ADMIN"] = md5("entrance");
                $password = password_hash($password, PASSWORD_DEFAULT);

                //проверки телефона и перевод в один формат
                $phone = $this->parsingPhone($phone);

                $sql = "INSERT INTO `users`(`login`,`phone`,`email`,`password`)VALUES(?,?,?,?)";
                $createUser = $db->PDO->prepare($sql);
                $createUser->execute([$name,$phone,$email,$password]);

                $_SESSION['SUCCESS'] = "Поздравляю Вы зарегистрировали!";
                $_SESSION['login'] = $name;
                $_SESSION['email'] = $email;
                $_SESSION['phone'] = $phone;

                header("Location: /views/admin/room.php");
                exit;
        }else{
            $_SESSION['MESSAGE'] = "Вы не заполнили обязательные поля.";
            header("Location: /");
            exit;
        }
    }

    public function auth($db)
    {
        session_start();
            if(!empty($_POST['phone']) && !empty($_POST['password'])){
                $phoneOrEmail = trim(htmlspecialchars($_POST['phone']));
                $password = trim(htmlspecialchars($_POST['password']));

                if(!strpos($phoneOrEmail,"@")){
                    $phoneOrEmail = $this->parsingPhone($phoneOrEmail);
                }

                $sql = "SELECT `id`,`login`,`email`,`phone`,`password` FROM `users` WHERE `email` = :phoneOrEmail OR `phone` = :phoneOrEmail";
                $query = $db->PDO->prepare($sql);
                $query->execute([":phoneOrEmail" => $phoneOrEmail]);
                $res = $query->fetch(PDO::FETCH_ASSOC);
                if($res != false){
                    if(($res['phone'] === $phoneOrEmail) || ($res['email'] === $phoneOrEmail)){
                        if(password_verify($password, $res['password'])) {

                            $_SESSION["ADMIN"] = md5("entrance");
                            $_SESSION['SUCCESS'] = "Поздравляю Вы авторезировались!";
                            $_SESSION['id'] = $res['id'];
                            $_SESSION['login'] = $res['login'];
                            $_SESSION['email'] = $res['email'];
                            $_SESSION['phone'] = $res['phone'];

                            header("Location: /views/admin/room.php");
                            exit;
                        }else{
                            $_SESSION['MESSAGE'] = "Ошибка. Пароль не верный.";
                            header("Location: /");
                            exit;
                        }
                    }else{
                        $_SESSION['MESSAGE'] = "Ошибка. Телефон или email не верный.";
                        header("Location: /");
                        exit;
                    }

                }else{
                    $_SESSION['MESSAGE'] = "Ошибка. Пользователя с такими данными нет.";
                    header("Location: /");
                    exit;
                    }
            }else{
                $_SESSION['MESSAGE'] = "Вы не заполнили телефон(email) или пароль.";
                header("Location: /");
                exit;
            }
    }

    private function parsingPhone($tel){
        $phone = str_replace(['(', ')', '-', ' '], '',$tel);
        if(!preg_match("/^[0-9]{10,11}+$/", $phone) && substr($phone,0,1) !== "+") {
            $_SESSION['MESSAGE'] = "Ошибка. Неверный формат телефона.";
            header("Location: /");
            exit;
        }
        if(strlen($phone) > 12){
            $_SESSION['MESSAGE'] = "Ошибка. Слишком длинный номер телефона.";
            header("Location: /");
            exit;
        }
        $phone = strrev($phone);
        $phone = substr($phone,0,10);
        $phone = "+7".strrev($phone);
        return $phone;
    }

    public static function exitSession(){
        unset($_SESSION["ADMIN"]);
        header("Location: /views/all/login.php");
        exit;
    }

    public function edit($db)
    {
        session_start();
        if (!empty($_POST['login']) && !empty($_POST['email']) && !empty($_POST['phone']) && !empty($_POST['password']) && !empty($_POST['password_again'])) {
            if ($_POST['password'] !== $_POST['password_again']) {
                $_SESSION['MESSAGE'] = "Пароль не совпадает с подтверждением пароля";
                header("Location: /views/admin/room.php");
                exit;
            }
            $login = trim(htmlspecialchars($_POST['login']));
            $email = trim(htmlspecialchars($_POST['email']));
            $phone = trim(htmlspecialchars($_POST['phone']));
            $password = trim(htmlspecialchars($_POST['password']));

            $sql = "SELECT `id`,`login`,`email`,`phone` FROM `users` WHERE `login` = ? OR `email` = ? OR `phone` = ?";
            $query = $db->PDO->prepare($sql);
            $query->execute([$login,$email,$phone]);

            while($res = $query->fetch(PDO::FETCH_ASSOC)){
                if(($res['login'] === $login || $res['email'] === $email || $res['phone'] === $phone) && ((int)$res['id'] === (int)$_SESSION['id'])) {
                    continue;
                }else{
                    $_SESSION['ROOM_MESSAGE'] = "Ошибка. Такие уникальные данные уже есть!";
                    header("Location: /views/admin/room.php");
                    exit;
                }
            }

            $password = password_hash($password, PASSWORD_DEFAULT);
            $phone = $this->parsingPhone($phone);

            $sql = "UPDATE `users` SET `login`= ?,`phone` = ?,`email`= ?,`password`= ? WHERE `id` = ?";
            $createUser = $db->PDO->prepare($sql);
            $createUser->execute([$login,$phone,$email,$password,(int)$_SESSION['id']]);

            $_SESSION['SUCCESS'] = "Поздравляю Вы обновили профиль!";
            $_SESSION['login'] = $login;
            $_SESSION['email'] = $email;
            $_SESSION['phone'] = $phone;

            header("Location: /views/admin/room.php");
            exit;

        }else{
            $_SESSION['MESSAGE'] = "Вы не заполнили телефон(email) или пароль.";
            header("Location: /views/admin/room.php");
            exit;
        }
    }
}

$db = new ConnectionDb();
$post = new HelpersForm();
if(isset($_POST['authButton'])){
    $post->auth($db);
}else if(isset($_POST['regButton'])){
    $post->register($db);
}else if(isset($_POST['exitSession'])){
    HelpersForm::exitSession();
}else if(isset($_POST['editButton'])){
    $post->edit($db);
}