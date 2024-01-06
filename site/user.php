<!DOCTYPE HTML>

<?php
session_start();

$conn = new mysqli("localhost", "root", "root", "auth");

if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

if (isset($_GET['error'])) {
    $error_message = '';
    if ($_GET['error'] === 'mail_occupied') {
        $error_message = 'Почта уже занята.';
    }
    echo '<script>alert("' . $error_message . '");</script>';
    echo '<script>window.history.replaceState({}, document.title, "' . $_SERVER['PHP_SELF'] . '");</script>';
}


if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    // Необходимо обработать ситуацию, когда сессия не содержит ожидаемого значения
    header('Location: index.php');
    exit;
} else {
    $username = $_SESSION['username'];
    $query = "SELECT * FROM user WHERE login = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row['id'];
        $login = $row['login'];
        $password = $row['password'];
        $name = $row['name'];
        $mail = $row['mail'];
        $avatar = $row['avatar'];
    } else {
        echo "Пользователь не найден." . $login;
    }

    $stmt->close();
}

$updated = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = $_POST['mail'];
    $password_a = $_POST['password_a'];
    $password_c = $_POST['password_c'];
    $FIO = $_POST['FIO'];

    if ($password_a !== $password_c) {
        echo '<p>Пароли не совпадают.</p>';
    } else {
        // Проверяем, задан ли новый пароль
        if (!empty($password_a)) {
            // Хэшируем новый пароль
            $new_password = hash('sha256', $password_a);
        } else {
            // Если пароль не был изменен, оставляем старый пароль
            $query = 'SELECT password FROM user WHERE login = ?';
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $new_password = $row['password'];
            }
            $stmt->close(); // Закрываем оператор здесь
        }

        $query_check_email = 'SELECT id FROM user WHERE mail = ? AND login <> ?';
        $stmt_check_email = $conn->prepare($query_check_email);
        $stmt_check_email->bind_param('ss', $mail, $username);
        $stmt_check_email->execute();
        $result_check_email = $stmt_check_email->get_result();

        if ($result_check_email->num_rows > 0) {
            // Email уже занят, выведем сообщение об ошибке
            header('Location: user.php?error=mail_occupied');
            exit;
        }

        if ($_FILES && $_FILES["filename"]["error"] == UPLOAD_ERR_OK) {
            $name = 'userav/' . $username . basename($_FILES["filename"]["name"]);
            // Проверяем, что файл изображения
            $imageFileType = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
                if (move_uploaded_file($_FILES["filename"]["tmp_name"], $name)) {
                    $path = $name;
                    // Файл успешно загружен
                    echo "Файл успешно загружен: $path       ";
                    // Обновление данных в базе данных
                    $query = 'UPDATE user SET mail = ?, password = ?, name = ?, avatar = ? WHERE login = ?';
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('sssss', $mail, $new_password, $FIO, $path, $username);

                    $stmt->execute(); // Выполняем запрос на обновление
                    $stmt->close(); // Закрываем оператор после выполнения

                    header('Location: lab2.php');
                    exit;
                } else {
                    // Произошла ошибка при перемещении файла
                    echo "Ошибка при перемещении файла.";
                }
            } else {
                // Неверный формат файла
                echo "Неверный формат файла. Пожалуйста, загрузите изображение.";
            }
        } else {
            // Если файл не загружен, обновляем другие поля без файла
            $query = 'UPDATE user SET mail = ?, password = ?, name = ? WHERE login = ?';
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ssss', $mail, $new_password, $FIO, $username);

            $stmt->execute(); // Выполняем запрос на обновление
            $stmt->close(); // Закрываем оператор после выполнения

            header('Location: lab2.php');
            exit;
        }
    }
}

if ($updated) {
    echo '<p>Данные успешно обновлены.</p>';
    $updated = false;
}

if (isset($_POST['exet'])) {
    header('Location: lab2.php');
}

mysqli_close($conn);
?>




<head>
    <meta name="viewport" content="width = device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/style2.css">
    <link rel="stylesheet" href="style/adaptive/adaptive.css">
    <script src="js/script.js"></script>
    <script src="js/scr_user.js"></script>
</head>

