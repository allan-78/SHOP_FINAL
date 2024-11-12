<?php
session_start();
require_once 'includes/functions/functions.php'; // Ensure correct path

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items for the logged-in user
try {
    if (!isset($pdo)) {
        $pdo = new PDO("mysql:host=localhost;dbname=shoeshop", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Fetch the user's cart items
    $sql = "SELECT c.cart_id, c.product_id, c.quantity, c.price, p.name FROM cart c
            JOIN products p ON c.product_id = p.product_id
            WHERE c.user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_now'])) {
        // Create a new order in the orders table
        $sql = "INSERT INTO orders (user_id, status) VALUES (:user_id, 'pending')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        $order_id = $pdo->lastInsertId(); // Get the last inserted order ID

        // Transfer cart items to order_items table
        $sql = "INSERT INTO order_items (order_id, product_id, quantity, price)
                SELECT :order_id, product_id, quantity, price FROM cart WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['order_id' => $order_id, 'user_id' => $user_id]);

        // Delete cart items after placing the order
        $sql = "DELETE FROM cart WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);

        // Set session message for success
        $_SESSION['message'] = 'Your order has been placed successfully!';
        
        // Redirect to the order confirmation page
        header("Location: order.php");
        exit();
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="layout/css/style.css">
</head>
<body>
    <header>
        <h1>Welcome to EM' Quality Shoes</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </nav>
    </header>
    
    <div class="cart">
        <h2>Your Cart</h2>
        <?php if (!empty($cartItems)): ?>
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td>$<?php echo number_format($item['quantity'] * $item['price'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <form action="cart.php" method="POST">
                <button type="submit" name="order_now">Order Now</button>
            </form>

        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>

        <?php if (isset($_SESSION['message'])): ?>
            <p><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2024 EM' Quality Shoes. All rights reserved.</p>
    </footer>
</body>
</html>
