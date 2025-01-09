<?php
session_start();

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['db_user_id']) && !isset($_SESSION['vk_user_id'])) {
    header('Location: login.php');
    exit();
}

// Общий абзац текста для всех авторизованных пользователей
echo '<p>Добро пожаловать, авторизованный пользователь!</p></br>';
echo '<a href="dashboard.php">Страница для авторизованных пользователей</a>';

// Логика для пользователей с VK-ролями
if (isset($_SESSION['role']) && $_SESSION['role'] === 'vk_user') {
    echo '<img src="vkjavaauth.png" alt="Картинка для пользователей VK" style="width: 700px; height: 300px;"/>';
}
?>
