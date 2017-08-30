<?php
    //Запускаем сессию
    session_start();

    //Добавляем файл подключения к БД
    require_once("dbconnect.php");

    //Объявляем ячейку для добавления ошибок, которые могут возникнуть при обработке формы.
    $_SESSION["error_messages"] = '';

    //Объявляем ячейку для добавления успешных сообщений
    $_SESSION["success_messages"] = '';

    /*
        Проверяем была ли отправлена форма, то есть была ли нажата кнопка зарегистрироваться. Если да, то идём дальше, если нет, значит пользователь зашёл на эту страницу напрямую. В этом случае выводим ему сообщение об ошибке.
    */
    if(isset($_POST["btn_submit_register"]) && !empty($_POST["btn_submit_register"])){

        //Проверяем полученную капчу
        //Обрезаем пробелы с начала и с конца строки
        $captcha = trim($_POST["captcha"]);

        if(isset($_POST["captcha"]) && !empty($captcha)){

            //Сравниваем полученное значение с значением из сессии. 
            if(($_SESSION["rand"] != $captcha) && ($_SESSION["rand"] != "")){
                
                // Если капча не верна, то возвращаем пользователя на страницу регистрации, и там выведем ему сообщение об ошибке что он ввёл неправильную капчу.
                $error_message = "<p class='mesage_error'><strong>Ошибка!</strong> Вы ввели неправильную капчу </p>";

                // Сохраняем в сессию сообщение об ошибке. 
                $_SESSION["error_messages"] = $error_message;

                //Возвращаем пользователя на страницу регистрации
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$address_site."/form_register.php");

                //Останавливаем скрипт
                exit();
            }

            /* Проверяем если в глобальном массиве $_POST существуют данные отправленные из формы и заключаем переданные данные в обычные переменные.*/

            
            if(isset($_POST["first_name"])){
                
                //Обрезаем пробелы с начала и с конца строки
                $first_name = trim($_POST["first_name"]);

                //Проверяем переменную на пустоту
                if(!empty($first_name)){
                    // Для безопасности, преобразуем специальные символы в HTML-сущности
                    $first_name = htmlspecialchars($first_name, ENT_QUOTES);
                }else{
                    // Сохраняем в сессию сообщение об ошибке. 
                    $_SESSION["error_messages"] .= "<p class='mesage_error'>Укажите Ваше имя</p>";

                    //Возвращаем пользователя на страницу регистрации
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: ".$address_site."/form_register.php");

                    //Останавливаем скрипт
                    exit();
                }

                
            }else{
                // Сохраняем в сессию сообщение об ошибке. 
                $_SESSION["error_messages"] .= "<p class='mesage_error'>Отсутствует поле с именем</p>";

                //Возвращаем пользователя на страницу регистрации
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$address_site."/form_register.php");

                //Останавливаем скрипт
                exit();
            }

            
            if(isset($_POST["last_name"])){

                //Обрезаем пробелы с начала и с конца строки
                $last_name = trim($_POST["last_name"]);

                if(!empty($last_name)){
                    // Для безопасности, преобразуем специальные символы в HTML-сущности
                    $last_name = htmlspecialchars($last_name, ENT_QUOTES);
                }else{

                    // Сохраняем в сессию сообщение об ошибке. 
                    $_SESSION["error_messages"] .= "<p class='mesage_error' >Укажите Вашу фамилию</p>";
                    
                    //Возвращаем пользователя на страницу регистрации
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: ".$address_site."/form_register.php");

                    //Останавливаем  скрипт
                    exit();
                }

                
            }else{

                // Сохраняем в сессию сообщение об ошибке. 
                $_SESSION["error_messages"] .= "<p class='mesage_error' >Отсутствует поле с фамилией</p>";
                
                //Возвращаем пользователя на страницу регистрации
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$address_site."/form_register.php");

                //Останавливаем  скрипт
                exit();
            }

            
            if(isset($_POST["email"])){

                //Обрезаем пробелы с начала и с конца строки
                $email = trim($_POST["email"]);

                if(!empty($email)){


                    $email = htmlspecialchars($email, ENT_QUOTES);

                    // (3) Место кода для проверки формата почтового адреса и его уникальности

                    //Проверяем формат полученного почтового адреса с помощью регулярного выражения
                    $reg_email = "/^[a-z0-9][a-z0-9\._-]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i";

                    //Если формат полученного почтового адреса не соответствует регулярному выражению
                    if( !preg_match($reg_email, $email)){
                        // Сохраняем в сессию сообщение об ошибке. 
                        $_SESSION["error_messages"] .= "<p class='mesage_error' >Вы ввели неправельный email</p>";
                        
                        //Возвращаем пользователя на страницу регистрации
                        header("HTTP/1.1 301 Moved Permanently");
                        header("Location: ".$address_site."/form_register.php");

                        //Останавливаем  скрипт
                        exit();
                    }

                    //Проверяем нет ли уже такого адреса в БД.
                    $result_query = $mysqli->query("SELECT `email` FROM `users` WHERE `email`='".$email."'");
                    
                    //Если кол-во полученных строк ровно единице, значит пользователь с таким почтовым адресом уже зарегистрирован
                    if($result_query->num_rows == 1){

                        //Если полученный результат не равен false
                        if(($row = $result_query->fetch_assoc()) != false){
                            
                                // Сохраняем в сессию сообщение об ошибке. 
                                $_SESSION["error_messages"] .= "<p class='mesage_error' >Пользователь с таким почтовым адресом уже зарегистрирован</p>";
                                
                                //Возвращаем пользователя на страницу регистрации
                                header("HTTP/1.1 301 Moved Permanently");
                                header("Location: ".$address_site."/form_register.php");
                            
                        }else{
                            // Сохраняем в сессию сообщение об ошибке. 
                            $_SESSION["error_messages"] .= "<p class='mesage_error' >Ошибка в запросе к БД</p>";
                            
                            //Возвращаем пользователя на страницу регистрации
                            header("HTTP/1.1 301 Moved Permanently");
                            header("Location: ".$address_site."/form_register.php");
                        }

                        /* закрытие выборки */
                        $result_query->close();

                        //Останавливаем  скрипт
                        exit();
                    }

                    /* закрытие выборки */
                    $result_query->close();
                }else{
                    // Сохраняем в сессию сообщение об ошибке. 
                    $_SESSION["error_messages"] .= "<p class='mesage_error' >Укажите Ваш email</p>";
                    
                    //Возвращаем пользователя на страницу регистрации
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: ".$address_site."/form_register.php");

                    //Останавливаем  скрипт
                    exit();
                }

            }else{
                // Сохраняем в сессию сообщение об ошибке. 
                $_SESSION["error_messages"] .= "<p class='mesage_error' >Отсутствует поле для ввода Email</p>";
                
                //Возвращаем пользователя на страницу регистрации
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$address_site."/form_register.php");

                //Останавливаем  скрипт
                exit();
            }

            
            if(isset($_POST["password"])){

                //Обрезаем пробелы с начала и с конца строки
                $password = trim($_POST["password"]);

                //Проверяем, совпадают ли пароли
                if(isset($_POST["confirm_password"])){
                    //Обрезаем пробелы с начала и с конца строки
                    $confirm_password = trim($_POST["confirm_password"]);

                    if($confirm_password != $password){
                        // Сохраняем в сессию сообщение об ошибке. 
                        $_SESSION["error_messages"] .= "<p class='mesage_error' >Пароли не совпадают</p>";

                        //Возвращаем пользователя на страницу регистрации
                        header("HTTP/1.1 301 Moved Permanently");
                        header("Location: ".$address_site."form_register.php");

                         //Останавливаем  скрипт
                        exit();
                    }

                }else{
                    // Сохраняем в сессию сообщение об ошибке. 
                    $_SESSION["error_messages"] .= "<p class='mesage_error' >Отсутствует поле для повторения пароля</p>";

                    //Возвращаем пользователя на страницу регистрации
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: ".$address_site."form_register.php");

                    //Останавливаем  скрипт
                    exit();
                }

                if(!empty($password)){
                    $password = htmlspecialchars($password, ENT_QUOTES);

                    //Шифруем папроль
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    //$password = md5($_POST["password"]);
                }else{
                    // Сохраняем в сессию сообщение об ошибке. 
                    $_SESSION["error_messages"] .= "<p class='mesage_error' >Укажите Ваш пароль</p>";
                    
                    //Возвращаем пользователя на страницу регистрации
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: ".$address_site."/form_register.php");

                    //Останавливаем  скрипт
                    exit();
                }

            }else {
                // Сохраняем в сессию сообщение об ошибке. 
                $_SESSION["error_messages"] .= "<p class='mesage_error' >Отсутствует поле для ввода пароля</p>";
                
                //Возвращаем пользователя на страницу регистрации
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$address_site."/form_register.php");

                //Останавливаем  скрипт
                exit();
            }

            //Запрос на добавления пользователя в БД
            $result_query_insert = $mysqli->query
            ("INSERT INTO `users` (first_name, last_name, email, password, date_registration)
              VALUES ('".$first_name."', '".$last_name."', '".$email."', '".$password."', NOW())");

            if(!$result_query_insert){
                // Сохраняем в сессию сообщение об ошибке. 
                $_SESSION["error_messages"] .= "<p class='mesage_error' >Ошибка запроса на добавления пользователя в БД</p>";
                
                //Возвращаем пользователя на страницу регистрации
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$address_site."/form_register.php");

                //Останавливаем  скрипт
                exit();
            }else{
                //Составляем зашифрованный и уникальный token
                $token = md5($email.time());

                //Добавляем данные в таблицу confirm_users
                $query_insert_confirm = $mysqli->query
                ("INSERT INTO `confirm_users` (email, token, date_registration)
                 VALUES ('".$email."', '".$token."', NOW()) ");

                if (!$query_insert_confirm) {
                    $_SESSION["error_messages"] .= "<p class='mesage_error' >Ошибка запроса на добавления пользователя в БД (confirm)</p>";

                    //Возвращаем пользователя на страницу регистрации
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: ".$address_site."/form_register.php");
                     //Останавливаем  скрипт
                    exit();
                } else {
                    //Составляем заголовок письма
                    $subject = "Подтверждение почты на сайте ".$_SERVER['HTTP_HOST'];
                    //Составляем тело сообщения
                    $message = 'Здравствуйте! <br/> <br/> Сегодня '
                    . ''.date("d.m.Y", time()).', неким пользователем была '
                    . 'произведена регистрация на сайте <a href="'.$address_site.'">'.$_SERVER['HTTP_HOST'].''
                    . '</a> используя Ваш email. Если это были Вы, то, пожалуйста, подтвердите адрес вашей '
                    . 'электронной почты, перейдя по этой ссылке:'
                    . '<a href="'.$address_site.'/activation.php?token='.$token.'&email='.$email.'">'.$address_site.'/activation/'.$token.''
                    . '</a> <br/> <br/> В противном случае, если это были не Вы, то, просто игнорируйте это письмо. <br/> <br/> '
                    . '<strong>Внимание!</strong> Ссылка действительна 24 часа. После чего Ваш аккаунт будет удален из базы.';
                     
                    //Составляем дополнительные заголовки для почтового сервиса mail.ru
                    //Переменная $email_admin, объявлена в файле dbconnect.php
                    $headers = "FROM: $email_admin\r\nReply-to: $email_admin\r\nContent-type: text/html; charset=utf-8\r\n";
                     
                    //Отправляем сообщение с ссылкой для подтверждения регистрации на указанную почту и проверяем отправлена ли она успешно или нет. 
                    if(mail($email, $subject, $message, $headers)){
                        $_SESSION["success_messages"] = "<h4 class='success_message'><strong>Регистрация прошла успешно!!!</strong></h4><p class='success_message'> Теперь необходимо подтвердить введенный адрес электронной почты. Для этого, перейдите по ссылке указанную в сообщение, которую получили на почту ".$email." </p>";
                 
                        //Отправляем пользователя на страницу регистрации и убираем форму регистрации
                        header("HTTP/1.1 301 Moved Permanently");
                        header("Location: ".$address_site."/form_register.php?hidden_form=1");
                        exit();
                 
                    }else {
                        $_SESSION["error_messages"] .= "<p class='mesage_error' >Ошибка при отправлении письма с сылкой подтверждения, на почту ".$email." </p>";
                    }
                 
                    // Завершение запроса добавления пользователя в таблицу users
                    $result_query_insert->close();
                 
                    // Завершение запроса добавления пользователя в таблицу confirm_users
                    $query_insert_confirm->close();
                }
            }

            //Закрываем подключение к БД
            $mysqli->close();
             
            //Отправляем пользователя на страницу регистрации
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$address_site."/form_register.php");
             
            exit();
            
        }else{
            //Если капча не передана либо оно является пустой
            exit("<p><strong>Ошибка!</strong> Отсутствует проверечный код, то есть код капчи. Вы можете перейти на <a href=".$address_site."> главную страницу </a>.</p>");
        }

    }else{

        exit("<p><strong>Ошибка!</strong> Вы зашли на эту страницу напрямую, поэтому нет данных для обработки. Вы можете перейти на <a href=".$address_site."> главную страницу </a>.</p>");
    }

    

    


    /*
    if(isset($r_send)){
        // Формируем запрос к БД для ввода данных
        $query = " INSERT INTO users (name,username,password) VALUES ('$r_name','$r_username','$r_password')";

        $result = mysql_query($query) or die ( "Error : ".mysql_error() );
 
        // Если все нормально то выводим сообщение.
        if($result){
            echo 'Регистрация прошла успешно! <a href="index.php">Перейти на главную страницу.</a> ';
            exit();
        }
    }else{
        echo 'Вы зашли на эту страницу напрямую, поэтому нет данных для обработки. Вы можете перейти на <a href="index.php"> главную страницу </a>';
    }*/
?>