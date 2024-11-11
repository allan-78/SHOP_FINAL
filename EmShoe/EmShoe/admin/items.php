<?php
require_once '../includes/functions/functions.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: index.php");
    exit;
}

$products = getProducts(); // Get all products
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Shoe Inventory</title>
    <link rel="stylesheet" href="../layout/css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Shoe Inventory</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo getCategoryName($product['category_id']); ?></td>
                        <td><?php echo $product['price']; ?></td>
                        <td><?php echo $product['stock']; ?></td>
                        <td><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" width="50"></td>
                        <td>
                            <a href="edit_item.php?id=<?php echo $product['id']; ?>">Edit</a>
                            <a href="delete_item.php?id=<?php echo $product['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="add_item.php">Add New Shoe</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>