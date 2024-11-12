<?php
require_once 'includes/functions/functions.php'; // Ensure correct path
session_start();

// Initialize the database connection (add your own credentials if needed)
try {
    if (!isset($pdo)) {
        $pdo = new PDO("mysql:host=localhost;dbname=shoeshop", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit;
}

// Check if product_id is passed in the URL
if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id'];

    // Debugging: Output the product ID to ensure it's correct
    echo "Product ID: " . $product_id . "<br>";  // <-- Debugging line

    // Fetch product details
    $product = getProduct($product_id);

    // If the product doesn't exist
    if (!$product) {
        echo "Product not found!";
        exit;
    }

    // Debugging: Output the product details to see what is being fetched
    echo "<pre>";
    print_r($product);  // <-- Debugging line
    echo "</pre>";

    // Fetch reviews for the product
    try {
        $sql = "SELECT rating, review_text, created_at FROM reviews WHERE product_id = :product_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['product_id' => $product_id]);
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    echo "Invalid product ID!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product Reviews</title>
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

    <div class="product-reviews">
        <h2>Reviews for <?php echo htmlspecialchars($product['name']); ?></h2>

        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review">
                    <p><strong>Rating:</strong> <?php echo htmlspecialchars($review['rating']); ?>/5</p>
                    <p><strong>Review:</strong> <?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
                    <p><em>Reviewed on: <?php echo htmlspecialchars($review['created_at']); ?></em></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No reviews yet for this product. Be the first to review it after purchasing!</p>
        <?php endif; ?>

        <!-- Button to go back home -->
        <a href="index.php" class="btn">Go Home</a>
    </div>

    <footer>
        <p>&copy; 2024 EM' Quality Shoes. All rights reserved.</p>
    </footer>
</body>
</html>
