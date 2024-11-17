<?php
session_start();
// Подключение к базе данных
$conn = new mysqli("", "", "", "");


// Проверка, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    echo "Только авторизованные пользователи могут оставлять отзывы.";
    exit;
}

// Проверка, отправлена ли форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $app_id = $_POST['app_id'];  // ID приложения, которому оставляется отзыв
    $review_text = trim($_POST['review']); // Текст отзыва

    if (empty($review_text)) {
        echo "Поле отзыва не должно быть пустым.";
        exit;
    }

    // Подготовка и выполнение запроса на добавление отзыва
    $stmt = $conn->prepare("INSERT INTO reviews (app_id, user_id, review_text, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iis", $app_id, $user_id, $review_text);

    if ($stmt->execute()) {
        // Успешное добавление отзыва
        header("Location: app_details.php?id=$app_id");
        exit;
    } else {
        echo "Ошибка при добавлении отзыва: " . $conn->error;
    }
} else {
    echo "Неверный метод отправки запроса.";
}
?>
