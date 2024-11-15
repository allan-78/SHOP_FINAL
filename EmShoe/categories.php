<?php
require_once 'includes/functions/functions.php';
$categories = getCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>Shoe Categories | EM' Quality Shoes</title>
    <link rel="stylesheet" href="layout/css/style.css">
    <style>
       /* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f9fa;
    min-height: 100vh; /* Ensure the body takes up the full height */
    display: flex;
    flex-direction: column;
}

/* Header and Footer */
header, footer {
    background-color: #343a40;
    color: #ffffff;
    padding: 20px;
    text-align: center;
    width: 100%;
}

footer {
    flex-shrink: 0; /* Prevent footer from shrinking */
    margin-top: auto; /* Push footer to the bottom */
}

/* Footer Content */
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
    font-size: 1rem;
    margin-top: 10px;
}

/* Section and Grid Styles */
.section {
    padding: 40px 20px;
    max-width: 1200px;
    margin: auto;
}

/* Category Grid */
.category-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    justify-items: center;
}

/* Category Items */
.category-item {
    background-color: #ffffff;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
    width: 100%;
    max-width: 220px;
}

.category-item:hover {
    transform: translateY(-5px);
}

.category-item h3 {
    margin: 0 0 10px 0;
    color: #343a40;
}

.category-item p {
    color: #6c757d;
}

.category-item a {
    display: inline-block;
    margin-top: 10px;
    padding: 10px 15px;
    background-color: #007bff;
    color: #ffffff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.category-item a:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
    <?php include 'templates/header.php'; ?>

    <main>
        <section class="section categories">
            <h2>Shoe Categories</h2>
            <div class="category-grid">
                <?php foreach ($categories as $category): ?>
                    <div class="category-item">
                        <h3><?php echo htmlspecialchars($category['name']); ?></h3>
                        <p><?php echo htmlspecialchars($category['description']); ?></p>
                        <a href="items_by_category.php?id=<?php echo $category['id']; ?>">View Shoes</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
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
