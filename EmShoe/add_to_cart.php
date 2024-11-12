<?php
// Start the session to use session variables
session_start();

// Include database connection
require_once 'includes/functions/functions.php';

// Ensure that the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the user_id and product_id from the request
$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'] ?? null;
$quantity = $_POST['quantity'] ?? 1; // Default to 1 if quantity is not set

if ($product_id) {
    try {
        // Ensure PDO connection is available
        if (!isset($pdo)) {
            // Adjust this with the correct database credentials
            $pdo = new PDO("mysql:host=localhost;dbname=shoeshop", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        // Check if the item is already in the cart
        $sql = "SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);

        $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cartItem) {
            // If the item is already in the cart, update the quantity
            $newQuantity = $cartItem['quantity'] + $quantity;
            $sql = "UPDATE cart SET quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['quantity' => $newQuantity, 'user_id' => $user_id, 'product_id' => $product_id]);
        } else {
            // If the item is not in the cart, insert a new entry
            $sql = "SELECT price FROM products WHERE product_id = :product_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['product_id' => $product_id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($product) {
                $price = $product['price'];
                $sql = "INSERT INTO cart (user_id, product_id, quantity, price) VALUES (:user_id, :product_id, :quantity, :price)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'quantity' => $quantity, 'price' => $price]);

                // Success message
                $_SESSION['message'] = 'Product added to cart successfully!';
                header('Location: cart.php');
                exit;
            } else {
                $_SESSION['message'] = 'Product not found.';
                header('Location: index.php');
                exit;
            }
        }
    } catch (PDOException $e) {
        // Debugging: Show the error message
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
        header('Location: index.php'); // Redirect to home page if there's an error
        exit;
    }
} else {
    $_SESSION['message'] = 'Invalid product ID.';
    header('Location: index.php'); // Redirect to home page if product_id is not set
    exit;
}
?>
