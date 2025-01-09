<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\HtmlFormatter;

session_start(); // Подключаем сессии
$log = new Logger('mylogger');
$log->pushHandler(new StreamHandler('mylog.log', Logger::WARNING));
$log->pushHandler(new StreamHandler('troubles.log', Logger::ALERT));

if(!isset($_SESSION['user_id'])){
    echo "Вы не залогинены" ;
} else {
    echo '<h1>Добро пожаловать!</h1>';
    echo '<p>Ваш ID: ' . $_SESSION['user_id'] . '</p>';
}

// Проверяем, есть ли токен в сессии
if (isset($_SESSION['token'])) {
    echo '<p>Ваш токен: ' . $_SESSION['token'] . '</p>';
    echo '<p>Ваш VK ID: ' . $_SESSION['user_id'] . '</p>';
    if (isset($_SESSION['email'])) {
        echo '<p>Ваш email: ' . $_SESSION['email'] . '</p>';
    }
}

if(isset($_SESSION['user_id'])){  
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
    
?>

<h2>Отправка сообщения</h2>
<form action="dashboard.php" method="POST">
    <textarea name="message" placeholder="Введите ваше сообщение" rows="4" cols="50"></textarea></br>
    <input type="submit" value="Отправить" />
</form> 
<?php
} 
?>