<!DOCTYPE HTML>

<?php
session_start();

// Проверяем, существует ли сессия с именем пользователя
if (!isset($_SESSION['username'])) {
    // Пользователь не авторизован, перенаправляем на страницу index.php
    header('Location: index.php');
    exit(); // Важно прекратить выполнение скрипта после перенаправления
}

// Если пользователь авторизован, продолжаем выполнение остального кода страницы
?>

<head>
    <meta name="viewport" content="width = device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/style2.css">
    <link rel="stylesheet" href="style/adaptive/adaptive.css">
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
            <input type="submit" class = "login-btn" name="logout" value="Выйти">
        </form>

        <button onclick= "window.location.href = 'user.php'" class="marginVN login-btn">Профиль</button>

        <?php
        // Обработчик кнопки очистки сессии
        if (isset($_POST['logout'])) {
            // Очищаем все данные сессии
            session_unset();
            // Уничтожаем сессию
            session_start();
            session_destroy();
            
            echo '<p>Сессия успешно очищена.</p>';
            header('Location: index.php');
            exit;
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
            <body onload="PrintCheckBox()">
                <div id="checkBoxList" class="checkBoxDiv checkBoxDiv_Colum"></div>
                <div id="nameList" class="list"></div>
                <script src="js/script.js"></script>
            </body>
        </div>
    </div>
</body>