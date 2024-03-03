<?php
include "../template/header.php"
?>
<div class="wrapper">
    <h1>Регистрация</h1>
    <div class="container">
        <form action="/helpers/HelpersForm.php" method="post" class="form">
            <label for="login">Имя или логин</label><br>
            <input type="text" name="login" placeholder="Имя или логин" id="login" value="<?php if(isset($_POST['login'])){echo $_POST['login'];}?>" required><br>
            <label for="email">Email</label><br>
            <input type="email" name="email" placeholder="Ваш email"  id="email" value="<?php if(isset($_POST['login'])){echo $_POST['email'];}?>" required><br>
            <label for="phone">Телефон:</label><br>
            <input type="tel" name="phone" placeholder="Ваш телефон" id="phone" value="<?php if(isset($_POST['login'])){echo $_POST['login'];}?>" required><br>
            <label for="password">Пароль:</label><br>
            <input type="password" name="password" placeholder="Ваш пароль" id="password" required><br>
            <label for="password_again">Пароль еще раз:</label><br>
            <input type="password" name="password_again" placeholder="Ваш пароль еще раз" id="password_again" required><br>
            <button type="submit" name="regButton" class="but">Отправить</button>
        </form>
    </div>
</div>
<?php
include "../template/footer.php";
?>
