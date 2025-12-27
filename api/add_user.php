<?php
require_once '../includes/database_connection_logic';
require_once '../includes/check_admin.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //sanitize and validate inputs
    //like we learned in class
    $fname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
    $lname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $pswrd = $_POST['pswrd'];

    $role = $_POST['role'];

    // I generated this with https://regex101.com/
    $regex = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/';

    if (!$fname || !$lname || !$email) {


        echo json_encode(['status' => 'error', 'message' => 'Invalid input data.']);


    } elseif (!preg_match($regex, $pswrd)) {

        //thought this might be a good idea
        echo json_encode(['status' => 'error', 'message' => 'passwrd does not meet requirement']);


    } else {

        $hashed_pswrd = password_hash($pswrd, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("INSERT INTO Users (firstname, lastname, password, email, role) VALUES (?, ?, ?, ?, ?)");


        if ($stmt->execute([$fname, $lname, $hashed_pswrd, $email, $role])) {
            echo json_encode(['status' => 'success', 'message' => 'User created successfully.']);
        }
    }
}