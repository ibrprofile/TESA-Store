<?php
// Подключение к базе данных
$conn = new mysqli("85.193.87.122", "tesamarket", "Ggjksu29-=", "tesamarket");

// Получаем данные для скроллируемых блоков
$blocks_result = $conn->query("SELECT * FROM dev_news");

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель разработчика TESA Store</title>
    <link rel="stylesheet" href="styles.css">
</head>
<header>
    <div class="logo-container">
        <a href="index.php" class="store-name">Панель разработчиков TESA Store</a>
    </div>
    
</header>
<body>
    <div class="container">
        <h1>Панель Разработчика TESA Store</h1>

        <div class="buttons">
            <a href="profile.php" class="button">Личный кабинет</a>
            <a href="apps.php" class="button">Приложения</a>
        </div>
    </div>
   
</body>
</html>
