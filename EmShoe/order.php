<?php
session_start();
require_once 'includes/functions/functions.php'; // Ensure correct path

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection
try {
    // Initialize PDO connection if not already initialized
    if (!isset($pdo)) {
        $pdo = new PDO("mysql:host=localhost;dbname=shoeshop", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Fetch the most recent order of the logged-in user
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT o.id, o.created_at, o.status, oi.product_id, oi.quantity, oi.price, p.name 
            FROM orders o 
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.product_id
            WHERE o.user_id = :user_id 
            ORDER BY o.created_at DESC LIMIT 1";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
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

    <div class="order-details">
        <h2>Order Confirmation</h2>
        <?php if ($orderDetails): ?>
            <p>Your order has been placed successfully!</p>
            <h3>Order Details:</h3>
            <p><strong>Order ID:</strong> <?php echo htmlspecialchars($orderDetails[0]['id']); ?></p>
            <p><strong>Order Date:</strong> <?php echo htmlspecialchars($orderDetails[0]['created_at']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($orderDetails[0]['status']); ?></p>
            <h4>Items:</h4>
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
                <?php foreach ($orderDetails as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td>$<?php echo number_format($item['quantity'] * $item['price'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No order found.</p>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2024 EM' Quality Shoes. All rights reserved.</p>
    </footer>
</body>
</html>
