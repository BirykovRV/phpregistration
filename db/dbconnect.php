<?php

$server = 'localhost';
$login = 'root';
$pass = '';
$database = 'logindb';

$conn = new mysqli($server,$login,$pass, $database);
if ($conn->connect_error) {
    die("Не удалось соединиться: " . $conn->connect_error);
}

