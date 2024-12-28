<?php

$host = "localhost";
$dbname = "flowershop";
$username = "root";
$password = "";
try {
    $pdo = new PDO('mysql:host=localhost;dbname=flowershop', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
?>

