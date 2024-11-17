<?php
$host = '';
$db = '';
$user = '';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db;charset=utf8";
$pdo = new PDO($dsn, $user, $pass);
?>
