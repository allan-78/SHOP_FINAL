<?php
session_start();
require_once 'includes/functions/functions.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];  // Get the user ID from the session

// Fetch the user's profile information
try {
    if (!isset($pdo)) {
        // Make sure the database connection is set up
        $pdo = new PDO("mysql:host=localhost;dbname=shoeshop", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Adjusted query: 'id' is the column name in the database
    $sql = "SELECT * FROM users WHERE id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user exists
    if (!$user) {
        echo "User not found!";
        exit();
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="layout/css/style.css">
    <style>
        /* Add your existing styles here */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        header {
            background-color: #3f51b5;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 30px;
            font-weight: 600;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 10px 0;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            font-weight: 500;
        }

        nav ul li a:hover {
            color: #ddd;
        }

        .profile-container {
            width: 70%;
            margin: 40px auto;
            background-color: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .profile-container h2 {
            font-size: 30px;
            margin-bottom: 20px;
            color: #333;
        }

        .profile-container p {
            font-size: 18px;
            line-height: 1.6;
            color: #666;
            margin-bottom: 10px;
        }

        .profile-container .user-info {
            margin-bottom: 30px;
        }

        .profile-buttons {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .profile-buttons a {
            display: block;
            padding: 15px;
            background-color: #3f51b5;
            color: white;
            text-decoration: none;
            font-size: 18px;
            font-weight: 600;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .profile-buttons a:hover {
            background-color: #283593;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .footer {
            background-color: #3f51b5;
            color: #fff;
            text-align: center;
            padding: 15px 0;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        .settings-btn {
            background-color: #f44336;
        }

        .settings-btn:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to EM' Quality Shoes</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
        </nav>
    </header>

    <div class="profile-container">
        <h2>Welcome, <?php echo htmlspecialchars($user['first_name']) . ' ' . htmlspecialchars($user['last_name']); ?>!</h2>

        <div class="user-info">
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
        </div>

        <!-- Button to view reviews or order history -->
        <div class="profile-buttons">
            <a href="my_reviews.php">View My Reviews</a>
        </div>

        <div class="profile-buttons">
            <a href="edit_profile.php">Edit Profile</a>
            <a href="ordered_items.php">Ordered Items</a>
            <a href="order_history.php">Order History</a>
            <a href="settings.php" class="settings-btn">Settings</a>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2024 EM' Quality Shoes. All rights reserved.</p>
    </footer>
</body>
</html>
