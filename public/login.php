<?php
// Параметры приложения
$clientId = '52898945'; // ID приложения
$redirectUri = 'https://vkauth.local/oauth.php';
// Формируем ссылку для авторизации
$params = [
    'client_id'     => $clientId,
    'redirect_uri'  => $redirectUri,
    'response_type' => 'code',
    'v'             => '5.126',
    'scope'         => 'email,offline', // Права доступа
];
// Генерируем ссылку
$authUrl = 'https://oauth.vk.com/authorize?' . http_build_query($params);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация через VK</title>
</head>
<body>
    <h1>Добро пожаловать на страницу авторизации!</h1>
    <form action="login_process.php" method="POST">
        <label for="username">Логин:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Пароль:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <button type="submit">Войти</button>
    </form>
    </br>
    <a href="<?= $authUrl ?>" style="padding: 10px 20px; background-color: #4A76A8; color: white; text-decoration: none; border-radius: 5px;">
        Авторизоваться через VK
    </a>
</body>
</html>