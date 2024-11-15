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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($category['name']); ?> | EM' Quality Shoes</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Header */
        header {
            background-color: #343a40;
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            margin: 0;
            font-size: 2rem;
            letter-spacing: 1px;
        }

        /* Main Content */
        main {
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Category Details Section */
        .category-details {
            text-align: center;
            margin-bottom: 50px;
        }

        .category-details h2 {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #27ae60;
        }

        .category-details p {
            font-size: 1.125rem;
            color: #555;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        /* Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
            justify-items: center;
        }

        .product-item {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 100%;
            max-width: 300px;
        }

        .product-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .product-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .product-item h3 {
            font-size: 1.25rem;
            color: #333;
            margin-bottom: 10px;
        }

        .product-item p {
            color: #555;
            font-size: 1.125rem;
            margin-bottom: 15px;
        }

        .product-item a {
            display: inline-block;
            padding: 12px 20px;
            background-color: #2980b9;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .product-item a:hover {
            background-color: #3498db;
        }

        /* Footer */
        footer {
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 20px 0;
            text-align: center;
        }

        footer p {
            margin: 0;
            font-size: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .category-details h2 {
                font-size: 2rem;
            }

            .product-item {
                padding: 15px;
            }

            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            }
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <?php include 'templates/header.php'; ?>
    <!-- Main Content Section -->
    <main>
        <section class="section category-details">
            <h2><?php echo htmlspecialchars($category['name']); ?></h2>
            <p><?php echo nl2br(htmlspecialchars($category['description'])); ?></p>

            <div class="product-grid">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="product-item">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p>$<?php echo number_format($product['price'], 2); ?></p>
                            <a href="item_details.php?id=<?php echo $product['product_id']; ?>">View Details</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No products found in this category.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 EM' Quality Shoes. All rights reserved.</p>
    </footer>

</body>
</html>
