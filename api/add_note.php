<?php
session_start();
require_once '../database_connection_logic.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

// Basic input validation
if (!isset($_POST['contact_id']) || !isset($_POST['comment'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing contact_id or comment']);
    exit;
}

$contact_id = intval($_POST['contact_id']);
$comment = trim($_POST['comment']);

if (empty($comment)) {
    http_response_code(400);
    echo json_encode(['error' => 'Comment cannot be empty']);
    exit;
}

// Check for user session
if (!isset($_SESSION['user_id'])) {
    // For testing purposes, if no session, we might want to error.
    // However, since I cannot easily log in, I might temporarily use a fallback or strictly enforce it.
    // The user didn't ask me to implement login, so I will strictly enforce it 
    // but knowing the user's state, they might test this and fail.
    // I'll add a TODO or just error.
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}
$created_by = $_SESSION['user_id'];

try {
    $conn->beginTransaction();

    // 1. Insert Note
    $stmt = $conn->prepare("INSERT INTO Notes (contact_id, comment, created_by) VALUES (:contact_id, :comment, :created_by)");
    $stmt->bindParam(':contact_id', $contact_id, PDO::PARAM_INT);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':created_by', $created_by, PDO::PARAM_INT);
    $stmt->execute();

    // 2. Update Contact timestamp
    $stmtUpdate = $conn->prepare("UPDATE Contacts SET updated_at = NOW() WHERE id = :contact_id");
    $stmtUpdate->bindParam(':contact_id', $contact_id, PDO::PARAM_INT);
    $stmtUpdate->execute();

    $conn->commit();
    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    $conn->rollBack();
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
