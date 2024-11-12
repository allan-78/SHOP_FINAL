<?php
require_once 'includes/functions/functions.php';
$categories = getCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoe Categories | EM' Quality Shoes</title>
    <link rel="stylesheet" href="layout/css/style.css">
    <style>
        /* General Styles */
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
            margin: 0;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        nav ul li a {
            color: #ffffff;
            text-decoration: none;
            padding: 5px 10px;
        }

        nav ul li a:hover {
            background-color: #495057;
            border-radius: 4px;
        }

        /* Section and Grid Styles */
        .section {
            padding: 40px 20px;
            max-width: 1200px;
            margin: auto;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            justify-items: center;
        }

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

        footer p {
            margin: 0;
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
        <p>&copy; 2024 EM' Quality Shoes. All rights reserved.</p>
    </footer>
</body>
</html>
