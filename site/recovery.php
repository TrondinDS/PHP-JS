<?php
session_start(); 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем значения из формы
    $login = $_POST['loginrecovery'];
    // Устанавливаем время жизни сессии на сервере

    //Подключаемся к БД и проверяем подключение
    $conn = new mysqli("localhost", "root", "root", "auth");
    if ($conn->connect_error) {
        die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }

    // Подготавливаем запрос на проверку занятости логина
    $login_check_query = $conn->prepare("SELECT * FROM user WHERE login=? LIMIT 1");
    $login_check_query->bind_param('s', $login);
    $login_check_query->execute();
    $login_check_result = $login_check_query->get_result();

    if ($login_check_result->num_rows > 0) {
        $confirmationCode = mt_rand(1000, 9999);
        // Сохранение кода и логина в файле code.txt
        $userData = array(
            'login' => $login,
            'confirmationCode' => $confirmationCode,
            'code_creation_time' => time()
        );

        // Сохранение данных в файле code.txt
        $codeData = json_encode($userData) . "\n";
        file_put_contents('code.txt', $codeData, FILE_APPEND);

        // Отправка кода на почту пользователя
        //$to = "почта_пользователя@example.com"; // Получите почту пользователя из базы данных
        //$subject = "Код подтверждения для восстановления пароля";
        //$message = "Ваш код подтверждения: $confirmationCode";
        //mail($to, $subject, $message);

        // Сохранение логина и кода в сессии
        $_SESSION['recovery_data'] = $userData;

        // Перенаправление пользователя на страницу подтверждения
        header("Location: cc.php");
        exit();
    }
}
