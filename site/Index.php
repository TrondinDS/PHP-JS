<!DOCTYPE HTML>

<?php
// Проверяем, есть ли параметр ошибки в URL
if (isset($_GET['error'])) {
    $error_message = '';
    if ($_GET['error'] === 'mail_occupied') {
        $error_message = 'Почта уже занята.';
    }
    if ($_GET['error'] === 'login_occupied') {
        $error_message = 'Логин уже занят.';
    }
    if ($_GET['error'] === 'auth_errl') {
        $error_message = 'Вы ввели неверные логин';
    }
    if ($_GET['error'] === 'auth_errp') {
        $error_message = 'Вы ввели неверные пароль';
    }
    echo '<script>alert("' . $error_message . '");</script>';
    echo '<script>window.history.replaceState({}, document.title, "' . $_SERVER['PHP_SELF'] . '");</script>';
}
?>

<head>
    <meta name="viewport" content="width = device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/style2.css">
    <link rel="stylesheet" href="style/adaptive/adaptive.css">
    <script src="js/script.js">

    </script>
    <script src="js/scr_index.js">

    </script>
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
        <?php
        require_once 'Connection.php'; // Подключаем файл с настройками подключения к базе данных
        session_start(); // Запускаем сессию
        // Проверяем, авторизован ли пользователь
        if (isset($_SESSION['username'])) { // Проверяем наличие переменной в сессии
            header("Location: lab2.php"); // Перенаправляем на страницу "lab2.php" в случае авторизации
        } else {
            // Display the login button
            echo
            '
                <button class="login-btn" onclick="openModal()">Вход</button>
            ';
        }
        ?>
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


            <!-- The Modal Ayth-->
            <div id="loginModal" class="modal">
                <div class="modal-content">
                    <h2>Форма авторизации</h2>
                    <form action="auth.php" method="post">
                        <label for="username" class="text-loader">Логин:</label>
                        <input type="text" id="username" name="username" class="marginVN" required><br>

                        <label for="password" class="text-loader">Пароль:</label>
                        <input type="password" id="password" name="password" class="marginVN" required><br>

                        <input type="submit" value="Войти" class="marginVN login-btn">
                    </form>
                    <button class="login-btn" onclick="openModalR()">Регистрация</button>
                    <button class="login-btn" onclick="openModalRec()" style="margin-bottom: 15px;">Востановление пароля</button>
                    <button onclick="closeModal()" class="marginVN login-btn">Закрыть</button>
                </div>
            </div>

            <!-- The Modal Reg-->
            <div id="RegModal" class="modal-r">
                <div class="modal-content-r">
                    <h2>Форма регистрации</h2>
                    <form action="reg.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                        <label for="mail" class="text-loader">Почта:</label>
                        <input type="email" id="mail" name="mail" class="marginVN" required><br>

                        <label for="login" class="text-loader">Логин:</label>
                        <input type="text" id="login" name="login" class="marginVN" required><br>

                        <label for="password_a" class="text-loader">Пароль:</label>
                        <input type="password" id="password_a" name="password_a" class="marginVN" required><br>

                        <label for="password_c" class="text-loader">Подтверждение пароля:</label>
                        <input type="password" id="password_c" name="password_c" class="marginVN" required><br>

                        <label for="FIO" class="text-loader">ФИО:</label>
                        <input type="text" id="FIO" name="FIO" class="marginVN" required><br>

                        Выберите файл: <input type="file" name="filename" size="10" /><br /><br />
                        <input type="submit" value="Регистрация" class="marginVN login-btn" />
                    </form>
                    <button onclick="closeModalR()" class="marginVN login-btn">Отмена</button>
                </div>
            </div>

            <!-- The Modal Rec-->
            <div id="RecModal" class="modal-r">
                <div class="modal-content-r">
                    <h2>Востановление пароля</h2>
                    <form action="recovery.php" method="post" enctype="multipart/form-data">
                        <label for="loginrecovery" class="text-loader">Почта:</label>
                        <input type="text" id="loginrecovery" name="loginrecovery" class="marginVN" required><br>
                        <input type="submit" value="Востановление" class="marginVN login-btn" />
                    </form>
                    <button onclick="closeModalRec()" class="marginVN login-btn">Отмена</button>
                </div>
            </div>
        </div>
    </div>
</body>