<?php
session_start(); // Подключаем сессии
require_once __DIR__ . '/../vendor/autoload.php'; // Подключаем библиотеку Monolog
require_once __DIR__ . '/../config.php';          // Подключаем базу данных

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Создаём логгер для неудачных попыток входа
$log = new Logger('auth_attempts');
$log->pushHandler(new StreamHandler('auth_attempts.log', Logger::WARNING));
TODO: ПРОДОЛЖАЕМ С ЭТОЙ СТРОКИ
?>