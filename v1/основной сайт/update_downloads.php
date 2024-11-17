<?php
// Подключение к базе данных
$conn = new mysqli("85.193.87.122", "tesamarket", "Ggjksu29-=", "tesamarket");

// Получаем данные из запроса
$data = json_decode(file_get_contents('php://input'), true);
$app_id = $data['app_id'];

// Обновляем количество скачиваний
$conn->query("UPDATE apps SET downloads = downloads + 1 WHERE id = $app_id");
?>
