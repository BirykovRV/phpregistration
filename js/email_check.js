$(document).ready(function(){
    "use strict";
    //================ Проверка email ==================

    //регулярное выражение для проверки email
    var pattern = /^[a-z0-9][a-z0-9\._-]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i;
    var mail = $('input[name=email]');
         
	mail.blur(function(){
        if(mail.val() != ''){
 
            // Проверяем, если введенный email соответствует регулярному выражению
            if(mail.val().search(pattern) == 0){
                // Убираем сообщение об ошибке
                $('#valid_email_message').text('');
 
                //Активируем кнопку отправки
                $('input[type=submit]').attr('disabled', false);
            }else{
                //Выводим сообщение об ошибке
                $('#valid_email_message').text('Не правильный Email');
 
                // Дезактивируем кнопку отправки
                $('input[type=submit]').attr('disabled', true);
            }
        }else {
            $('#valid_email_message').text('Введите Ваш email');
        }
	});
});