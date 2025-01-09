<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\HtmlFormatter;

session_start(); // Подключаем сессии
$log = new Logger('mylogger');
$log->pushHandler(new StreamHandler('mylog.log', Logger::WARNING));
$log->pushHandler(new StreamHandler('troubles.log', Logger::ALERT));


if (!isset($_SESSION['db_user_id']) && !isset($_SESSION['vk_user_id'])) {
    echo "Вы не залогинены!</br>";
    echo '<a href="login.php">На страницу авторизации...</a>';
    exit();
}

echo '<h1>Добро пожаловать!</h1>';
echo '<a href="index.php">Главная страница</a>';

if (isset($_SESSION['db_user_id'])) {
    echo '<p>Вы вошли как пользователь из базы данных.</p>';
    echo '<p>Ваш ID: ' . $_SESSION['db_user_id'] . '</p>';
    echo '<p>Ваша роль: ' . $_SESSION['role'] . '</p>';
}

if (isset($_SESSION['vk_user_id'])) {
    echo '<p>Вы вошли через VK.</p>';
    echo '<p>Ваш VK ID: ' . $_SESSION['vk_user_id'] . '</p>';
    echo '<p>Ваша роль: ' . $_SESSION['role'] . '</p>';
    if (isset($_SESSION['email'])) {
        echo '<p>Ваш email: ' . $_SESSION['email'] . '</p>';
    }

} 


if(isset($_SESSION['db_user_id']) || isset($_SESSION['vk_user_id'])){  
    //  Обработка формы
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $message = $_POST['message'] ?? '';
        $filePath = 'messages.txt';

        if(!file_exists($filePath)){
            $log->alert("Файл messages.txt не существет! Запись сообщения: " . $message . " невозможна.");
            echo "Ошибка: файл messages.txt не существует!";
        } else {
            //  Если файл существует, то записываем в него $message
            file_put_contents($filePath, $message . PHP_EOL, FILE_APPEND);
            echo "Сообщение сохранено в файл.";
        }
    }
}    
?>

<a href="protected_page.php">Картинка для пользователей ВКОНТАКТЕ</a>

<h2>Отправка сообщения</h2>
<form action="dashboard.php" method="POST">
    <textarea name="message" placeholder="Введите ваше сообщение" rows="4" cols="50"></textarea></br>
    <input type="submit" value="Отправить" />
</form> 