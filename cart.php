<?php
require_once 'includes/functions/functions.php';
session_start();

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Fetch cart items from session
$cartItems = $_SESSION['cart'];
$total = 0;
foreach ($cartItems as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Your Cart | EM' Quality Shoes</title>
    <link rel="stylesheet" href="layout/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        header, footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        nav ul {
            list-style: none;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin: 0 10px;
        }
        nav ul li a {
            color: #ffffff;
            text-decoration: none;
        }
        .cart-section {
            padding: 40px 20px;
        }
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .cart-table th, .cart-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .cart-table th {
            background-color: #f2f2f2;
        }
        .cart-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .cart-table tr:hover {
            background-color: #f1f1f1;
        }
        .cart-table td img {
            width: 50px;
            height: auto;
        }
        .cart-summary {
            text-align: right;
            font-size: 1.2em;
            margin-top: 20px;
            font-weight: bold;
        }
        .checkout-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }
        .checkout-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <main>
        <section class="cart-section">
            <h2>Your Cart</h2>
            <?php if (empty($cartItems)): ?>
                <p>Your cart is empty.</p>
            <?php else: ?>
                <table class="cart-table">
                    <tr>
                        <th>Item</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>"></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" class="cart-summary">Total: $<?php echo number_format($total, 2); ?></td>
                    </tr>
                </table>
                <a href="checkout.php" class="checkout-button">Proceed to Checkout</a>
            <?php endif; ?>
        </section>
    </main>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
