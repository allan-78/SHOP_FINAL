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
    <title>Product Details | EM' Quality Shoes</title>
    <link rel="stylesheet" href="layout/css/style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }

        header {
            background-color: #343a40;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 2rem;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin-top: 10px;
        }

        nav ul li {
            display: inline;
            margin-right: 15px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: #27ae60;
        }

        .product-details {
            display: flex;
            flex-direction: row;
            justify-content: center;
            margin: 30px 0;
            padding: 0 20px;
        }

        .product-image {
            flex: 1;
            max-width: 400px;
            margin-right: 30px;
            text-align: center;
        }

        .product-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .product-image img:hover {
            transform: scale(1.05);
        }

        .product-info {
            flex: 2;
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .product-info h2 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .product-info p {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .product-info .price {
            font-size: 1.5rem;
            color: #27ae60;
            margin-bottom: 20px;
        }

        .product-info .rating {
            margin-bottom: 20px;
        }

        .product-info .rating span {
            font-size: 1rem;
            color: #f39c12;
        }

        .product-info form {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .product-info form input[type="number"] {
            width: 60px;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-right: 15px;
            font-size: 1rem;
        }

        .product-info button {
            background-color: #27ae60;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .product-info button:hover {
            background-color: #2ecc71;
        }

        .product-info .review-btn {
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            width: 100%;
            margin-top: 10px;
        }

        .product-info .review-btn:hover {
            background-color: #2980b9;
        }

        footer {
            background-color: #2c3e50;
            color: #ecf0f1;
            text-align: center;
            padding: 20px 0;
            margin-top: 40px;
        }

        footer p {
            margin: 0;
            font-size: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .product-details {
                flex-direction: column;
                align-items: center;
            }

            .product-image {
                margin-bottom: 20px;
            }

            .product-info {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <?php include 'templates/header.php'; ?>
    <!-- Product Details Section -->
    <div class="product-details">
        <?php if ($product): ?>
            <!-- Product Image -->
            <div class="product-image">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
            </div>

            <!-- Product Info -->
            <div class="product-info">
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                <p class="price"><strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?></p>
                <div class="rating">
                    <strong>Rating:</strong>
                    <span><?php echo str_repeat('★', (int)$product['rating']); ?> <?php echo $product['rating']; ?> / 5</span>
                </div>

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
            </div>
        <?php else: ?>
            <p>Product not found.</p>
        <?php endif; ?>
    </div>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 EM' Quality Shoes. All rights reserved.</p>
    </footer>

</body>
</html>
