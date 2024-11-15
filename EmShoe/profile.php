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
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        header {
            background-color: #3f51b5;
            color: white;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            font-size: 28px;
            margin: 0;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 10px 0;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            font-weight: 500;
        }

        nav ul li a:hover {
            color: #ddd;
        }

        .profile-container {
            width: 80%;
            max-width: 900px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            font-size: 16px;
        }

        .profile-container h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
            font-weight: 600;
        }

        .user-info {
            margin-bottom: 30px;
        }

        .user-info p {
            font-size: 18px;
            color: #666;
            margin-bottom: 10px;
        }

        .user-info p strong {
            color: #333;
        }

        .profile-buttons {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .profile-buttons a {
            display: block;
            padding: 14px 24px;
            background-color: #3f51b5;
            color: white;
            text-decoration: none;
            font-size: 16px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .profile-buttons a:hover {
            background-color: #283593;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .settings-btn {
            background-color: #f44336;
        }

        .settings-btn:hover {
            background-color: #d32f2f;
        }

        footer {
            background-color: #3f51b5;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: 40px;
        }

        footer p {
            margin: 0;
            font-size: 16px;
        }
    </style>
</head>
<body>
<?php include 'templates/header.php'; ?>

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
            <a href="edit_profile.php">Edit Profile</a>
            <a href="ordered_items.php">Ordered Items</a>
            <a href="order_history.php">Order History</a>
            <a href="settings.php" class="settings-btn">Settings</a>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 EM' Quality Shoes. All rights reserved.</p>
    </footer>

</body>
</html>
