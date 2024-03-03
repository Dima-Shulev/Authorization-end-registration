<?php
session_start();
if(isset($_SESSION['ADMIN']) && ($_SESSION['ADMIN'] === "2a20afe023299a12bce40984ddb2a023")){
include_once "../template/header.php";?>
    <div class="wrapper">
        <h1>Редактировать кабинет:</h1>
        <div class="container">
            <form action="/helpers/HelpersForm.php" method="post" class="form">
                <label for="login">Имя или логин</label><br>
                <input type="text" name="login" placeholder="Имя или логин" id="login" value="<?php echo $_SESSION['login'];?>"><br>
                <label for="email">Email</label><br>
                <input type="email" name="email" placeholder="Ваш email"  id="email" value="<?php echo $_SESSION['email'];?>"><br>
                <label for="phone">Телефон:</label><br>
                <input type="tel" name="phone" placeholder="Ваш телефон" id="phone" value="<?php echo $_SESSION['phone'];?>"><br>
                <label for="password">Пароль:</label><br>
                <input type="password" name="password" placeholder="Ваш пароль" id="password"><br>
                <label for="password_again">Пароль еще раз:</label><br>
                <input type="password" name="password_again" placeholder="Ваш пароль еще раз" id="password_again"><br>
                <button type="submit" name="editButton" class="but">Отправить</button>
            </form>
        </div>
    </div>
    <?php
    include "../template/footer.php";
}else{
    $_SESSION['MESSAGE'] = "Вы не авторезированы и Вам отказано в доступе!";
    header("Location: /");
    exit;
}?>