<?php 
	// Указываем кодировку
	header('Content-Type: text/html; charset = utf-8');

	$server = "localhost";
	$username = "root";
	$password = "";
	$database = "logindb";

	// Подключение к базе данный через MySQLi
	$mysqli = new mysqli($server, $username, $password, $database);

	// Проверяем успешность соединения
	if (mysqli_connect_errno()) {
		echo "<p><strong>Ошибка подключения к БД</strong>. Описание ошибки: ".mysqli_connect_errno()."</p>";
        exit(); 
	}

	// Устанавливаем кодировку подключения
	$mysqli -> set_charset('utf-8');
	//Для удобства, добавим здесь переменную, которая будет содержать название нашего сайта
	$address_site = "http://localhost:8080";
	$email_admin = "support@example.ru"
 ?>