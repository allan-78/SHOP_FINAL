<?php
// Start the session
session_start();

// Ensure the user is an admin
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: index.php");  // Redirect to login if not an admin
    exit;
}

// Database connection function
function connectDB() {
    $conn = new mysqli('localhost', 'root', '', 'ShoeShop'); // Use your DB credentials here
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Get total users
function getTotalUsers() {
    $conn = connectDB();
    $sql = "SELECT COUNT(*) AS total FROM users";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}

// Get total products
function getTotalProducts() {
    $conn = connectDB();
    $sql = "SELECT COUNT(*) AS total FROM products";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}

// Get recent orders
function getRecentOrders() {
    $conn = connectDB();
    $sql = "SELECT o.id, o.created_at, u.username, SUM(oi.quantity * oi.price) AS total_amount
            FROM orders o
            JOIN users u ON o.user_id = u.id
            JOIN order_items oi ON o.id = oi.order_id
            GROUP BY o.id
            ORDER BY o.created_at DESC
            LIMIT 5";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Get recent orders, total users and products
$totalUsers = getTotalUsers();
$totalProducts = getTotalProducts();
$recentOrders = getRecentOrders();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EM' Quality Shoes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }
        .dashboard-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
        }
        .dashboard-card h3 {
            margin-bottom: 15px;
        }
        .card-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .card-row .card {
            flex: 1;
            margin: 0 15px;
        }
        .dashboard-actions a {
            margin-right: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Admin Dashboard</h1>

        <!-- Dashboard Metrics -->
        <div class="card-row">
            <!-- Total Users -->
            <div class="card">
                <div class="dashboard-card">
                    <h3>Total Users</h3>
                    <p><?php echo $totalUsers; ?></p>
                </div>
            </div>

            <!-- Total Products -->
            <div class="card">
                <div class="dashboard-card">
                    <h3>Total Products</h3>
                    <p><?php echo $totalProducts; ?></p>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card">
                <div class="dashboard-card">
                    <h3>Recent Orders</h3>
                    <ul>
                        <?php foreach ($recentOrders as $order): ?>
                            <li>Order #<?php echo $order['id']; ?> - <?php echo $order['username']; ?> - $<?php echo number_format($order['total_amount'], 2); ?> - <?php echo $order['created_at']; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Admin Actions -->
        <div class="dashboard-actions">
            <h3>Admin Management</h3>
            <a href="add_category.php" class="btn btn-primary">Add Category</a>
            <a href="add_item.php" class="btn btn-primary">Add Product</a>
            <a href="add_user.php" class="btn btn-primary">Add User</a>
            <a href="edit_category.php" class="btn btn-secondary">Edit Category</a>
            <a href="edit_item.php" class="btn btn-secondary">Edit Product</a>
            <a href="edit_user.php" class="btn btn-secondary">Edit User</a>
            <a href="delete_category.php" class="btn btn-warning">Delete Category</a>
            <a href="delete_item.php" class="btn btn-warning">Delete Product</a>
            <a href="members.php" class="btn btn-info">Manage Users</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
