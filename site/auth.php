<!DOCTYPE html>
<?php
// Проверяем, были ли отправлены данные формы
if (!isset($_POST['username']) || !isset($_POST['password'])) {
    // Данные не были отправлены, выход из скрипта или обработка ошибки
    header("Location: index.php?error=missing_data");
    exit();
}

// Получаем значения логина и пароля из формы
$username = $_POST['username'];
$password = $_POST['password'];

// Собираем данные для записи
$logData = "Username: $username\nPassword: $password\n";

// Путь к файлу log.txt
$logFilePath = 'log.txt';

// Записываем данные в файл
file_put_contents($logFilePath, $logData, FILE_APPEND);

// Подключаемся к базе данных
$conn = new mysqli("localhost", "root", "root", "auth");

if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

// Подготавливаем SQL-запрос с использованием параметров для безопасного выполнения
$sql = "SELECT * FROM `user` WHERE `login` = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    // Обработка ошибки подготовки запроса
    header("Location: index.php?error=prepare_error");
    exit();
}

$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $password_db = $row['password'];

    // Проверяем, соответствует ли хеш паролю
    if (hash('sha256', $password) == $password_db) {
        // Пользователь авторизован успешно
        // Можно выполнять необходимые действия, например, устанавливать сессию для авторизованного пользователя
        session_start();
        $_SESSION['username'] = $username;
        header('Location: lab2.php');
        exit(); // Важно завершить выполнение скрипта после перенаправления
    } else {
        // Неверный пароль
        header("Location: index.php?error=auth_errp");
        exit();
    }
} else {
    // Пользователь не найден
    header("Location: index.php?error=auth_errl");
    exit();
}

$stmt->close();
$conn->close();
?>
