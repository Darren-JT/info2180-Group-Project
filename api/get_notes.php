<?php
require_once '../database_connection_logic.php';

header('Content-Type: application/json');

if (!isset($_GET['contact_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing contact_id']);
    exit;
}

$contact_id = $_GET['contact_id'];

try {
    $stmt = $conn->prepare("
        SELECT n.comment, n.created_at, u.firstname, u.lastname 
        FROM Notes n 
        JOIN Users u ON n.created_by = u.id 
        WHERE n.contact_id = :contact_id 
        ORDER BY n.created_at ASC
    ");
    $stmt->bindParam(':contact_id', $contact_id, PDO::PARAM_INT);
    $stmt->execute();
    $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($notes);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
