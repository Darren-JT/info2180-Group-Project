<?php
require_once '../includes/database_connection_logic;
require_once '../includes/check_admin.php';

$stmt = $conn->query("SELECT firstname, lastname, email, role, created_at FROM Users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);
?>