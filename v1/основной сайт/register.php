<?php
$conn = new mysqli("", "", "", "");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $conn->query("INSERT INTO users (name, surname, login, email, password) VALUES ('$name', '$surname', '$login', '$email', '$password')");
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="auth-form">
    <h2>Регистрация</h2>
    <hr> <!-- Верхняя линия -->
    <form method="POST">
        <input type="text" name="name" placeholder="Имя" required>
        <input type="text" name="surname" placeholder="Фамилия" required>
        <input type="text" name="login" placeholder="Логин" required>
        <input type="email" name="email" placeholder="Почта" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <hr> <!-- Нижняя линия -->
        <button type="submit">Зарегистрироваться</button>
    </form>
    <a href="login.php">Уже есть аккаунт? Войти</a>
</div>

</body>
</html>
