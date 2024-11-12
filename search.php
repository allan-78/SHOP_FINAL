<?php
// Include the functions file to access the function definitions
require_once 'includes/functions/functions.php';

// Fetch search query from the GET request
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch products that match the search query using LIKE
$products = getProductsByName($searchQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results | EM' Quality Shoes</title>
    <link rel="stylesheet" href="layout/css/style.css">
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    header, footer {
        background-color: #343a40;
        color: #ffffff;
        padding: 20px;
        text-align: center;
    }

    h1, h2 {
        color: #333;
        font-weight: bold;
    }

    main {
        padding: 40px 15px;
        background-color: #ffffff;
    }

    .search-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .search-header h2 {
        color: #007bff;
        font-size: 2rem;
    }

    .search-bar {
        display: flex;
        justify-content: center;
        margin-bottom: 30px;
    }

    .search-bar input {
        padding: 12px;
        font-size: 1rem;
        border: 2px solid #ccc;
        border-radius: 25px;
        margin-right: 10px;
        width: 300px;
        transition: all 0.3s ease;
    }

    .search-bar input:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .search-bar button {
        padding: 12px 18px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .search-bar button:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        justify-items: center;
        margin-top: 20px;
    }

    .product-item {
        background-color: #ffffff;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        width: 100%;
        max-width: 280px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .product-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .product-item img {
        width: 100%;
        height: auto;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }

    .product-item img:hover {
        transform: scale(1.05);
    }

    .product-item h3 {
        margin: 15px 0;
        font-size: 1.2rem;
        color: #333;
        font-weight: normal;
    }

    .product-item p {
        color: #6c757d;
        font-size: 1rem;
        margin: 10px 0;
    }

    .product-item p.price {
        font-size: 1.1rem;
        color: #28a745;
        font-weight: bold;
    }

    .product-item a {
        padding: 10px 15px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-size: 0.9rem;
        text-transform: uppercase;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .product-item a:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    .no-results {
        text-align: center;
        color: #333;
        font-size: 1.5rem;
        font-weight: bold;
        margin-top: 40px;
        color: #dc3545;
    }

    .no-results p {
        color: #dc3545;
        font-size: 1.2rem;
    }
</style>

</head>
<body>
    <?php include 'templates/header.php'; ?>

    <main>
        <section class="search-header">
            <h2>Search Results for: <?php echo htmlspecialchars($searchQuery); ?></h2>
        </section>

        <section class="products">
            <div class="product-grid">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="product-item">
                            <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                            <a href="item_details.php?id=<?php echo $product['product_id']; ?>">View Details</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-results">
                        <p>No products found matching your search.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <?php include 'templates/footer.php'; ?>
</body>
</html>
