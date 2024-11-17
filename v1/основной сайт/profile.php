<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TESA Store | Профиль</title>
    <link rel="stylesheet" href="styles.css">
    <script src="app.js" defer></script> <!-- Подключение внешнего JS-файла -->
</head>
<body>

<div class="profile-page">
    <h2>Профиль</h2>
    <p>Логин: <?= $user['login'] ?></p>
    <p>Почта: <?= $user['email'] ?></p>
    <p>Номер аккаунта: <?= $user['id'] ?></p>
    <a href="logout.php">Выйти</a>
    
  
</div>

</body>
</html>
