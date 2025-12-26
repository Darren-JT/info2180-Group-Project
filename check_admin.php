<?php
session_start();


if ($_SESSION['role'] !== 'Admin') {

    die("Error: You are not an admin. You cannot be here.");
}
?>