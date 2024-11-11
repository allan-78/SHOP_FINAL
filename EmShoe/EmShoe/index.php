<?php
require_once 'includes/functions/functions.php';
session_start();

$products = getProducts();
$categories = getAllCategories();
?>
<!DOCTYPE html>
<html>
<head>
    <title>EM' Quality Shoes</title>
    <link rel="stylesheet" href="layout/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        header, footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        nav ul {
            list-style: none;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin: 0 10px;
        }
        nav ul li a {
            color: #ffffff;
            text-decoration: none;
        }
        .hero {
            background-image: url('layout/images/hero.jpg');
            background-size: cover;
            background-position: center;
            color: #ffffff;
            text-align: center;
            padding: 100px 20px;
        }
        .hero h1 {
            font-size: 3em;
            margin: 0;
        }
        .hero p {
            font-size: 1.5em;
        }
        .hero a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
        }
        .section {
            padding: 40px 20px;
        }
        .product-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .product-item {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #ddd;
            text-align: center;
            width: 200px;
        }
        .product-item img {
            max-width: 100%;
            height: auto;
        }
        .footer-content {
            display: flex;
            justify-content: space-around;
        }
        .footer-content div {
            width: 30%;
        }
    </style>
</head>
<body>
<?php include 'templates/header.php'; ?>
    <div class="hero">
        <h1>Welcome to EM' Quality Shoes</h1>
        <p>Find the perfect pair of shoes for any occasion</p>
        <a href="products.php">Shop Now</a>
    </div>
    <main>
        <section class="section featured-products">
            <h2>Featured Shoes</h2>
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-item">
                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                        <h3><?php echo $product['name']; ?></h3>
                        <p>$<?php echo number_format($product['price'], 2); ?></p>
                        <a href="item_details.php?id=<?php echo $product['id']; ?>">View Details</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <section class="section categories">
            <h2>Categories</h2>
            <div class="product-grid">
                <?php foreach ($categories as $category): ?>
                    <div class="product-item">
                        <h3><?php echo $category['name']; ?></h3>
                        <p><?php echo $category['description']; ?></p>
                        <a href="items_by_category.php?id=<?php echo $category['id']; ?>">View Products</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <!-- Add more sections for testimonials, etc. -->
    </main>
    <footer>
        <div class="footer-content">
            <div>
                <h3>About Us</h3>
                <p>We offer a wide selection of high-quality shoes at affordable prices.</p>
            </div>
            <div>
                <h3>Contact Us</h3>
                <p>Email: info@emqualityshoes.com</p>
                <p>Phone: 123-456-7890</p>
            </div>
            <div>
                <h3>Follow Us</h3>
                <p>Facebook | Instagram | Twitter</p>
            </div>
        </div>
        <p>&copy; 2024 EM' Quality Shoes. All rights reserved.</p>
    </footer>
</body>
</html>
