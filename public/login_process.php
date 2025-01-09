<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php'; // Подключаем Monolog
require_once __DIR__ . '/../config.php';          // Подключаем базу данных

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Логгер для авторизации
$log = new Logger('auth_attempts');
$log->pushHandler(new StreamHandler('auth_attempts.log', Logger::WARNING));

// Обработка логина и пароля из базы данных
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['auth_type']) && $_POST['auth_type'] === 'db') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        die('Пожалуйста, заполните все поля.');
    }

    // Проверяем пользователя в базе данных
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['db_user_id'] = $user['id']; // Отдельное поле для ID из базы данных
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header('Location: dashboard.php');
        exit();
    } else {
        $log->warning("Неудачная попытка авторизации. Логин: $username, IP: " . $_SERVER['REMOTE_ADDR']);
        echo 'Неверный логин или пароль</br>';
        echo '<a href="login.php">Обратно на страницу авторизации...</a>';
        exit();
    }
}

// Обработка VK OAuth
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['code'])) {
    $clientId = '52898945'; // ID приложения VK
    $clientSecret = 'your_client_secret'; // Ваш защищённый ключ
    $redirectUri = 'https://vkauth.local/login_process.php'; // URL обработки VK OAuth

    // Получаем access_token от VK
    $params = [
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'redirect_uri' => $redirectUri,
        'code' => $_GET['code']
    ];

    $response = file_get_contents('https://oauth.vk.com/access_token?' . http_build_query($params));
    $data = json_decode($response, true);

    if (isset($data['error'])) {
        $log->warning('Ошибка VK авторизации: ' . $data['error_description']);
        die('Ошибка VK авторизации: ' . $data['error_description']);
    }

    // Сохраняем данные VK в сессию
    $_SESSION['vk_user_id'] = $data['user_id']; // Отдельное поле для ID из VK
    $_SESSION['token'] = $data['access_token'];
    if (isset($data['email'])) {
        $_SESSION['email'] = $data['email'];
    }
    $_SESSION['role'] = 'vk_user';

    header('Location: dashboard.php');
    exit();
}

// Если ничего не передано, показываем ошибку
die('Ошибка: неправильный запрос.');
?>
