<?php
// Start session
session_start();

// Include the database connection file
include "connect.php";
include 'Includes/functions/functions.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve username and password from the form
    $username = $_POST['user_username'];
    $password = $_POST['user_password'];

    // Prepare and execute SQL query to check if username and password match
    $stmt = $con->prepare("SELECT * FROM clients WHERE client_username = ? AND client_password = ?");
    $stmt->execute([$username, $password]);

    // Fetch the result
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if a user with the provided credentials exists
    if ($user) {
        // User authenticated, set session variables
        $_SESSION['user_id'] = $user['client_id'];
        $_SESSION['user_username'] = $user['client_username'];

        // Redirect to home page
        header("Location: order_food.php");
        exit; // Stop further execution
    } else {
        // User not found or invalid credentials, redirect back to login page with error message
        header("Location: login.php?error=1");
        exit;
    }
}
?>
