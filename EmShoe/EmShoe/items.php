<?php
require_once 'includes/functions/functions.php';
$products = getProducts();
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Shoes</title>
    <link rel="stylesheet" href="layout/css/style.css">
</head>
<body>
    <header>
        <h1>EM' Quality Shoes</h1>
        <!-- Navigation -->
    </header>
    <main>
        <section class="all-products">
            <h2>All Shoes</h2>
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-item">
                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                        <h3><?php echo $product['name']; ?></h3>
                        <p><?php echo $product['price']; ?></p>
                        <a href="item_details.php?id=<?php echo $product['id']; ?>">View Details</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
    <footer>
        <!-- Footer content -->
    </footer>
</body>
</html>