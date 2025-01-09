<?php
session_start(); // Подключаем сессии
require_once __DIR__ . '/../vendor/autoload.php'; // Подключаем библиотеку Monolog
require_once __DIR__ . '/../config.php';          // Подключаем базу данных

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Создаём логгер для неудачных попыток входа
$log = new Logger('auth_attempts');
$log->pushHandler(new StreamHandler('auth_attempts.log', Logger::WARNING));

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    //  Проверка на заполненность полей
    if(empty($username) || empty($password)){
        die('Пожалуйста, заполните все поля.');
    }

    //  Проверяем пользователя в базе
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username'=> $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($password, $user['password'])){
        // То авторизация успешна
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header('Location: dashboard.php');
        exit();
    } else {
        //  А при неудачном логине
        $log->warning("Неудачная попытка авторизации. Логин: $username");
        echo 'Неверный логин или пароль';
    }
}

?>