<?php
session_start();
require_once 'includes/functions/functions.php';

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
    $sql = "SELECT c.cart_id, c.product_id, c.quantity, c.price, p.name, p.image FROM cart c
            JOIN products p ON c.product_id = p.product_id
            WHERE c.user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Handle removing an item from the cart
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_item'])) {
        $cart_id = $_POST['cart_id'];

        // Delete the cart item from the database
        $sql = "DELETE FROM cart WHERE cart_id = :cart_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['cart_id' => $cart_id]);

        // Redirect to the cart page to reflect changes
        header("Location: cart.php");
        exit();
    }

    // Handle placing an order
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
    <style>
        /* Reset and basic styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
        }

        header {
            background-color: #3f51b5;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            margin: 0;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            font-weight: 500;
        }

        nav ul li a:hover {
            color: #ddd;
        }

        .cart {
            width: 80%;
            max-width: 1000px;
            margin: 40px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .cart h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #3f51b5;
            color: white;
        }

        td img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
        }

        td p {
            margin: 0;
        }

        td .total-price {
            font-weight: bold;
        }

        form {
            text-align: center;
            margin-top: 20px;
        }

        button {
            padding: 15px 25px;
            background-color: #3f51b5;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #283593;
        }

        .empty-cart {
            text-align: center;
            font-size: 18px;
            color: #777;
        }

        .empty-cart a {
            color: #3f51b5;
            font-weight: bold;
            text-decoration: none;
            padding: 5px 15px;
            border: 1px solid #3f51b5;
            border-radius: 8px;
            transition: background-color 0.3s, color 0.3s;
        }

        .empty-cart a:hover {
            background-color: #3f51b5;
            color: #fff;
        }

        footer {
            background-color: #3f51b5;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: 40px;
        }

        footer p {
            margin: 0;
        }

        .message {
            background-color: #4caf50;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .remove-btn {
            background-color: #ff4d4d;
            color: white;
            font-size: 14px;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .remove-btn:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>

<?php include 'templates/header.php'; ?>
    
    <div class="cart">
        <h2>Your Cart</h2>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php endif; ?>

        <?php if (!empty($cartItems)): ?>
            <table>
                <tr>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Remove</th>
                </tr>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>"></td>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td class="total-price">$<?php echo number_format($item['quantity'] * $item['price'], 2); ?></td>
                        <td>
                            <form action="cart.php" method="POST" style="display:inline;">
                                <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                <button type="submit" name="remove_item" class="remove-btn">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <form action="cart.php" method="POST">
                <button type="submit" name="order_now">Order Now</button>
            </form>

        <?php else: ?>
            <p class="empty-cart">Your cart is empty. <a href="products.php">Shop Now</a></p>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2024 EM' Quality Shoes. All rights reserved.</p>
    </footer>

</body>
</html>
