<?php
// Database configuration

$dbHost = 'localhost';
$dbName = 'parane1';
$dbUsername = 'root';
$dbPassword = '';
/*
$host = 'localhost';
$dbname = 'u593341949_db_parane';
$username = 'u593341949_dev_parane';
$password = '20212088Parane';
*/
try {
    $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName}", $dbUsername, $dbPassword);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
