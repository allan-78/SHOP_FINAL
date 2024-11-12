<?php
require_once 'includes/functions/functions.php';
session_start();

// Get the category ID from the URL
$category_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the category details
$category = getCategoryById($category_id);

// Fetch products by category ID
$products = getProductsByCategoryId($category_id);

?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($category['name']); ?> | EM' Quality Shoes</title>
    <link rel="stylesheet" href="layout/css/style.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <main>
        <section class="section category-details">
            <h2><?php echo htmlspecialchars($category['name']); ?></h2>
            <p><?php echo htmlspecialchars($category['description']); ?></p>
            <div class="product-grid">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="product-item">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p>$<?php echo number_format($product['price'], 2); ?></p>
                            <a href="item_details.php?id=<?php echo $product['id']; ?>">View Details</a>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No products found in this category.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
