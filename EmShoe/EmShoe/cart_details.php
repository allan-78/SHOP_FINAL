<?php
    // Include database connection
    require_once('includes/connect.php');

    // Start the session
    session_start();

    // Check if the cart is empty
    if (empty($_SESSION['cart'])) {
        echo "Your cart is empty.";
    } else {
        echo "<h2>Your Cart</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Product Name</th><th>Quantity</th><th>Price</th></tr>";
        $total = 0;
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            // Fetch product details from the database
            $sql = "SELECT name, price FROM products WHERE id = '$product_id'";
            $result = mysqli_query($conn, $sql);
            $product = mysqli_fetch_assoc($result);

            echo "<tr>";
            echo "<td>" . $product['name'] . "</td>";
            echo "<td>" . $quantity . "</td>";
            echo "<td>" . $product['price'] . "</td>";
            echo "</tr>";

            $total += $product['price'] * $quantity;
        }
        echo "<tr><td colspan='2'>Total:</td><td>" . $total . "</td></tr>";
        echo "</table>";
    }
?>