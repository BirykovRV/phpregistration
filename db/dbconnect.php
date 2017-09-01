<?php

$server = 'localhost';
$login = 'root';
$pass = '';
try {
    $conn = new PDO("mysql:host=$server;dbname=logindb",$login,$pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exc) {
    echo $exc->getMessage();
}


if ($conn->connect_error) {
    die("Не удалось соединиться: " . $conn->connect_error);
}

