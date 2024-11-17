<?php
session_start();
include 'db.php';


$user_id = $_SESSION['user_id'];

// Проверка приложений
$stmt = $pdo->prepare("SELECT * FROM apps WHERE dev_id = ? AND public = 1");
$stmt->execute([$user_id]);
$apps = $stmt->fetchAll();

// Проверка на модерации
$moderation_stmt = $pdo->prepare("SELECT * FROM apps WHERE dev_id = ? AND public = 0");
$moderation_stmt->execute([$user_id]);
$moderating_apps = $moderation_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои Приложения | Панель разработчика TESA Store</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <div class="container">
        <h2>Мои приложения</h2>
        <?php if (empty($apps)) { ?>
            <p>У вас нет приложений.</p>
        <?php } else { ?>
            <ul>
                <?php foreach ($apps as $app) { ?>
                    <li><?php echo $app['title']; ?></li>
                <?php } ?>
            </ul>
        <?php } ?>

        <h2>На модерации</h2>
        <?php if (empty($moderating_apps)) { ?>
            <p>Нет приложений на модерации.</p>
        <?php } else { ?>
            <ul>
                <?php foreach ($moderating_apps as $mod_app) { ?>
                    <li><?php echo $mod_app['title']; ?></li>
                <?php } ?>
            </ul>
        <?php } ?>

        <a href="upload_app.php" class="button">Добавить приложение</a>
    </div>
</body>
</html>
