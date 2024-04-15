<?php
    //Set page title
    $pageTitle = 'Sign Up';

    include "connect.php";
    include 'Includes/functions/functions.php';
    include "Includes/templates/header.php";
    include "Includes/templates/navbar.php";
?>

<style type="text/css">
    /* Styles for signup section */
    .signup-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 150px); /* Subtracting header and footer heights */
    }
    .signup-section h2 {
        margin-bottom: 20px;
    }
    .signup-option {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .signup-option form {
        margin-bottom: 20px;
    }
    .signup-option form input {
        margin-bottom: 10px;
    }
    .signup-option form button {
        background-color: #ffc851;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }
</style>

<section class="signup-section">
    <h2>Sign Up</h2>
    <div class="signup-option">
        <form action="customer-signup.php" method="post">
            <input type="text" name="customer_name" placeholder="Customer Name" required>
            <input type="text" name="customer_username" placeholder="Username" required>
            <input type="email" name="customer_email" placeholder="Email" required>
            <input type="password" name="customer_password" placeholder="Password" required>
            <input type="text" name="customer_address" placeholder="Address" required>
            <input type="number" name="customer_phone" placeholder="Phone Number" required>
            <button type="submit">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</section>

<?php include "Includes/templates/footer.php"; ?>