<body>
    <div class="left-section">
        <div class="left-section--menu">
            <div class="left-section--menu--header">
                <div class="left-section--menu--header-symb">
                    <div class="left-section--menu--header--first-circle"></div>
                    <div class="left-section--menu--header--second-circle"></div>
                    <div class="left-section--menu--header--third-circle"></div>
                </div>
                <div class="left-section--menu--header--text">
                    <p class="left-section--menu--header--kappe">kappe</p>
                    <img class="left-section--menu--header--creative" src="images/for_creatives.png">
                </div>
            </div>
            <ul class="Blok">
                <li><a>HOME</a></li>
                <li><a>WORK</a></li>
                <li><a>ABOUT</a></li>
                <li><a>BLOG</a></li>
                <li><a>SERVICES</a></li>
                <li><a>CONTACT</a></li>
            </ul>
        </div>
        <div class="left-section--filter">
            <ul>
                <li>Filter <img id="left-section--filte--image" src="images/image_22.png" alt="icon"></li>
                <li><a style="color: aliceblue;">All Works</a></li>
                <li><a>web design</a></li>
                <li><a>illustartion</a></li>
                <li><a>photography</a></li>
                <li><a>wallpapers</a></li>
                <li><a>brochures</a></li>
            </ul>
        </div>
        <div class="left-section--social-icons">
            <img src="images/webicon-flickr.png" alt="icon">
            <img src="images/webicon-googleplus.png" alt="icon">
            <img src="images/webicon-twitter.png" alt="icon">
            <img src="images/webicon-pinterest.png" alt="icon">
            <img src="images/webicon-dribbble.png" alt="icon">
            <img src="images/webicon-behance.png" alt="icon">
            <img src="images/webicon-facebook.png" alt="icon">
        </div>
        <form method="post" action="">
            <input type="submit" class="login-btn" name="exet" value="Назад">
        </form>
        <p class="left-section--end-paragraphe">© 2014 Kappe, All Rights Reserved</p>
    </div>
    <div class="information">
        <svg class="information-first-symb" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
            <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-.001 5.75c.69 0 1.251.56 1.251 1.25s-.561 1.25-1.251 1.25-1.249-.56-1.249-1.25.559-1.25 1.249-1.25zm2.001 12.25h-4v-1c.484-.179 1-.201 1-.735v-4.467c0-.534-.516-.618-1-.797v-1h3v6.265c0 .535.517.558 1 .735v.999z" />
        </svg>
        <svg class="information-second-symb" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="m11.998 2c5.517 0 9.997 4.48 9.997 9.998 0 5.517-4.48 9.997-9.997 9.997-5.518 0-9.998-4.48-9.998-9.997 0-5.518 4.48-9.998 9.998-9.998zm0 1.5c-4.69 0-8.498 3.808-8.498 8.498s3.808 8.497 8.498 8.497 8.497-3.807 8.497-8.497-3.807-8.498-8.497-8.498z" fill-rule="nonzero" />
        </svg>
    </div>
    <div class="post">
        <div class="post-section">
            <!-- The Modal Reg-->
            <div id="CheModal" class="modal-c">
                <div class="modal-content-c">
                    <h2>Форма обновления</h2>
                    <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                        <label for="mail" class="text-loader">Почта:</label>
                        <input type="email" id="mail" name="mail" class="marginVN" value="<?= $mail ?>" required><br>

                        <label for="password_a" class="text-loader">Пароль:</label>
                        <input type="password" id="password_a" name="password_a" class="marginVN" value=""><br>

                        <label for="password_c" class="text-loader">Подтверждение пароля:</label>
                        <input type="password" id="password_c" name="password_c" class="marginVN" required><br>

                        <label for="FIO" class="text-loader">ФИО:</label>
                        <input type="text" id="FIO" name="FIO" class="marginVN" value="<?= $name ?>" required><br>

                        Выберите файл: <input type="file" name="filename" size="10" /><br /><br />
                        <text class="text-loader">Текущий аватар:</text> <img src="<?= $avatar ?>" alt="Current Avatar" style="max-width: 100px; max-height: 100px; min-width: 100px; min-height: 100px; margin-left: 50px;"><br />
                        <input type="submit" value="Изменить" name="chage" class="marginVN login-btn" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>