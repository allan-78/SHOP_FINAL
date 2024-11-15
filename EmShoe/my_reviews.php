<?php
session_start();
require_once 'includes/functions/functions.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];  // Get the user ID from the session

// Fetch the reviews
try {
    if (!isset($pdo)) {
        $pdo = new PDO("mysql:host=localhost;dbname=shoeshop", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    $sql_reviews = "SELECT r.*, p.name AS product_name 
                FROM reviews r 
                JOIN products p ON r.product_id = p.product_id 
                WHERE r.user_id = :user_id";
    $stmt_reviews = $pdo->prepare($sql_reviews);
    $stmt_reviews->execute(['user_id' => $user_id]);
    $reviews = $stmt_reviews->fetchAll(PDO::FETCH_ASSOC);

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
    <title>My Reviews | EM' Quality Shoes</title>
    <link rel="stylesheet" href="layout/css/style.css">
    <style>
    /* Global Styles */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    header {
        background-color: #343a40;
        color: #fff;
        padding: 20px 0;
        text-align: center;
    }

    header h1 {
        font-size: 2rem;
        margin: 0;
    }

    header nav {
        margin-top: 10px;
    }

    header nav ul {
        list-style: none;
        padding: 0;
    }

    header nav ul li {
        display: inline;
        margin-right: 20px;
    }

    header nav ul li a {
        color: #fff;
        text-decoration: none;
        font-size: 1rem;
        transition: color 0.3s;
    }

    header nav ul li a:hover {
        color: #007bff;
    }

    /* Main Content */
    .profile-container {
        width: 80%;
        margin: 40px auto;
        padding: 30px;
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .profile-container h2 {
        font-size: 1.8rem;
        color: #333;
        text-align: center;
        margin-bottom: 30px;
    }

    /* Review Card Styles */
    .review {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .review:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .review h3 {
        font-size: 1.4rem;
        color: #333;
        margin-bottom: 10px;
    }

    .review p {
        color: #555;
        font-size: 1rem;
        line-height: 1.6;
    }

    .review .rating {
        color: #28a745;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .review .created-at {
        font-size: 0.9rem;
        color: #6c757d;
        margin-top: 10px;
    }

    .no-reviews {
        text-align: center;
        font-size: 1.2rem;
        color: #dc3545;
    }

    .btn {
        display: inline-block;
        background-color: #007bff;
        color: #fff;
        padding: 12px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 1.1rem;
        text-align: center;
        margin-top: 20px;
        transition: background-color 0.3s, transform 0.2s;
    }

    .btn:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    /* Footer Styles */
    footer {
        background-color: #343a40;
        color: #fff;
        padding: 15px 0;
        text-align: center;
        font-size: 0.9rem;
    }
    </style>
</head>
<body>

    <header>
        <h1>My Reviews</h1>
        <nav>
            <ul>
                <li><a href="profile.php">Back to Profile</a></li>
            </ul>
        </nav>
    </header>

    <div class="profile-container">
        <?php if (count($reviews) > 0): ?>
            <h2>Your Reviews</h2>
            <?php foreach ($reviews as $review): ?>
                <div class="review">
                    <h3><?php echo htmlspecialchars($review['product_name']); ?></h3>
                    <p class="rating">Rating: <?php echo htmlspecialchars($review['rating']); ?>/5</p>
                    <p><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
                    <p class="created-at">Reviewed on: <?php echo htmlspecialchars($review['created_at']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-reviews">
                <p>You have not reviewed any products yet. <br> 
                <a href="ordered_items.php" class="btn">Click here to review your orders</a></p>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2024 EM' Quality Shoes. All rights reserved.</p>
    </footer>

</body>
</html>
