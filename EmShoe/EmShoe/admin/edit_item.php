<?php
require_once '../includes/functions/functions.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$product = getProductById($id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission and update the product in the database
}

$categories = getCategories(); // Get all categories
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Edit Shoe</title>
    <link rel="stylesheet" href="../layout/css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Edit Shoe</h1>
        <form method="post" enctype="multipart/form-data">
            <!-- Form fields for editing the product -->
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $product['name']; ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description"><?php echo $product['description']; ?></textarea>

            <label for="category">Category:</label>
            <select id="category" name="category_id" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>" <?php if ($category['id'] == $product['category_id']) echo 'selected'; ?>><?php echo $category['name']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo $product['price']; ?>" required>

            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" value="<?php echo $product['stock']; ?>" required>

            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*">
            <?php if (!empty($product['image'])): ?>
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" width="100">
            <?php endif; ?>

            <button type="submit">Update Product</button>
        </form>
        <a href="items.php">Back to Inventory</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>