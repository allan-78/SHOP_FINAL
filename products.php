<?php
require_once 'includes/functions/functions.php';
session_start();

// Get filter values from the GET request (if any)
$gender = isset($_GET['gender']) ? $_GET['gender'] : '';
$age_group = isset($_GET['age_group']) ? $_GET['age_group'] : '';
$size = isset($_GET['size']) ? $_GET['size'] : '';
$color = isset($_GET['color']) ? $_GET['color'] : '';
$rating = isset($_GET['rating']) ? $_GET['rating'] : '';
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0; // New: category filter

// If no filters are set, show all products
if (empty($gender) && empty($age_group) && empty($size) && empty($color) && empty($rating) && $category_id == 0) {
    // Show all products if no filter is applied
    $products = getProducts();
} else {
    // Show filtered products based on selected filters, including category filter
    $products = getFilteredProducts($gender, $age_group, $size, $color, $rating, $category_id);
}

// Fetch categories for the filter dropdown
$categories = getCategories(); // This function should fetch categories from the database

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | EM' Quality Shoes</title>
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

        .filter-form {
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            margin-bottom: 30px;
            border-radius: 8px;
        }

        .filter-form select, .filter-form input {
            margin: 5px;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .filter-form button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .filter-form button:hover {
            background-color: #0056b3;
        }

        .section {
            padding: 40px 20px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            justify-items: center;
        }

        .product-item {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #ddd;
            text-align: center;
            width: 100%;
            max-width: 220px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .product-item img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .product-item h3 {
            margin: 10px 0;
        }

        .product-item p {
            color: #6c757d;
        }

        .product-item a {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .product-item a:hover {
            background-color: #0056b3;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <?php include 'templates/header.php'; ?>

    <main>
        <!-- Filter Form -->
        <section class="filter-form">
            <form action="" method="GET">
                <label for="gender">Gender:</label>
                <select name="gender" id="gender">
                    <option value="">All</option>
                    <option value="Men" <?php echo ($gender == 'Men') ? 'selected' : ''; ?>>Men</option>
                    <option value="Women" <?php echo ($gender == 'Women') ? 'selected' : ''; ?>>Women</option>
                    <option value="Unisex" <?php echo ($gender == 'Unisex') ? 'selected' : ''; ?>>Unisex</option>
                </select>

                <label for="age_group">Age Group:</label>
                <select name="age_group" id="age_group">
                    <option value="">All</option>
                    <option value="Adult" <?php echo ($age_group == 'Adult') ? 'selected' : ''; ?>>Adult</option>
                    <option value="Teen" <?php echo ($age_group == 'Teen') ? 'selected' : ''; ?>>Teen</option>
                    <option value="Kid" <?php echo ($age_group == 'Kid') ? 'selected' : ''; ?>>Kid</option>
                </select>

                <label for="size">Size:</label>
                <select name="size" id="size">
                    <option value="">All</option>
                    <option value="7" <?php echo ($size == '7') ? 'selected' : ''; ?>>7</option>
                    <option value="8" <?php echo ($size == '8') ? 'selected' : ''; ?>>8</option>
                    <option value="9" <?php echo ($size == '9') ? 'selected' : ''; ?>>9</option>
                    <option value="10" <?php echo ($size == '10') ? 'selected' : ''; ?>>10</option>
                    <option value="11" <?php echo ($size == '11') ? 'selected' : ''; ?>>11</option>
                </select>

                <label for="color">Color:</label>
                <select name="color" id="color">
                    <option value="">All</option>
                    <option value="Red" <?php echo ($color == 'Red') ? 'selected' : ''; ?>>Red</option>
                    <option value="Blue" <?php echo ($color == 'Blue') ? 'selected' : ''; ?>>Blue</option>
                    <option value="Black" <?php echo ($color == 'Black') ? 'selected' : ''; ?>>Black</option>
                    <option value="White" <?php echo ($color == 'White') ? 'selected' : ''; ?>>White</option>
                </select>

                <label for="rating">Rating:</label>
                <select name="rating" id="rating">
                    <option value="">All</option>
                    <option value="5" <?php echo ($rating == '5') ? 'selected' : ''; ?>>5 Stars</option>
                    <option value="4" <?php echo ($rating == '4') ? 'selected' : ''; ?>>4 Stars</option>
                    <option value="3" <?php echo ($rating == '3') ? 'selected' : ''; ?>>3 Stars</option>
                    <option value="2" <?php echo ($rating == '2') ? 'selected' : ''; ?>>2 Stars</option>
                    <option value="1" <?php echo ($rating == '1') ? 'selected' : ''; ?>>1 Star</option>
                </select>

                <!-- New: Category Filter -->
                <label for="category_id">Category:</label>
                <select name="category_id" id="category_id">
                    <option value="">All</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>" <?php echo ($category_id == $category['id']) ? 'selected' : ''; ?>><?php echo $category['name']; ?></option>
                    <?php endforeach; ?>
                </select>

                <button type="submit">Apply Filters</button>
            </form>
        </section>

        <!-- Display Products -->
        <section class="section products">
            <h2>Products</h2>
            <div class="product-grid">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="product-item">
                            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                            <h3><?php echo $product['name']; ?></h3>
                            <p>$<?php echo number_format($product['price'], 2); ?></p>
                            <a href="item_details.php?id=<?php echo $product['id']; ?>">View Details</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No products found based on your filter criteria.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <?php include 'templates/footer.php'; ?>
</body>
</html>
