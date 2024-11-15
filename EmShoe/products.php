<?php
require_once 'includes/functions/functions.php';

session_start();

// Get filter values from the GET request (if any)
$gender = isset($_GET['gender']) ? $_GET['gender'] : '';
$age_group = isset($_GET['age_group']) ? $_GET['age_group'] : '';
$size = isset($_GET['size']) ? $_GET['size'] : '';
$color = isset($_GET['color']) ? $_GET['color'] : '';
$rating = isset($_GET['rating']) ? $_GET['rating'] : '';
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0; // Category filter

// Fetch products based on the selected filters
if (empty($gender) && empty($age_group) && empty($size) && empty($color) && empty($rating) && $category_id == 0) {
    $products = getProducts();  // Get all products if no filters are set
} else {
    $products = getFilteredProducts($gender, $age_group, $size, $color, $rating, $category_id);  // Get filtered products
}

// Fetch categories for the filter dropdown
$categories = getCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | EM' Quality Shoes</title>
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* General Reset */
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

        /* Main Content Layout */
        .main-content {
            display: flex;
            flex-wrap: wrap;
            margin: 20px;
        }

        /* Sidebar Filter */
        .filter-sidebar {
            width: 250px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-right: 20px;
        }

        .filter-sidebar h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #333;
        }

        .filter-sidebar label {
            font-size: 1rem;
            color: #555;
            margin-bottom: 10px;
            display: block;
        }

        .filter-sidebar select,
        .filter-sidebar input {
            width: 100%;
            padding: 12px;
            margin: 8px 0 20px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        .filter-sidebar button {
            background-color: #27ae60;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .filter-sidebar button:hover {
            background-color: #2ecc71;
        }

        /* Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            justify-items: center;
            flex: 1;
        }

        .product-item {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            max-width: 300px;
            width: 100%;
        }

        .product-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .product-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .product-item h3 {
            font-size: 1.25rem;
            color: #333;
            margin-top: 15px;
        }

        .product-item p {
            color: #555;
            font-size: 1.125rem;
            margin: 10px 0;
        }

        .product-item a {
            display: inline-block;
            padding: 12px 20px;
            background-color: #2980b9;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .product-item a:hover {
            background-color: #3498db;
        }

        /* Footer */
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

        /* Media Queries for Mobile Responsiveness */
        @media (max-width: 768px) {
            .main-content {
                flex-direction: column;
            }

            .filter-sidebar {
                width: 100%;
                margin-right: 0;
                margin-bottom: 20px;
            }

            .product-item {
                width: 90%;
                margin: 0 auto;
            }

            header, footer, nav {
    background-color: #343a40; /* Same as header background */
    color: #ffffff; /* White text color */
    padding: 20px;
    text-align: center;
}

nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

nav ul li {
    display: inline;
    margin: 0 10px;
}

nav ul li a {
    color: #ffffff; /* Same text color as header */
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s ease;
}

nav ul li a:hover {
    color: #dddddd; /* Slightly lighter color for hover effect */
}
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
    <?php include 'templates/header.php'; ?>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Filter Sidebar -->
        <aside class="filter-sidebar">
            <h2>Filter Products</h2>
            <form action="" method="GET">
                <!-- Gender -->
                <label for="gender">Gender:</label>
                <select name="gender" id="gender">
                    <option value="">All</option>
                    <option value="Men" <?php echo ($gender == 'Men') ? 'selected' : ''; ?>>Men</option>
                    <option value="Women" <?php echo ($gender == 'Women') ? 'selected' : ''; ?>>Women</option>
                    <option value="Unisex" <?php echo ($gender == 'Unisex') ? 'selected' : ''; ?>>Unisex</option>
                </select>

                <!-- Age Group -->
                <label for="age_group">Age Group:</label>
                <select name="age_group" id="age_group">
                    <option value="">All</option>
                    <option value="Adult" <?php echo ($age_group == 'Adult') ? 'selected' : ''; ?>>Adult</option>
                    <option value="Teen" <?php echo ($age_group == 'Teen') ? 'selected' : ''; ?>>Teen</option>
                    <option value="Kid" <?php echo ($age_group == 'Kid') ? 'selected' : ''; ?>>Kid</option>
                </select>

                <!-- Size -->
                <label for="size">Size:</label>
                <select name="size" id="size">
                    <option value="">All</option>
                    <option value="7" <?php echo ($size == '7') ? 'selected' : ''; ?>>7</option>
                    <option value="8" <?php echo ($size == '8') ? 'selected' : ''; ?>>8</option>
                    <option value="9" <?php echo ($size == '9') ? 'selected' : ''; ?>>9</option>
                    <option value="10" <?php echo ($size == '10') ? 'selected' : ''; ?>>10</option>
                    <option value="11" <?php echo ($size == '11') ? 'selected' : ''; ?>>11</option>
                </select>

                <!-- Color -->
                <label for="color">Color:</label>
                <select name="color" id="color">
                    <option value="">All</option>
                    <option value="Red" <?php echo ($color == 'Red') ? 'selected' : ''; ?>>Red</option>
                    <option value="Blue" <?php echo ($color == 'Blue') ? 'selected' : ''; ?>>Blue</option>
                    <option value="Black" <?php echo ($color == 'Black') ? 'selected' : ''; ?>>Black</option>
                    <option value="White" <?php echo ($color == 'White') ? 'selected' : ''; ?>>White</option>
                </select>

                <!-- Rating -->
                <label for="rating">Rating:</label>
                <select name="rating" id="rating">
                    <option value="">All</option>
                    <option value="5" <?php echo ($rating == '5') ? 'selected' : ''; ?>>5 Stars</option>
                    <option value="4" <?php echo ($rating == '4') ? 'selected' : ''; ?>>4 Stars</option>
                    <option value="3" <?php echo ($rating == '3') ? 'selected' : ''; ?>>3 Stars</option>
                    <option value="2" <?php echo ($rating == '2') ? 'selected' : ''; ?>>2 Stars</option>
                    <option value="1" <?php echo ($rating == '1') ? 'selected' : ''; ?>>1 Star</option>
                </select>

                <!-- Category -->
                <label for="category_id">Category:</label>
                <select name="category_id" id="category_id">
                    <option value="">All</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>" <?php echo ($category_id == $category['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($category['name']); ?></option>
                    <?php endforeach; ?>
                </select>

                <button type="submit">Apply Filters</button>
            </form>
        </aside>

        <!-- Product Grid -->
        <section class="product-grid">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-item">
                        <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p>$<?php echo number_format($product['price'], 2); ?></p>
                        <a href="item_details.php?id=<?php echo $product['product_id']; ?>">View Details</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No products found based on your filters.</p>
            <?php endif; ?>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div>
                <h3>About Us</h3>
                <p>EM' Quality Shoes offers high-quality shoes for all genders and ages.</p>
            </div>
            <div>
                <h3>Customer Service</h3>
                <p>Contact us at support@emshoes.com</p>
            </div>
            <div>
                <h3>Follow Us</h3>
                <p>Social media links go here</p>
            </div>
        </div>

        <p>&copy; 2024 EM' Quality Shoes. All rights reserved.</p>
    </footer>
</body>
</html>
