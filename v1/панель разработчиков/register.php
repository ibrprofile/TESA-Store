<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $surname = $_POST['surname'];
    $name = $_POST['name'];
    $patronymic = $_POST['patronymic'];
    $birthdate = $_POST['birthdate'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $company = $_POST['company'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Проверка уникальности данных
    $check_phone = $pdo->prepare("SELECT * FROM dev_users WHERE phone = ?");
    $check_phone->execute([$phone]);

    $check_email = $pdo->prepare("SELECT * FROM dev_users WHERE email = ?");
    $check_email->execute([$email]);

    $check_company = $pdo->prepare("SELECT * FROM dev_users WHERE company = ?");
    $check_company->execute([$company]);

    if ($check_phone->rowCount() > 0 || $check_email->rowCount() > 0 || $check_company->rowCount() > 0) {
        echo "Номер телефона, почта или компания уже зарегистрированы.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO dev_users (surname, name, patronymic, birthdate, phone, email, company, password) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$surname, $name, $patronymic, $birthdate, $phone, $email, $company, $password]);

        header('Location: login.php');
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация в Панели Разработчика TESA Store</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
    <div class="logo-container">
        <a href="index.php" class="store-name">Панель разработчиков TESA Store</a>
    </div>
    
</header>
    <div class="container">
        <h2>Регистрация разработчика</h2>
        <form method="POST" action="register.php">
            <input type="text" name="surname" placeholder="Фамилия" required>
            <input type="text" name="name" placeholder="Имя" required>
            <input type="text" name="patronymic" placeholder="Отчество">
            <input type="date" name="birthdate" placeholder="Дата рождения" required>
            <input type="text" name="phone" placeholder="Номер телефона" required>
            <input type="email" name="email" placeholder="Почта" required>
            <input type="url" name="telegram" placeholder="Ссылка на ваш телеграм" required>
            <input type="text" name="company" placeholder="Название компании/студии" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <div class="notif_data">
            <p><b>Указывайте реальные данные, они проверяются модератором.</b></p>
        </div>
            <button type="submit">Зарегистрироваться</button>
        </form>
        
        <div class="have_acc_text">
            <a href="login.php">Уже зарегистрированы? Авторизуйтесь здесь.</a>
        </div>
        
    </div>
</body>
</html>
