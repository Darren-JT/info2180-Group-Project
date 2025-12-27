<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'dolpin_crm';

try {
    $conn = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>