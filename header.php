<?php
    //Запускаем сессию
    session_start();
?>
 
<!DOCTYPE html>
<html>
    <head>
        <title>Название нашего сайта</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/styles.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        
    </head>
    <body>
 
        <div id="header">
            <h2>Название сайта</h2>
 
            <a href="mailer.php">Тест почты</a>
            <a href="index.php"><img src="images/logo.jpg" width="96" height="96" alt="logo"/></a>

            <div id="auth_block">
<?php
    //Проверяем авторизован ли пользователь
    if(!isset($_SESSION['email']) && !isset($_SESSION['password'])){
        // если нет, то выводим блок с ссылками на страницу регистрации и авторизации
        echo 
        '<div id="link_register">
            <a href="/form_register.php">Регистрация</a>
        </div>
 
        <div id="link_auth">
            <a href="/form_auth.php">Авторизация</a>
        </div>';

    }else{
        //Если пользователь авторизован, то выводим ссылку Выход
        echo 
        '<div id="link_logout">
            <a href="/logout.php">Выход</a>
        </div>';
    }
?>
    </div>
             <div class="clear"></div>
        </div>