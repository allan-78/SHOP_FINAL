<?php
require_once 'includes/functions/functions.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation | EM' Quality Shoes</title>
    <link rel="stylesheet" href="layout/css/style.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <main>
        <section class="confirmation">
            <h2>Order Confirmation</h2>
            <p>Thank you for your purchase! Your order has been successfully placed.</p>
            <a href="index.php">Continue Shopping</a>
        </section>
    </main>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
