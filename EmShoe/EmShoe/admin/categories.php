<?php
require_once '../includes/functions/functions.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: index.php");
    exit;
}

$categories = getCategories(); // Get all categories
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Categories</title>
    <link rel="stylesheet" href="../layout/css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Categories</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?php echo $category['id']; ?></td>
                        <td><?php echo $category['name']; ?></td>
                        <td>
                            <a href="edit_category.php?id=<?php echo $category['id']; ?>">Edit</a>
                            <a href="delete_category.php?id=<?php echo $category['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="add_category.php">Add New Category</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>