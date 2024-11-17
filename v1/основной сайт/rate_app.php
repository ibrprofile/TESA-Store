<?php
session_start();
if (isset($_POST['app_id']) && isset($_POST['rating']) && isset($_SESSION['user'])) {
    $conn = new mysqli("", "", "", "");


    $app_id = $_POST['app_id'];
    $rating = (int)$_POST['rating'];

    // Обновляем количество оценок и общий рейтинг
    $conn->query("UPDATE apps SET reviews_value = reviews_value + $rating, reviews_quantity = reviews_quantity + 1 WHERE id = $app_id");

    header("Location: app.php?id=$app_id");
}
?>
