<?php
// Подключение к базе данных
$conn = new mysqli("", "", "", "");


// Получаем приложения из базы данных
$apps_result = $conn->query("SELECT * FROM apps WHERE public = 1 ORDER BY id DESC");

// Получаем данные для скроллируемых блоков
$blocks_result = $conn->query("SELECT * FROM blocks");

// Получаем данные для скроллируемых блоков
$events_result = $conn->query("SELECT * FROM events");


// Получаем приложения для раздела Хиты
$hits_result = $conn->query("SELECT * FROM apps WHERE hit = 1");

// Получаем приложения для раздела Хиты
$up_result = $conn->query("SELECT * FROM apps WHERE up = 1");

// Получаем приложения прошедшие модерацию
$publick_result = $conn->query("SELECT * FROM apps WHERE public = 1");

// Получаем категории
$categories_result = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TESA Store</title>
    <link rel="stylesheet" href="styles.css">
    <script src="app.js" defer></script> <!-- Подключение внешнего JS-файла -->
    
    
    
</head>
<body>

<header>
    <div class="logo-container">
        <a href="index.php"><img src="img/icons/logo_fon.png" alt="Logo" class="logo"></a>
        
        <a href="index.php" class="store-name">TESA Store</a>
        
    </div>
    <a href="profile.php"><img src="profile.png" alt="Profile" class="profile-icon"></a>
 
</header>

<!-- Скроллируемые блоки -->
<div class="scrollable-blocks">
    <?php while ($block = $blocks_result->fetch_assoc()): ?>
    <div class="scrollable-item" style="background-image: url('<?= $block['image_url'] ?>');">
        <img src="<?= $block['logo_url'] ?>" alt="Logo" class="block-logo">
        <h4><?= htmlspecialchars($block['app_name']) ?></h4>
        <button onclick="location.href='app.php?id=<?= $block['app_id'] ?>';">Скачать</button>
    </div>
    <?php endwhile; ?>
</div>

<!-- Раздел Хиты -->
<div class="hits-section">
    <hr> <!-- Верхняя линия -->
    <h2>Хиты</h2>
    <div class="hits-grid">
        <?php while ($hit = $hits_result->fetch_assoc()): ?>
        <div class="hit-item" onclick="location.href='app.php?id=<?= $hit['id'] ?>';">
            <img src="<?= $hit['logo'] ?>" alt="Logo" class="hit-logo">
            <h4><?= htmlspecialchars($hit['title']) ?></h4>
        </div>
        <?php endwhile; ?>
    </div>
    <hr> <!-- Нижняя линия -->
</div>


<!-- Список приложений up -->
<div class="app-list" id="appList">
    <?php while($app = $up_result->fetch_assoc()): ?>
    <div class="app-card" onclick="location.href='app.php?id=<?= $app['id'] ?>';" data-title="<?= strtolower($app['title']) ?>" data-category="<?= $app['category'] ?>">
        <img src="<?= $app['logo'] ?>" alt="<?= $app['title'] ?>" class="app-logo">
        <h4><?= htmlspecialchars($app['title']) ?></h4>
      
        
    </div>
    <?php endwhile; ?>
</div>
 <hr> 
 
<!-- Фильтр по категориям -->
<div class="category-filter">
    <!-- Добавляем кнопку "Все" для отображения всех приложений -->
    <button class="category-button" onclick="filterByCategory('all')">Все</button>
    
    <?php while ($category = $categories_result->fetch_assoc()): ?>
    <button class="category-button" onclick="filterByCategory('<?= $category['id'] ?>')">
        <?= htmlspecialchars($category['category_name']) ?>
    </button>
    <?php endwhile; ?>
</div>
<div class="search-bar">
    <input type="text" placeholder="Искать приложения..." id="search" onkeyup="searchApps()">
</div>
<!-- Список приложений -->
<div class="app-list" id="appList">
    <?php while($app = $apps_result->fetch_assoc()): ?>
    <div class="app-card" onclick="location.href='app.php?id=<?= $app['id'] ?>';" data-title="<?= strtolower($app['title']) ?>" data-category="<?= $app['category'] ?>">
        <img src="<?= $app['logo'] ?>" alt="<?= $app['title'] ?>" class="app-logo">
        <h4><?= htmlspecialchars($app['title']) ?></h4>
    </div>
    <?php endwhile; ?>
</div>
<script src="border.js"></script>
<script>
const box = document.getElementById('box');
    const toggleButton = document.getElementById('toggleButton');
    let isRounded = true;

    toggleButton.addEventListener('click', () => {
        isRounded = !isRounded;
        box.classList.toggle('no-border-radius', !isRounded);
        toggleButton.textContent = isRounded ? 'Отключить обводку' : 'Включить обводку';
    });
// Функция поиска приложений
function searchApps() {
    let input = document.getElementById('search').value.toLowerCase();
    let apps = document.querySelectorAll('.app-card');
    
    apps.forEach(function(app) {
        let title = app.getAttribute('data-title');
        
        if (title.includes(input)) {
            app.style.display = 'block';
        } else {
            app.style.display = 'none';
        }
    });
}

// Фильтрация приложений по категории
function filterByCategory(categoryId) {
    let apps = document.querySelectorAll('.app-card');
    
    apps.forEach(function(app) {
        let appCategory = app.getAttribute('data-category');
        
        if (categoryId === 'all' || appCategory == categoryId) {
            app.style.display = 'block';
        } else {
            app.style.display = 'none';
        }
    });
}
</script>

</body>
</html>

