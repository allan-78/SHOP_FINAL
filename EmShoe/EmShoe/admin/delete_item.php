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
    // Handle form submission and delete the product from the database
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Delete Shoe</title>
    <link rel="stylesheet" href="../layout/css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Delete Shoe</h1>
        <p>Are you sure you want to delete "<?php echo $product['name']; ?>"?</p>
        <form method="post">
            <button type="submit">Delete</button>
            <a href="items.php">Cancel</a>
        </form>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>