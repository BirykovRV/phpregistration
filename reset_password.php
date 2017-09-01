<?php
    //Подключение шапки
    require_once("header.php");
?>
        <div class="bloc_for_message">
            <?
                if(isset($_SESSION["error_messages"]) && !empty($_SESSION["error_messages"])){
                    echo $_SESSION["error_messages"];
                     //Уничтожаем ячейку error_messages, чтобы сообщения об ошибках не появились заново при обновлении страницы
                    unset($_SESSION["error_messages"]);
                }
                if(isset($_SESSION["success_messages"]) && !empty($_SESSION["success_messages"])){
                    echo $_SESSION["success_messages"];

                    //Уничтожаем ячейку success_messages, чтобы сообщения не появились заново при обновлении страницы
                    unset($_SESSION["success_messages"]);
                }
            ?>
        </div>
        
        <?php
        //Проверяем, если пользователь не авторизован, то выводим форму регистрации, 
        //иначе выводим сообщение о том, что он уже зарегистрирован
        if((!isset($_SESSION["email"]) && !isset($_SESSION["password"]))) {
            if(!isset($_GET["hidden_form"])){
        ?>
 
            <div class="center_block">
                <h2>Восстановление пароля</h2>
                 
                <!-- Абзац -->
                <p class="text_center mesage_error" id="valid_email_message"></p>
                <form action="link_reset_password.php" method="POST" name="form_request_email" >
                    <table>
                        <tr>
                            <td> Введите Ваш <br />E-mail: </td>
                            <td>
                                <input type="email" name="email" placeholder="E-mail" >
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text_center">
                                <input type="submit" name="send" value="Восстановить">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
 
        <?php
                }//закрываем условие hidden_form

            }else{
        ?>
                <div id="authorized">
                    <h2>Вы уже авторизованы</h2>
                </div>
        <?php
            }
        require_once("footer.php");
        ?>
