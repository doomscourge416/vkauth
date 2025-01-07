<?php
// Параметры приложения
$clientId = '52898945'; // ID приложения
$redirectUri = 'https://vkauth.local/oauth.php'; // TODO: web data

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
    <h1>Добро пожаловать!</h1>
    <a href="<?= $authUrl ?>" style="padding: 10px 20px; background-color: #4A76A8; color: white; text-decoration: none; border-radius: 5px;">
        Авторизоваться через VK
    </a>
</body>
</html>
