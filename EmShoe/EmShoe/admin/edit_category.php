<?php
require_once '../includes/functions/functions.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$category = getCategoryById($id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission and update the category in the database
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Edit Category</title>
    <link rel="stylesheet" href="../layout/css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Edit Category</h1>
        <form method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $category['name']; ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description"><?php echo $category['description']; ?></textarea>

            <button type="submit">Update Category</button>
        </form>
        <a href="categories.php">Back to Categories</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>