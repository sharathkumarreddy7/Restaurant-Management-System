<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);
// Include the database connection file
include "connect.php";
include 'Includes/functions/functions.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['customer_name'];
    $email = $_POST['customer_email'];
    $password = $_POST['customer_password'];
    $address = $_POST['customer_address'];
    $phone = $_POST['customer_phone'];

    // Prepare and execute SQL query to insert customer details into the database
    $stmt = $con->prepare("INSERT INTO clients (client_name, client_email, client_password, client_address, client_phone) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $email, $password, $address, $phone]);
    
    // Redirect to login page after successful sign up
    header("Location: login.php");
    exit; // Stop further execution
}
?>
