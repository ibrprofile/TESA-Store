<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM dev_users WHERE phone = ?");
    $stmt->execute([$phone]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php');
    } else {
        echo "Неверный номер телефона или пароль.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация в Панели Разработчика TESA Store</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
  
    <div class="container">
        <h2>Авторизация</h2>
        <form method="POST" action="login.php">
            <input type="text" name="phone" placeholder="Номер телефона" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit">Войти</button>
        </form>
        <a href="register.php">Еще нет аккаунта? Зарегистрируйтесь здесь.</a>
    </div>
</body>
</html>
