<!DOCTYPE html>
<?php
// Проверяем, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем значения из формы
    $mail = $_POST['mail'];
    $login = $_POST['login'];
    $password = $_POST['password_a'];
    $password_c = $_POST['password_c'];
    $fio = $_POST['FIO'];

    //Подключаемся к БД и проверяем подключение
    $conn = new mysqli("localhost", "root", "root", "auth");
    if ($conn->connect_error) {
        die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }

    // Подготавливаем запрос на проверку занятости почты
    $mail_check_query = $conn->prepare("SELECT * FROM user WHERE mail=? LIMIT 1");
    $mail_check_query->bind_param('s', $mail);
    $mail_check_query->execute();
    $mail_check_result = $mail_check_query->get_result();

    // Подготавливаем запрос на проверку занятости логина
    $login_check_query = $conn->prepare("SELECT * FROM user WHERE login=? LIMIT 1");
    $login_check_query->bind_param('s', $login);
    $login_check_query->execute();
    $login_check_result = $login_check_query->get_result();

    if ($mail_check_result->num_rows > 0) {
        // Почта уже занята
        header("Location: index.php?error=mail_occupied");
        exit();
    }
    if ($login_check_result->num_rows > 0) {
        // Логин уже занят
        header("Location: index.php?error=login_occupied");
        exit();
    }

    // Проверяем, загружен ли файл
    if ($_FILES && $_FILES["filename"]["error"] == UPLOAD_ERR_OK) {

        $name = 'userav/' . $login . $_FILES["filename"]["name"];
        // Перемещаем файл в целевую папку
        if (move_uploaded_file($_FILES["filename"]["tmp_name"], $name)) {
            $path = $name;
            // Файл успешно загружен
            echo "Файл успешно загружен: $path       ";
            $password = hash( 'sha256', $password );

            // Подготавливаем запрос на вставку данных
            $insert_query = $conn->prepare("INSERT INTO user (login, password, name, mail, avatar) VALUES (?, ?, ?, ?, ?)");
            $insert_query->bind_param('sssss', $login, $password, $fio, $mail, $path);

            if ($insert_query->execute()) {
                echo "Файл успешно загружен и данные добавлены в базу данных.     ";
                session_start();
                $_SESSION['username'] = $login;
                header('Location: lab2.php');
            } else {
                echo "Ошибка при добавлении данных в базу данных: " . $insert_query->error;
            }
        } else {
            // Произошла ошибка при перемещении файла
            echo "Ошибка при перемещении файла.";
        }
    } else {
        // Файл не был загружен или произошла ошибка при загрузке
        echo "Ошибка при загрузке файла.";
    }

    // Закрываем prepared statements
    $mail_check_query->close();
    $login_check_query->close();
    $insert_query->close();
}
?>
