<?php
session_start();

// Проверка наличия сессии с данными для восстановления
if (!isset($_SESSION['recovery_data'])) {
    // Если сессия отсутствует, перенаправляем пользователя на страницу восстановления
    header("Location: recovery.php");
    exit();
}

// Получение данных из сессии
$userData = $_SESSION['recovery_data'];
$login = $userData['login'];
$expectedCode = $userData['confirmationCode'];

// Проверка времени жизни кода
if (isset($userData['code_creation_time'])) {
    $codeCreationTime = $userData['code_creation_time'];
    $expirationTime = 60; // Время в секундах (10 секунд)

    if (time() - $codeCreationTime > $expirationTime) {
        // Код устарел
        unset($_SESSION['recovery_data']);
        header("Location: index.php");
        exit();
    }
}

// Проверка введенного кода
if (isset($_POST['pass']) && isset($_SESSION['recovery_data'])) {
    $enteredCode = $_POST['new_password'];
    if ($enteredCode == $expectedCode) {
        // Очистка сессии после успешного подтверждения
        unset($_SESSION['recovery_data']);
        $_SESSION['username'] = $login;
        header('Location: user.php');
        exit(); // Важно завершить выполнение скрипта после перенаправления
    } else {
        // Неправильный код, вы можете обработать ошибку или предоставить пользователю еще одну попытку
        $error = "Неправильный код подтверждения. Попробуйте еще раз.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Смена пароля</title>
</head>

<body>
    <h2>Смена пароля для пользователя: <?php echo $login; ?></h2>
    <form method="post">
        <label for="new_password">Новый пароль:</label>
        <input type="password" id="new_password" name="new_password" required><br>
        <input type="submit" name="pass" value="Сменить пароль">
    </form>
</body>

</html>
