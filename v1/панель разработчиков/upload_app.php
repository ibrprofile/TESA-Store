<?php
session_start();
include 'db.php';





if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $full_title = $_POST['full_title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $age = $_POST['age'];
    $requirements = $_POST['requirements'];
    
    function generateUniqueFileId($length = 100) {
        $uniqueIds = [];
        
        while (count($uniqueIds) < 1) { // Генерируем только одно уникальное число
            $file_id = '';
            
            for ($i = 0; $i < $length; $i++) {
                // Генерируем случайную цифру от 0 до 9
                $file_id .= random_int(0, 9);
            }
            
            // Проверяем, уникально ли сгенерированное число
            if (!in_array($file_id, $uniqueIds)) {
                $uniqueIds[] = $file_id; // Добавляем уникальное число в массив
                return $file_id; // Возвращаем уникальный app_id
            }
        }
    }

    // Пример использования
    $file_id = generateUniqueFileId();
  
    
   

    // Загрузка логотипа и скриншотов
    $dev_id = $_SESSION['user_id'];
    $upload_dir_url_img = 'https://tesagames.ru/dev.store/uploads/' . $file_id . '/';
    $upload_dir = 'uploads/' . $file_id . '/';
    mkdir($upload_dir, 0777, true);
    
    
    $logo_url = $upload_dir_url_img . 'logo.png';
    $screen1_url = $upload_dir_url_img . '1.png';
    $screen2_url = $upload_dir_url_img . '2.png';
    $screen3_url = $upload_dir_url_img . '3.png';

    $logo = $upload_dir . 'logo.png';
    move_uploaded_file($_FILES['logo']['tmp_name'], $logo);

    $screen1 = $upload_dir . '1.png';
    move_uploaded_file($_FILES['screen1']['tmp_name'], $screen1);

    $screen2 = $upload_dir . '2.png';
    move_uploaded_file($_FILES['screen2']['tmp_name'], $screen2);

    $screen3 = $upload_dir . '3.png';
    move_uploaded_file($_FILES['screen3']['tmp_name'], $screen3);

    // Загрузка APK
    $upload_dir_url_apk = 'https://tesagames.ru/dev.store/uploads/' . $file_id . '/';
    $apk_dir = 'uploads/' . $file_id . '/';
    mkdir($apk_dir, 0777, true);
    $apk_file = $apk_dir . 'tesastore_load.apk';
    move_uploaded_file($_FILES['apk']['tmp_name'], $apk_file);
    
    $apk_file_url = $upload_dir_url_apk . 'tesastore_load.apk';

    // Запись в таблицу dev_moderating
    $stmt = $pdo->prepare("INSERT INTO apps (dev_id, title, full_title, description, logo, screen1, screen2, screen3, category, age, requirements, download_link, file_id, time) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$dev_id, $title, $full_title, $description, $logo_url, $screen1_url, $screen2_url, $screen3_url, $category, $age, $requirements, $apk_file_url, $file_id]);

     header('Location: apps.php');

    


  
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить приложение | Панель разработчика TESA Store</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
     
    <div id="dialog-container" style="display: none;"></div>

    <div class="container">
        <h2>Добавить приложение</h2>
        <form method="POST" action="upload_app.php" enctype="multipart/form-data">
            <label>Введите короткое название (отображается в списке приложений) *</label>
            <input type="text" name="title" placeholder="макс. 20 символов" maxlength="20" required>
            <label>Введите полное название (отображается в карточке приложения) *</label>
            <input type="text" name="full_title" placeholder="макс. 36 символов" maxlength="36" required>
            <label>Введите описание *</label>
            <textarea name="description" placeholder="макс. 4000 символов" maxlength="4000" required></textarea>

            <label>Загрузите логотип *</label>
            <input type="file" name="logo" required>

            <label>Загрузите скриншот №1 *</label>
            <input type="file" name="screen1" required>
            <label>Загрузите скриншот №2</label>
            <input type="file" name="screen2">
            <label>Загрузите скриншот №3</label>
            <input type="file" name="screen3">

            <label>Выберите категорию *</label>
            <select name="category" required>
                <!-- Категории из таблицы categories -->
                <?php
                $stmt = $pdo->query("SELECT * FROM categories");
                while ($row = $stmt->fetch()) {
                    echo "<option value='{$row['id']}'>{$row['category_name']}</option>";
                }
                ?>
            </select>

            <label>Возрастные ограничения *</label>
            <select name="age" required>
                <option value="0+">0+</option>
                <option value="6+">6+</option>
                <option value="12+">12+</option>
                <option value="16+">16+</option>
                <option value="18+">18+</option>
            </select>
            
            <label>Введите требования для устройств *</label>
            <textarea name="requirements" placeholder="макс. 200 символов" maxlength="200"></textarea>

            <label>Загрузите APK *</label>
            <input type="file" name="apk" required>

            <button type="submit">Отправить на модерацию</button>
        </form>


    </div>
    <div id="notification" class="notification hidden">
    <div class="notification-content">
        <span id="notif-message"></span>
        <div id="progress-bar" class="progress-bar"></div>
    </div>
</div>

</body>
</html>
