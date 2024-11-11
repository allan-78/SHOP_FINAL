<?php
require_once '../includes/functions/functions.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission and add the new product to the database
}

$categories = getCategories(); // Get all categories
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Add New Shoe</title>
    <link rel="stylesheet" href="../layout/css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Add New Shoe</h1>
        <form method="post" enctype="multipart/form-data">
            <!-- Form fields for adding a new product -->
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea>

            <label for="category">Category:</label>
            <select id="category" name="category_id" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required>

            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" required>

            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*">

            <button type="submit">Add Product</button>
        </form>
        <a href="items.php">Back to Inventory</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>