<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            $eMail = htmlspecialchars($_POST['email']);
            $subject = strip_tags($_POST['subject']);
            $message = strip_tags($_POST['message']);
            
            if (isset($name) && isset($txt) && isset($eMail)) {
                mail($eMail, $subject, $message);
            }
        ?>
    </body>
</html>
