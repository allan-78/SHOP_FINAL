<?php
require_once 'includes/functions/functions.php'; // Ensure correct path
session_start();

// Check if the 'id' is present and is a valid number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = (int)$_GET['id']; // Convert to integer for security
    // Fetch product details by product_id
    $product = getProduct($product_id);

    // If the product doesn't exist, show an error
    if (!$product) {
        echo "Product not found!";
        exit;
    }
} else {
    // If 'id' is not set or is invalid
    echo "Invalid or missing product ID!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
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
    
    <div class="product-details">
    <?php if ($product): ?>
        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?></p>
        <p><strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?></p>
        <p><strong>Rating:</strong> <?php echo htmlspecialchars($product['rating']); ?></p>
        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />

        <!-- Add to Cart Form -->
        <form method="POST" action="add_to_cart.php">
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
            <input type="number" name="quantity" value="1" min="1">
            <button type="submit">Add to Cart</button>
        </form>
        
        <!-- Review Button -->
        <a href="view_reviews.php?product_id=<?php echo $product['product_id']; ?>" class="review-btn">
            <button type="button">View the Reviews</button>
        </a>
    <?php else: ?>
        <p>Product not found.</p>
    <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2024 EM' Quality Shoes. All rights reserved.</p>
    </footer>
</body>
</html>
