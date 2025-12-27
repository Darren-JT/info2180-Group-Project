<?php
session_start();
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $fname = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
    $lname = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
    $company = filter_var($_POST['company'], FILTER_SANITIZE_STRING);
    $type = $_POST['type'];
    $assigned_to = $_POST['assigned_to'];
    
    $created_by = $_SESSION['user_id'];
    $now = date('Y-m-d H:i:s');

    $sql = "INSERT INTO Contacts (title, fname, lname, email, phone, company, type, assigned_to, created_by, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($result) {
        echo "Contact added successfully";
    }
    else {
        http_response_code(500);
        echo "Failed to add contact";
    }
}
?>