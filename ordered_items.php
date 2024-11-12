<?php
require_once 'includes/functions/functions.php'; // Include functions file
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    // Create a PDO connection to fetch the ordered items
    if (!isset($pdo)) {
        $pdo = new PDO("mysql:host=localhost;dbname=shoeshop", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Fetch the orders and related products for the logged-in user
    $sql = "SELECT oi.id AS order_item_id, oi.product_id, oi.quantity, oi.price, p.name AS product_name
            FROM order_items oi
            JOIN orders o ON oi.order_id = o.id
            JOIN products p ON oi.product_id = p.product_id
            WHERE o.user_id = :user_id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    $orderedItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get any existing reviews for the ordered items
    $reviews = [];
    foreach ($orderedItems as $item) {
        $sql = "SELECT rating, review_text FROM reviews WHERE product_id = :product_id AND user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['product_id' => $item['product_id'], 'user_id' => $user_id]);
        $review = $stmt->fetch(PDO::FETCH_ASSOC);  // Changed from fetchAll to fetch for a single review
        
        // Store the review or null if not found
        $reviews[$item['product_id']] = $review ? $review : null;
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
    <title>Ordered Items</title>
    <link rel="stylesheet" href="layout/css/style.css">
</head>
<body>
    <header>
        <h1>Ordered Items</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
        </nav>
    </header>

    <div class="ordered-items">
        <h2>Your Ordered Items</h2>

        <?php if (!empty($orderedItems)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Review</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderedItems as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <?php
                                if (isset($reviews[$item['product_id']])) {
                                    if ($reviews[$item['product_id']] !== null) {
                                        // Display existing review
                                        echo "<p><strong>Rating:</strong> " . $reviews[$item['product_id']]['rating'] . "/5</p>";
                                        echo "<p><strong>Review:</strong> " . htmlspecialchars($reviews[$item['product_id']]['review_text']) . "</p>";
                                    } else {
                                        // If no review exists, show "No reviews yet" message
                                        echo "<p>No reviews yet for this product.</p>";
                                        echo "<a href='review_product.php?product_id=" . $item['product_id'] . "' class='review-btn'>
                                                <button>Write a Review</button>
                                              </a>";
                                    }
                                } else {
                                    echo "<p>No reviews yet for this product.</p>";
                                    echo "<a href='review_product.php?product_id=" . $item['product_id'] . "' class='review-btn'>
                                            <button>Write a Review</button>
                                          </a>";
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have no ordered items.</p>
        <?php endif; ?>
    </div>

</body>
</html>
