<?php
session_start(); // Старт сессии для хранения токена

// Параметры приложения
$clientId = '52898945'; // ID приложения
$clientSecret = 'NiEM4dPfVnJ2xZDL7S9Z'; // Защищённый ключ
$redirectUri = 'https://vkauth.local/oauth.php'; // TODO: web data

// Проверяем, пришёл ли параметр `code`
if (isset($_GET['code'])) {
    // Формируем параметры для получения токена
    $params = [
        'client_id'     => $clientId,
        'client_secret' => $clientSecret,
        'code'          => $_GET['code'],
        'redirect_uri'  => $redirectUri,
    ];

    // Запрашиваем токен
    $response = file_get_contents('https://oauth.vk.com/access_token?' . http_build_query($params));
    $data = json_decode($response, true);

    // Проверяем наличие ошибок
    if (isset($data['error'])) {
        die('Ошибка: ' . $data['error_description']);
    }

    // Сохраняем токен в сессии
    $_SESSION['token'] = $data['access_token'];
    $_SESSION['vk_user_id'] = $data['user_id'];
    $_SESSION['role'] = 'vk_user';
    if (isset($data['email'])) {
        $_SESSION['email'] = $data['email'];
    }

    // Переадресация на страницу с информацией о пользователе
    header('Location: dashboard.php');
    exit();
} else {
    echo 'Ошибка: параметр code не найден.';
}
?>
