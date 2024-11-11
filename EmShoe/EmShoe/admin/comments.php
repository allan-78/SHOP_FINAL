<?php
require_once '../includes/functions/functions.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: index.php");
    exit;
}

$comments = getComments(); // Get all comments
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Comments</title>
    <link rel="stylesheet" href="../layout/css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Comments</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>User</th>
                    <th>Comment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comments as $comment): ?>
                    <tr>
                        <td><?php echo $comment['id']; ?></td>
                        <td><?php echo getProductById($comment['product_id'])['name']; ?></td>
                        <td><?php echo getUserById($comment['user_id'])['username']; ?></td>
                        <td><?php echo $comment['content']; ?></td>
                        <td>
                            <a href="edit_comment.php?id=<?php echo $comment['id']; ?>">Edit</a>
                            <a href="delete_comment.php?id=<?php echo $comment['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>