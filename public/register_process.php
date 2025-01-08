<?php 
session_start();
// Подключение к базе данных
$servername = "127.127.126.50";
$username = "root";
$password = "";
$dbname = "auth";
$conn = new mysqli($servername, $username, $password, $dbname);
// Ошибка при подключении
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

$user = $_POST['username'] ?? '';
$pass = $_POST['password'] ?? '';

// Проверка на существование пользователя
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("Пользователь с таким логином уже существует!");
}

// Хэшируем пароль
$hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

// Вставляем пользователя в базу данных
$sql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'user')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user, $hashedPassword);

if ($stmt->execute()) {
    echo "Регистрация успешна! Теперь вы можете авторизоваться.";
    header("Location: login.php");
} else {
    echo "Ошибка: " . $stmt->error;
}

$conn->close();
?>