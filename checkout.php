<?php
require_once 'includes/functions/functions.php';
session_start();

// Fetch cart items from session
$cartItems = $_SESSION['cart'] ?? [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process the checkout
    // For simplicity, we're assuming the checkout is successful
    $_SESSION['cart'] = [];
    header("Location: confirmation.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout | EM' Quality Shoes</title>
    <link rel="stylesheet" href="layout/css/style.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <main>
        <section class="checkout">
            <h2>Checkout</h2>
            <?php if (empty($cartItems)): ?>
                <p>Your cart is empty.</p>
            <?php else: ?>
                <form method="post">
                    <h3>Billing Information</h3>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    <h3>Order Summary</h3>
                    <table>
                        <tr>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                        <?php foreach ($cartItems as $item): ?>
                            <tr>
                                <td><?php echo $item['name']; ?></td>
                                <td><?php echo $item['price']; ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td><?php echo $item['price'] * $item['quantity']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3">Total</td>
                            <td><?php echo $total; ?></td>
                        </tr>
                    </table>
                    <button type="submit">Complete Purchase</button>
                </form>
            <?php endif; ?>
        </section>
    </main>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
