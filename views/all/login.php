<?php
session_start();
include "../template/header.php";
?>
<div class="wrapper">
    <h1>Авторизация</h1>
    <div class="container">
        <form action="/helpers/HelpersForm.php" method="post" class="form">
            <label for="phone">Телефон или email</label><br>
            <input type="text" name="phone" placeholder="Телефон или email" id="phone" value="<?php if(isset($_POST['phone'])){echo $_POST['phone'];}?>" required><br>
            <label for="password">Пароль:</label><br>
            <input type="password" name="password" placeholder="Ваш пароль" id="password" required><br>
            <button type="submit" name="authButton" class="but">Войти</button>
        </form>
    </div>
</div>
<?php
include "../template/footer.php";
session_destroy();
?>
