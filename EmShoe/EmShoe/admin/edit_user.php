<?php
require_once '../includes/functions/functions.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$user = getUserById($id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission and update the user in the database
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Edit User</title>
    <link rel="stylesheet" href="../layout/css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Edit User</h1>
        <form method="post">
            <!-- Form fields for editing the user -->
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>

            <!-- Add more fields for first_name, last_name, etc. -->

            <button type="submit">Update User</button>
        </form>
        <a href="members.php">Back to User Accounts</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>