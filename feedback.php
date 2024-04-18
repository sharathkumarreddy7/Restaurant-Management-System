<?php
// Include necessary files
include "connect.php"; // Assuming this file contains your database connection
include "Includes/functions/functions.php";
include "Includes/templates/header.php";
include "Includes/templates/navbar.php";

// Check if order_id is set in the URL
if (!isset($_GET['order_id'])) {
    // If order_id is not provided, redirect to an error page or handle the error accordingly
    header("Location: index.php"); // Redirect to home page if order_id is missing
    exit(); // Stop further execution
}

// Retrieve order_id from the URL
$order_id = $_GET['order_id'];

// Fetch client_id associated with the order_id from the database
$stmtClientId = $con->prepare("SELECT DISTINCT client_id FROM in_order WHERE order_id = ?");
$stmtClientId->execute([$order_id]);
$client_id_row = $stmtClientId->fetch();

// Check if client_id is retrieved successfully
if (!$client_id_row) {
    // If client_id is not found for the given order_id, handle the error accordingly
    header("Location: payment.php"); // Redirect to home page or error page
    exit(); // Stop further execution
}

$client_id = $client_id_row['client_id'];


// Fetch all items in the current order
$stmtItems = $con->prepare("SELECT menus.menu_id, menus.menu_name FROM in_order JOIN menus ON in_order.menu_id = menus.menu_id WHERE in_order.order_id = ?");
$stmtItems->execute([$order_id]);
$items = $stmtItems->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($items as $item) {
        $menu_id = $item['menu_id'];
        $feedback = $_POST["feedback_$menu_id"] ?? 0;
        $comments = $_POST["comments_$menu_id"] ?? '';

        // Insert feedback for each item
        $stmtFeedback = $con->prepare("INSERT INTO Feedback (menu_id, client_id, Feedback, Comments) VALUES (?, ?, ?, ?)");
        $stmtFeedback->execute([$menu_id, $client_id, $feedback, $comments]);
    }

    // Redirect to a thank you or confirmation page after submitting feedback
    header("Location: index.php");
    exit();
}
?>

<div class="container">
    <h2>Feedback for Your Order</h2>
    <form method="post" action="">
        <?php foreach ($items as $item): ?>
            <div class="item-feedback">
                <h4><?php echo htmlspecialchars($item['menu_name']); ?></h4>
                <label for="feedback_<?php echo $item['menu_id']; ?>">Rating (1-5):</label>
                <input type="number" name="feedback_<?php echo $item['menu_id']; ?>" min="1" max="5" required>
                <label for="comments_<?php echo $item['menu_id']; ?>">Comments:</label>
                <textarea name="comments_<?php echo $item['menu_id']; ?>" rows="2"></textarea>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-primary">Submit Feedback</button>
    </form>
</div>

<?php include "Includes/templates/footer.php"; ?>
