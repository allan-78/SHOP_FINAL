<?php
// Include the functions file
require_once 'includes/functions/functions.php';

// Get the product ID from the URL or default to 0
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : 0;

// Call the function to fetch product data
$product = getProductById($product_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - <?php echo htmlspecialchars($product['name']); ?></title>
    <!-- Add your CSS here -->
</head>
<body>
    <div class="container">
        <?php if ($product): ?>
            <h1><?php echo htmlspecialchars($product['name']); ?></h1>
            <p><strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?></p>
            
            <!-- Display product images if available -->
            <?php if (!empty($product['image'])): ?>
                <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
            <?php endif; ?>

            <h3>Reviews</h3>
            <?php if (!empty($reviews)): ?>
                <ul>
                    <?php foreach ($reviews as $review): ?>
                        <li>
                            <p><strong><?php echo htmlspecialchars($review['user_name']); ?></strong> (Rating: <?php echo htmlspecialchars($review['rating']); ?>/5)</p>
                            <p><?php echo htmlspecialchars($review['review']); ?></p>
                            <p><em>Posted on <?php echo date('F j, Y', strtotime($review['created_at'])); ?></em></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No reviews yet for this product.</p>
            <?php endif; ?>
        <?php else: ?>
            <p>Sorry, this product is not available.</p>
        <?php endif; ?>
    </div>
</body>
</html>
