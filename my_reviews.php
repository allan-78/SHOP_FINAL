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
    <title>My Reviews</title>
    <link rel="stylesheet" href="layout/css/style.css">
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
                    <p><strong>Product:</strong> <?php echo htmlspecialchars($review['name']); ?></p>
                    <p><strong>Rating:</strong> <?php echo htmlspecialchars($review['rating']); ?>/5</p>
                    <p><strong>Review:</strong> <?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
                    <p><small>Reviewed on: <?php echo htmlspecialchars($review['created_at']); ?></small></p>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>You have not reviewed any products yet. <a href="ordered_items.php">Click here</a> to review your orders.</p>
        <?php endif; ?>
    </div>

    <footer class="footer">
        <p>&copy; 2024 EM' Quality Shoes. All rights reserved.</p>
    </footer>
</body>
</html>
