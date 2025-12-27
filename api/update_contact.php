<?php
session_start();
require_once '../database_connection_logic.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

if (!isset($_POST['contact_id']) || !isset($_POST['action'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing contact_id or action']);
    exit;
}

$contact_id = intval($_POST['contact_id']);
$action = $_POST['action'];

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}
$current_user = $_SESSION['user_id'];

try {
    $conn->beginTransaction();
    $updated = false;

    if ($action === 'assign_to_me') {
        $stmt = $conn->prepare("UPDATE Contacts SET assigned_to = :user_id, updated_at = NOW() WHERE id = :contact_id");
        $stmt->bindParam(':user_id', $current_user, PDO::PARAM_INT);
        $stmt->bindParam(':contact_id', $contact_id, PDO::PARAM_INT);
        $stmt->execute();
        $updated = true;
        
        // Fetch user name to return
        $stmtUser = $conn->prepare("SELECT firstname, lastname FROM Users WHERE id = :user_id");
        $stmtUser->bindParam(':user_id', $current_user, PDO::PARAM_INT);
        $stmtUser->execute();
        $user = $stmtUser->fetch(PDO::FETCH_ASSOC);
        $assigned_to_name = $user['firstname'] . ' ' . $user['lastname'];
    } elseif ($action === 'switch_type') {
        // We'll toggle between 'Support' and 'Sales Lead'.
        // First, let's verify the current type or just do it in one query.
        // Assuming only these two types exist for this button logic.
        $stmt = $conn->prepare("
            UPDATE Contacts 
            SET type = CASE 
                WHEN type = 'Support' THEN 'Sales Lead' 
                WHEN type = 'Sales Lead' THEN 'Support'
                ELSE type 
            END,
            updated_at = NOW()
            WHERE id = :contact_id
        ");
        $stmt->bindParam(':contact_id', $contact_id, PDO::PARAM_INT);
        $stmt->execute();
        $updated = true;

        // Fetch new type
        $stmtType = $conn->prepare("SELECT type FROM Contacts WHERE id = :contact_id");
        $stmtType->bindParam(':contact_id', $contact_id, PDO::PARAM_INT);
        $stmtType->execute();
        $result = $stmtType->fetch(PDO::FETCH_ASSOC);
        $new_type = $result['type'];
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid action']);
        $conn->rollBack();
        exit;
    }

    if ($updated) {
        $conn->commit();
        $response = ['success' => true];
        if (isset($assigned_to_name)) {
            $response['assigned_to_name'] = $assigned_to_name;
        }
        if (isset($new_type)) {
            $response['new_type'] = $new_type;
        }
        echo json_encode($response);
    } else {
        $conn->rollBack();
        echo json_encode(['success' => false, 'message' => 'No changes made']);
    }

} catch (PDOException $e) {
    $conn->rollBack();
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
