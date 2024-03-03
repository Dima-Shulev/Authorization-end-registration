<?php
session_start();
include "views/template/header.php";
?>
    <div class="wrapper">
        <?php
        if(isset($_SESSION['MESSAGE'])){?>
            <div class="errors">
                <p><?php echo $_SESSION['MESSAGE'];
                    unset($_SESSION['MESSAGE']);
                    ?></p>
            </div>
            <?php
        }
        ?>
        <ul>
            <li><a href="views/all/login.php">Войти</a></li>
            <li><a href="views/all/register.php">Зарегистрироваться</a></li>
        </ul>
    </div>
<?php
include "views/template/footer.php";
?>