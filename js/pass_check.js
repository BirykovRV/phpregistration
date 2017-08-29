        //================ Проверка длины пароля ==================
$(document).ready(function(){
    var password = $('input[name=password]');
    var confirm_password = $('input[name=confirm_password]');

    password.blur(function(){
        if(password.val() != ''){

            //Если длина введённого пароля меньше шести символов, то выводим сообщение об ошибке
            if(password.val().length < 6){
                //Выводим сообщение об ошибке
                $('#valid_password_message').text('Минимальная длина пароля 6 символов');

                //проверяем, если пароли не совпадают, то выводим сообщение об ошибке
                    if(password.val() != confirm_password.val()){
                    //Выводим сообщение об ошибке
                        $('#valid_confirm_password_message').text('Пароли не совпадают');
                    }

                // Дезактивируем кнопку отправки
                //$('input[type=submit]').attr('disabled', true);

            }else {
                //Иначе, если длина первого пароля больше шести символов, то мы также проверяем, если они  совпадают. 
                if(password.val() != confirm_password.val()){
                    //Выводим сообщение об ошибке
                    $('#valid_confirm_password_message').text('Пароли не совпадают');

                    // Дезактивируем кнопку отправки
                   // $('input[type=submit]').attr('disabled', true);
                }else {
                    // Убираем сообщение об ошибке у поля для ввода повторного пароля
                    $('#valid_confirm_password_message').text('');

                    //Активируем кнопку отправки
                   // $('input[type=submit]').attr('disabled', false);
                }

                // Убираем сообщение об ошибке у поля для ввода пароля
                $('#valid_password_message').text('');
            }

        }else {
            $('#valid_password_message').text('Введите пароль');
        }
    });

    confirm_password.blur(function(){
        if (password.val() !== confirm_password.val()) {
            //Выводим сообщение об ошибке
            $('#valid_confirm_password_message').text('Пароли не совпадают');
     
            // Дезактивируем кнопку отправки
           // $('input[type=submit]').attr('disabled', true);
        } else {
            //Иначе, проверяем длину пароля
            if(password.val().length > 6){
 
                // Убираем сообщение об ошибке у поля для ввода пароля
                $('#valid_password_message').text('');
     
                //Активируем кнопку отправки
               // $('input[type=submit]').attr('disabled', false);
            }
 
            // Убираем сообщение об ошибке у поля для ввода повторного пароля
            $('#valid_confirm_password_message').text('');
        }
    });
});
