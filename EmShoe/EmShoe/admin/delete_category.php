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
    // Handle form submission and delete the category from the database
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Delete Category</title>
    <link rel="stylesheet" href="../layout/css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Delete Category</h1>
        <p>Are you sure you want to delete "<?php echo $category['name']; ?>"?</p>
        <form method="post">
            <button type="submit">Delete</button>
            <a href="categories.php">Cancel</a>
        </form>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>