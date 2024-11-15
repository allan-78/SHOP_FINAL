<?php
require_once 'includes/functions/functions.php';
session_start();

// Fetch products and categories from the database
$products = getProducts();
$categories = getAllCategories();
?>
<!DOCTYPE html>
<html>
<head>
    <title>EM' Quality Shoes</title>
    <link rel="stylesheet" href="layout/css/style.css">
    <style>
      /* General Body Styles */
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f9;
    color: #333;
}

/* Header and Footer */
header, footer {
    background-color: #343a40;
    color: #fff;
    padding: 20px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Header Navigation */
nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    justify-content: center;
    gap: 20px;
}

nav ul li {
    display: inline;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
    font-size: 1.2em;
    font-weight: bold;
    transition: color 0.3s ease;
}

nav ul li a:hover {
    color: #ffc107; /* Gold on hover */
}

/* Hero Section */
.hero {
    background-image: url('layout/images/hero.jpg');
    background-size: cover;
    background-position: center;
    color: #fff;
    text-align: center;
    padding: 120px 20px;
    animation: gradientChange 10s infinite alternate;
    border-bottom: 5px solid #ffc107;
}

@keyframes gradientChange {
    0% {
        background-image: linear-gradient(rgba(255, 223, 186, 0.7), rgba(255, 223, 186, 0.7)), url('layout/images/hero.jpg');
    }
    50% {
        background-image: linear-gradient(rgba(255, 99, 71, 0.7), rgba(255, 99, 71, 0.7)), url('layout/images/hero.jpg');
    }
    100% {
        background-image: linear-gradient(rgba(173, 216, 230, 0.7), rgba(173, 216, 230, 0.7)), url('layout/images/hero.jpg');
    }
}

.hero h1 {
    font-size: 4em;
    color:#333;
    margin: 0;
    font-weight: 700;
    letter-spacing: 2px;
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.4);
}

.hero p {
    color:#333;
    font-size: 1.6em;
    margin: 10px 0;
}

.hero a {
    display: inline-block;
    margin-top: 30px;
    padding: 15px 30px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    font-size: 1.2em;
    font-weight: bold;
    border-radius: 30px;
    transition: all 0.3s ease;
}

.hero a:hover {
    background-color: #0056b3;
    transform: scale(1.1);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}

/* Product Grid and Cards */
.section {
    padding: 60px 20px;
    text-align: center;
}

h2 {
    font-size: 2.5em;
    margin-bottom: 20px;
    color: #333;
    text-transform: uppercase;
}

.product-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    margin-top: 30px;
}

.product-item {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    border: 1px solid #ddd;
    text-align: center;
    width: 240px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}

.product-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
}

.product-item img {
    width: 100%;
    height: 200px;
    object-fit: contain;
    border-radius: 5px;
}

.product-item h3 {
    font-size: 1.5em;
    margin: 15px 0;
}

.product-item p {
    font-size: 1.2em;
    margin: 10px 0;
    color: #800000;
}

.product-item a {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 15px;
    background-color:#007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 30px;
    font-weight: bold;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.product-item a:hover {
    background-color:#0056b3;
    transform: scale(1.1);
}

/* Footer Styles */
.footer-content {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 40px;
    margin-top: 30px;
}

.footer-content div {
    width: 30%;
    padding: 20px;
    text-align: left;
}

.footer-content h3 {
    font-size: 1.8em;
    margin-bottom: 15px;
    color: #fff;
}

.footer-content p {
    font-size: 1.1em;
    color: #ddd;
}

footer p {
    margin-top: 30px;
    font-size: 1em;
    color: #ccc;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero h1 {
        font-size: 2.8em;
    }
    .hero p {
        font-size: 1.2em;
    }
    .hero a {
        font-size: 1em;
        padding: 12px 24px;
    }
    .product-item {
        width: 200px;
    }
    .footer-content {
        flex-direction: column;
        align-items: center;
        gap: 20px;
    }
    .footer-content div {
        width: 100%;
        text-align: center;
    }
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
                        <a href="item_details.php?id=<?php echo $product['product_id']; ?>">View Details</a>
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
