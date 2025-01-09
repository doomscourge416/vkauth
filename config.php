<?php

$db_host = '127.127.126.50';
$db_name = 'auth';
$db_user = 'root';
$db_pass = '';

try{
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    die('Ошибка подключения к базе данных: ' . $e->getMessage());
}
?>