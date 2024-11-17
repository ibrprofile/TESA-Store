<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM dev_users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет разработчика TESA Store</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Личный кабинет</h2>
        <p><b>ФИО:</b> <?php echo $user['surname']; ?> <?php echo $user['name']; ?> <?php echo $user['patronymic']; ?></p>
        <p><b>Дата рождения:</b> <?php echo $user['birthdate']; ?></p>
        <p><b>Почта:</b> <?php echo $user['email']; ?></p>
        <p><b>Ваша компания:</b> <?php echo $user['company']; ?></p>
        <p><b>Номер телефона:</b> <?php echo $user['phone']; ?></p>
        <p><b>Ваш телеграм:</b> <?php echo $user['telegram']; ?></p>
        <p><b>Номер разработчика в Панели Разработчика TESA Store:</b> <?php echo $user['id']; ?></p>
        <a href="index.php" class="button">В главное меню</a>
    </div>
</body>
</html>
