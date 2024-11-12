    <?php
    require_once 'includes/functions/functions.php';
    session_start();

    $products = getProducts();
    $categories = getAllCategories();
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>EM'S Quality Shoes</title>
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
            @keyframes gradientChange {
        0% {
            background-image: linear-gradient(rgba(255, 223, 186, 0.7), rgba(255, 223, 186, 0.7)), url('layout/images/hero.jpg');
        }
        25% {
            background-image: linear-gradient(rgba(173, 216, 230, 0.7), rgba(173, 216, 230, 0.7)), url('layout/images/hero.jpg');
        }
        50% {
            background-image: linear-gradient(rgba(255, 99, 71, 0.7), rgba(255, 99, 71, 0.7)), url('layout/images/hero.jpg');
        }
        75% {
            background-image: linear-gradient(rgba(144, 238, 144, 0.7), rgba(144, 238, 144, 0.7)), url('layout/images/hero.jpg');
        }
        100% {
            background-image: linear-gradient(rgba(255, 223, 186, 0.7), rgba(255, 223, 186, 0.7)), url('layout/images/hero.jpg');
        }
    }

    a { }

    .hero {
        background-size: cover;
        background-position: center;
        color: #000;
        text-align: center;
        padding: 100px 20px;
        animation: gradientChange 10s infinite alternate; /* Smooth dynamic color change */
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
            border-radius: 5px; /* Rounded corners for the button */
            font-weight: bold;  /* Make text bold */
            transition: all 0.3s ease; /* Smooth transition for all properties */
}

.hero a:hover {
    background-color: #0056b3;  /* Darker shade of blue on hover */
    transform: scale(1.1);  /* Slightly enlarge the button */
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);  /* Add shadow effect */
}

.hero a:focus {
    outline: none;  /* Remove focus outline */
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);  /* Add shadow when focused */
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
            <h1>Welcome to EM'S Quality Shoes</h1>
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
                            <a href="item_details.php?id=<?php echo $product['id']; ?>">Item Details</a>
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


