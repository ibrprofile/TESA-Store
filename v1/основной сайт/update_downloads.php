<?php
// Подключение к базе данных
$conn = new mysqli("", "", "", "");


// Получаем данные из запроса
$data = json_decode(file_get_contents('php://input'), true);
$app_id = $data['app_id'];

// Обновляем количество скачиваний
$conn->query("UPDATE apps SET downloads = downloads + 1 WHERE id = $app_id");
?>
