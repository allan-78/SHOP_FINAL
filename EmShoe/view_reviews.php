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

    // Fetch product details
    $product = getProduct($product_id);

    // If the product doesn't exist
    if (!$product) {
        echo "Product not found!";
        exit;
    }

    // Fetch reviews for the product
    try {
        $sql = "SELECT rating, review_text, created_at, user_id FROM reviews WHERE product_id = :product_id";
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
    <title>Product Reviews | EM' Quality Shoes</title>
    <link rel="stylesheet" href="layout/css/style.css">
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    header, footer {
        background-color: #343a40;
        color: #ffffff;
        padding: 20px;
        text-align: center;
    }

    header h1 {
        margin: 0;
        font-size: 2rem;
    }

    nav ul {
        list-style-type: none;
        padding: 0;
    }

    nav ul li {
        display: inline;
        margin: 0 15px;
    }

    nav ul li a {
        color: white;
        text-decoration: none;
        font-size: 1.2rem;
    }

    nav ul li a:hover {
        text-decoration: underline;
    }

    .product-reviews {
        padding: 40px 20px;
        background-color: white;
        max-width: 900px;
        margin: 20px auto;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .product-reviews h2 {
        font-size: 2rem;
        color: #333;
        text-align: center;
        margin-bottom: 30px;
    }

    .review {
        background-color: #f9f9f9;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        border: 1px solid #ddd;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    .review:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .review p {
        color: #555;
        line-height: 1.6;
        font-size: 1rem;
    }

    .review .rating {
        font-weight: bold;
        color: #28a745;
        font-size: 1.2rem;
    }

    .review .date {
        font-size: 0.9rem;
        color: #6c757d;
        margin-top: 10px;
    }

    .review .user {
        font-weight: bold;
        color: #007bff;
    }

    .no-reviews {
        text-align: center;
        color: #dc3545;
        font-size: 1.5rem;
        margin-top: 40px;
    }

    .btn {
        display: inline-block;
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        font-size: 1rem;
        text-align: center;
        margin-top: 20px;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    .order-btn {
        background-color: #28a745;
    }

    .order-btn:hover {
        background-color: #218838;
    }
    </style>
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
                    <p class="rating">Rating: <?php echo htmlspecialchars($review['rating']); ?>/5</p>
                    <p><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
                    <p class="date">Reviewed on: <?php echo htmlspecialchars($review['created_at']); ?></p>
                    <!-- Optional: Display reviewer username if available -->
                    <p class="user">Reviewed by User #<?php echo htmlspecialchars($review['user_id']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-reviews">
                <p>Be the first to review this product! <br> 
                <a href="order.php?product_id=<?php echo $product_id; ?>" class="btn order-btn">Order it now and leave a review!</a></p>
            </div>
        <?php endif; ?>

        <!-- Button to go back home -->
        <a href="index.php" class="btn">Go Home</a>
    </div>

    <footer>
        <p>&copy; 2024 EM' Quality Shoes. All rights reserved.</p>
    </footer>

</body>
</html>
