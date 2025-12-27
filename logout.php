<?php
session_start();


session_unset();
session_destroy();


//for debugging purposes
echo json_encode(['status' => 'success', 'message' => 'Logged out']);


?>