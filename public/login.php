<?php
session_start();
// Параметры приложения VK
$clientId = '52898945'; // ID приложения VK
$redirectUri = 'https://vkauth.local/oauth.php'; // Обработчик VK OAuth

// Формируем ссылку для авторизации через VK
$params = [
    'client_id'     => $clientId,
    'redirect_uri'  => $redirectUri,
    'response_type' => 'code',
    'v'             => '5.126',
    'scope'         => 'email,offline', // Права доступа
];
$authUrl = 'https://oauth.vk.com/authorize?' . http_build_query($params);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
</head>
<body>
    <a href="index.php">Главная</a>
    <h1>Добро пожаловать на страницу авторизации!</h1>

    <!-- Форма авторизации через логин и пароль -->
    <form action="login_process.php" method="POST">
        <label for="username">Логин:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Пароль:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <button type="submit" name="auth_type" value="db">Войти</button>
    </form>
    <br>

    <!-- Кнопка авторизации через VK -->
    <a href="<?= $authUrl ?>" style="padding: 10px 20px; background-color: #4A76A8; color: white; text-decoration: none; border-radius: 5px;">
        Авторизоваться через VK
    </a>
</body>
</html>
