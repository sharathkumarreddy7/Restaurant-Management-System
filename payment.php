<?php
// Include necessary files
include "connect.php"; // Assuming this file contains your database connection
include "Includes/functions/functions.php";
include "Includes/templates/header.php";
include "Includes/templates/navbar.php";


// Check if order_id is set in the URL
if (!isset($_GET['order_id'])) {
    // If order_id is not provided, redirect to an error page or handle the error accordingly
    header("Location: error.php"); // Adjust this to your error handling page
    exit(); // Stop further execution
}
// Retrieve order_id from the URL
$order_id = $_GET['order_id'];
// Assuming you have the total price stored in $total_price variable
// You can modify this based on how you calculate the total price in your application

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay'])) {
    // Retrieve card details from the form
    $person_name = $_POST['person_name'];
    $card_number = $_POST['card_number'];
    $expiry = $_POST['expiry'];
    $cvv = $_POST['cvv'];

    // Perform necessary validations on card details

    // Move the particular order from in_order table to placed_orders table
    // Here, you need to write your SQL queries to move the order

    // Redirect to a success page or display a success message
    header("Location: payment_success.php");
    exit(); // Stop further execution
}
?>

<!-- Payment Form -->
<div class="container p-0">
    <div class="card px-4">
        <p class="h8 py-3">Payment Details</p>
        <form method="post" action="">
            <div class="row gx-3">
                <div class="col-12">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">Name on the card</p>
                        <input class="form-control mb-3" type="text" name="person_name" placeholder="Name">
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">Card Number</p>
                        <input class="form-control mb-3" type="text" name="card_number" placeholder="1234 5678 4356 7890">
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">Expiry</p>
                        <input class="form-control mb-3" type="text" name="expiry" placeholder="MM/YYYY">
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">CVV/CVC</p>
                        <input class="form-control mb-3 pt-2 " type="password" name="cvv" placeholder="***">
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" name="pay" class="btn btn-primary mb-3">
                        <span class="ps-3">Pay <?php echo $total_price; ?></span>
                        <span class="fas fa-arrow-right"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include "Includes/templates/footer.php"; ?>
