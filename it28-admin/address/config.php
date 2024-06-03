<?php
// config.php

// $host = 'localhost';
// $dbname = 'hinoyog';
// $username = 'root';
// $password = '';

$host = 'localhost';
$dbname = 'u593341949_db_hinoyog';
$username = 'u593341949_dev_hinoyog';
$password = '20211395Hinoyog';

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}
?>
