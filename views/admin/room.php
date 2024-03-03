<?php
session_start();
if(isset($_SESSION['ADMIN']) && ($_SESSION['ADMIN'] === "2a20afe023299a12bce40984ddb2a023")){
include_once "../template/header.php";?>
<div class="wrapper">
    <?php
    if(isset($_SESSION['SUCCESS'])){?>
        <div class="success">
            <p>
                <?php echo $_SESSION['SUCCESS'];
                    unset($_SESSION['SUCCESS']);
                ?>
            </p>
        </div>
    <?php
    }else if(isset($_SESSION['ROOM_MESSAGE'])){
    ?>
        <div class="errors">
            <p>
                <?php echo $_SESSION['ROOM_MESSAGE'];
                unset($_SESSION['ROOM_MESSAGE']);
                ?>
            </p>
        </div>
    <?php
    }
    ?>
    <h1>Личный кабинет</h1>
        <ul>
            <li><b>Имя: </b><?php echo $_SESSION['login'] ?></li>
            <li><b>Email: </b><?php echo $_SESSION['email'] ?></li>
            <li><b>Телефон: </b><?php echo $_SESSION['phone'] ?></li>
        </ul>

    <div class="my_flex">

       <a href="/views/admin/edit.php" class="but">Редактировать</a>


        <form action="/helpers/HelpersForm.php" method="post">
            <button type="submit" name="exitSession" class="but">Выйти</button>
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