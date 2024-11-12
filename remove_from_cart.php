<?php
// Start the session to use session variables
session_start();

// Include the database connection
require_once 'includes/functions/functions.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the cart item ID from the request
$cart_id = $_GET['id'];

// Delete the product from the cart
try {
    $sql = "DELETE FROM cart WHERE id = :cart_id AND user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['cart_id' => $cart_id, 'user_id' => $_SESSION['user_id']]);

    // Set success message
    $_SESSION['message'] = 'Product removed from cart successfully!';
    header('Location: cart.php');

} catch (PDOException $e) {
    // Handle the error
    $_SESSION['message'] = 'Error: ' . $e->getMessage();
    header('Location: cart.php');
}
