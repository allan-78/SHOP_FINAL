<?php
session_start();
require_once 'includes/functions/functions.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];  // Get the user ID from the session

// Fetch orders placed by the user
try {
    if (!isset($pdo)) {
        // Set up the PDO connection if not already established
        $pdo = new PDO("mysql:host=localhost;dbname=shoeshop", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Fetch orders for the logged-in user
    $sql = "SELECT o.id AS order_id, o.created_at AS order_date
            FROM Orders o
            WHERE o.user_id = :user_id
            ORDER BY o.created_at DESC";  // Latest orders first
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch order items for each order
    $order_items = [];
    foreach ($orders as $order) {
        $sql = "SELECT oi.product_id, oi.quantity, oi.price, p.name AS product_name, p.image, p.price AS product_price
                FROM Order_Items oi
                JOIN Products p ON oi.product_id = p.product_id
                WHERE oi.order_id = :order_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['order_id' => $order['order_id']]);
        $order_items[$order['order_id']] = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Order History | EM' Quality Shoes</title>
    <link rel="stylesheet" href="layout/css/style.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        header {
            background-color: #3f51b5;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
        }

        .order-history-container {
            width: 80%;
            max-width: 900px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .order-history-container h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
        }

        .order {
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
            padding-bottom: 20px;
        }

        .order h3 {
            font-size: 22px;
            margin-bottom: 15px;
        }

        .order-items {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .order-item {
            width: 30%;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .order-item img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .order-item h4 {
            margin-top: 10px;
            font-size: 18px;
        }

        .order-item p {
            font-size: 16px;
            color: #666;
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

<div class="order-history-container">
    <h2>Your Order History</h2>

    <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $order): ?>
            <div class="order">
                <h3>Order #<?php echo $order['order_id']; ?> - <?php echo date('F d, Y', strtotime($order['order_date'])); ?></h3>

                <div class="order-items">
                    <?php foreach ($order_items[$order['order_id']] as $item): ?>
                        <div class="order-item">
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
                            <h4><?php echo htmlspecialchars($item['product_name']); ?></h4>
                            <p>Quantity: <?php echo $item['quantity']; ?></p>
                            <p>Price: $<?php echo number_format($item['price'], 2); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>You have no order history.</p>
    <?php endif; ?>
</div>

<footer>
    <p>&copy; 2024 EM' Quality Shoes. All rights reserved.</p>
</footer>

</body>
</html>
