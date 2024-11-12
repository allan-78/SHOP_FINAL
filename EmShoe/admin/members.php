<?php
// Include the necessary functions and start session
require_once('../includes/functions/functions.php');
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: index.php"); // Redirect to login if not an admin
    exit;
}

// Fetch all users from the database
$users = getUsers();

// Database function to fetch users
function getUsers() {
    $conn = connectDB(); // Ensure you have a proper DB connection function
    $sql = "SELECT * FROM users"; // Adjust table name if necessary
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC); // Fetch all users as an associative array
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - User Accounts</title>
    <link rel="stylesheet" href="../layout/css/admin.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding-top: 30px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .actions a {
            margin: 0 10px;
        }
        .btn {
            padding: 8px 15px;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-danger {
            background-color: #dc3545;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>User Accounts</h1>
        
        <!-- User Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($users) > 0): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td class="actions">
                                <!-- Edit User -->
                                <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn">Edit</a>

                                <!-- Delete User (you should implement this functionality) -->
                                <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>

                                <!-- Add more actions as needed (e.g., ban, promote) -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Links for managing users -->
        <div class="actions">
            <a href="add_user.php" class="btn">Add New User</a>
            <a href="dashboard.php" class="btn">Go to Dashboard</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

</body>
</html>
