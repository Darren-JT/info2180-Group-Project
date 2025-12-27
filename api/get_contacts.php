<?php
session_start();
require 'db_connect.php';

$sql = "SELECT c.*, u.firstname as u_fn, u.lastname as u.ln FROM Contacts c Join Users u ON c.assigned_to = u.id";

if ($filter == 'sales'){
    $sql .= " WHERE c.type = 'Sales Lead'";
}
elseif ($filter == 'support') {
    $sql .= " WHERE c.type = 'Support Lead'";
}
else {
    $sql .= " WHERE c.assigned_to = :current_user";
    $params['current_user'] = $_SESSION['user_id'];
}

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($contacts);
?>

