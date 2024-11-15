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
    $sql = "SELECT o.id, o.created_at, o.status, oi.product_id, oi.quantity, oi.price, p.name, p.image
            FROM orders o 
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.product_id
            WHERE o.user_id = :user_id 
            ORDER BY o.created_at DESC LIMIT 1";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Handle order cancellation
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_order'])) {
        $order_id = $_POST['order_id'];
        
        // Update order status to cancelled
        $sql = "UPDATE orders SET status = 'cancelled' WHERE id = :order_id AND user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['order_id' => $order_id, 'user_id' => $user_id]);

        // Return the order items to the cart
        foreach ($orderDetails as $item) {
            $sql = "INSERT INTO cart (user_id, product_id, quantity, price) 
                    VALUES (:user_id, :product_id, :quantity, :price)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'user_id' => $user_id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        $_SESSION['message'] = "Your order has been cancelled and the items have been returned to your cart.";
        header("Location: order.php");
        exit();
    }

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
    <style>
        /* Base styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
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
            font-size: 28px;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            margin-top: 10px;
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

        .order-details {
            width: 80%;
            max-width: 900px;
            margin: 40px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            font-size: 16px;
        }

        .order-details h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
        }

        .order-details table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
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

        .cancel-button {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .cancel-button:hover {
            background-color: #d32f2f;
        }

        .message {
            background-color: #4caf50;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 20px;
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
    </style>
</head>
<body>
<?php include 'templates/header.php'; ?>

    <div class="order-details">
        <h2>Order Confirmation</h2>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php endif; ?>

        <?php if ($orderDetails): ?>
            <p>Your order has been placed successfully!</p>
            <p><strong>Order ID:</strong> <?php echo htmlspecialchars($orderDetails[0]['id']); ?></p>
            <p><strong>Order Date:</strong> <?php echo htmlspecialchars($orderDetails[0]['created_at']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($orderDetails[0]['status']); ?></p>
            
            <h4>Items:</h4>
            <table>
                <tr>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
                <?php foreach ($orderDetails as $item): ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>"></td>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td>$<?php echo number_format($item['quantity'] * $item['price'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            
            <form action="order.php" method="POST">
                <input type="hidden" name="order_id" value="<?php echo $orderDetails[0]['id']; ?>">
                <button type="submit" name="cancel_order" class="cancel-button">Cancel Order</button>
            </form>
        <?php else: ?>
            <p>No order found.</p>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2024 EM' Quality Shoes. All rights reserved.</p>
    </footer>
</body>
</html>
