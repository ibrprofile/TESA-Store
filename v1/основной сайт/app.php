<?php
session_start();

// Подключение к базе данных
$conn = new mysqli("", "", "", "");

// Проверка авторизации
if (!isset($_SESSION['user'])) {
    $isAuthenticated = false;
} else {
    $isAuthenticated = true;
    $user = $_SESSION['user']; // Данные авторизованного пользователя
}

// Получаем информацию о приложении
$app_id = $_GET['id'];
$app_result = $conn->query("SELECT * FROM apps WHERE id = $app_id");
$app = $app_result->fetch_assoc();

// Получаем отзывы
$reviews_result = $conn->query("SELECT * FROM reviews WHERE app_id = $app_id");

// Рассчёт рейтинга
if ($app['reviews_quantity'] > 0) {
    $rating = round($app['reviews_value'] / $app['reviews_quantity'], 2);
} else {
    $rating = 'Нет оценок';
}
 // Получаем название категории
$category_id = $app['category'];  // ID категории из таблицы apps
$category_result = $conn->query("SELECT category_name FROM categories WHERE id = $category_id");
$category = $category_result->fetch_assoc()['category_name'];

 // Получаем название категории
$developer_id = $app['dev_id'];  // ID категории из таблицы apps
$company_name_result = $conn->query("SELECT company FROM dev_users WHERE id = $developer_id");
$company_name = $company_name_result->fetch_assoc()['company'];


 

// Форматирование скачиваний
function formatDownloads($downloads) {
    return number_format($downloads, 0, '.', '.'); // Отделяем разряды точками
}

$formatted_downloads = formatDownloads($app['downloads']);

// Проверка оставленного отзыва
if ($isAuthenticated) {
    $user_result = $conn->query("SELECT reviews_have FROM users WHERE id = {$user['id']}");
    $user_data = $user_result->fetch_assoc();
    $reviewed_apps = explode(',', $user_data['reviews_have']);
    $hasReviewed = in_array($app_id, $reviewed_apps);
} else {
    $hasReviewed = false;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TESA Store | <?= htmlspecialchars($app['title']) ?></title>
    <link rel="stylesheet" href="styles.css">
    <script src="app.js" defer></script> <!-- Подключение внешнего JS-файла -->
</head>
<header>
    <div class="logo-container">
        <a href="index.php" class="store-name">TESA Store</a>
    </div>
    <a href="profile.php"><img src="profile.png" alt="Profile" class="profile-icon"></a>
</header>
<body>
    
<div class="app-details">
    
    <img src="<?= htmlspecialchars($app['logo']) ?>" alt="<?= htmlspecialchars($app['full_title']) ?>" class="app-logo-large">
    <h1><?= htmlspecialchars($app['full_title']) ?></h1>
    <h2>
        <!-- Проверка статуса приложения -->
        <?php if ($app['verif'] == 1): ?>
            <img src="img/icons/verif_1.png" alt="Verified" class="verif-icon">
            <span class="verif-text">Проверенное приложение</span>
        <?php elseif ($app['verif'] == 2): ?>
            <img src="img/icons/verif_2.png" alt="Verified" class="verif-icon">
            <span class="verif-text">Уникальное приложение</span>
        <?php elseif ($app['verif'] == 3): ?>
            <img src="img/icons/verif_3.png" alt="Verified" class="verif-icon">
            <span class="verif-text">От команды TESA GAMES</span>
        <?php endif; ?>
    </h2>
    
<div class="but-app">
    <button onclick="downloadApp(<?= $app_id ?>)">Скачать</button>
    <button id="shareButton" onclick="copyLink()">Поделиться</button>
</div>
    <p><strong>Описание:</strong> <?= htmlspecialchars($app['description']) ?></p>
    
   
   

    <p><strong>Категория:</strong> <?= htmlspecialchars($category) ?></p>
    <p><strong>Скачиваний:</strong> <?= $formatted_downloads ?></p>
    <p><strong>Рейтинг:</strong> <?= $rating ?></p>
    <p><strong>Возрастные ограничения:</strong> <?= htmlspecialchars($app['age']) ?></p>
    
    <p><strong>Автор:</strong> <?= htmlspecialchars($company_name) ?></p>
    <p><strong>Требования:</strong> <?= htmlspecialchars($app['requirements']) ?></p>
    <p><strong>Версия:</strong> <?= htmlspecialchars($app['version']) ?></p>
    <p><strong>Дата и время публикации:</strong> <?= htmlspecialchars($app['time']) ?></p>

    

    <!-- Скриншоты на всю ширину экрана -->
    <div class="screenshots">
        <img src="<?= htmlspecialchars($app['screen1']) ?>" alt="Screenshot 1">
        <img src="<?= htmlspecialchars($app['screen2']) ?>" alt="Screenshot 2">
        <img src="<?= htmlspecialchars($app['screen3']) ?>" alt="Screenshot 3">
    </div>

    
</div>

<script>
function copyLink() {
    navigator.clipboard.writeText(window.location.href);
    const shareButton = document.getElementById('shareButton');
    shareButton.innerText = 'Скопировано';
    shareButton.style.backgroundColor = 'gray';
}

function downloadApp(appId) {
    window.location.href = '<?= htmlspecialchars($app['download_link']) ?>';

    // Отправка запроса на обновление количества скачиваний
    fetch('update_downloads.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ app_id: appId }),
    });
}
</script>

</body>
</html>
