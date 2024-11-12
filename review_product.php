<?php
require_once 'includes/functions/functions.php'; // Ensure the correct path
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch the product ID from the URL
if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id'];
    
    // Fetch product details (optional, to display product name)
    $product = getProduct($product_id);
    
    // Fetch existing review if any
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM reviews WHERE product_id = :product_id AND user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);
    $existing_review = $stmt->fetch(PDO::FETCH_ASSOC);

} else {
    echo "Invalid product ID.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = $_POST['rating'];
    $review_text = $_POST['review_text'];
    
    // Insert or update the review
    if ($existing_review) {
        // Update existing review
        $sql = "UPDATE reviews SET rating = :rating, review_text = :review_text, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['rating' => $rating, 'review_text' => $review_text, 'id' => $existing_review['id']]);
    } else {
        // Insert new review
        $sql = "INSERT INTO reviews (product_id, user_id, rating, review_text) VALUES (:product_id, :user_id, :rating, :review_text)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'product_id' => $product_id,
            'user_id' => $user_id,
            'rating' => $rating,
            'review_text' => $review_text
        ]);
    }

    // Success message and redirect back to product page or cart
    $_SESSION['message'] = "Your review has been submitted successfully!";
    header("Location: product_page.php?id=$product_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Product</title>
    <link rel="stylesheet" href="layout/css/style.css">
</head>
<body>

<header>
    <h1>Review Product</h1>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="profile.php">Profile</a></li>
        </ul>
    </nav>
</header>

<div class="review-form">
    <h2>Leave a Review for "<?php echo htmlspecialchars($product['name']); ?>"</h2>

    <?php if ($existing_review): ?>
        <p>Your previous review:</p>
        <p>Rating: <?php echo $existing_review['rating']; ?></p>
        <p>Review: <?php echo $existing_review['review_text']; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="rating">Rating (1-5):</label>
        <input type="number" name="rating" min="1" max="5" value="<?php echo $existing_review ? $existing_review['rating'] : ''; ?>" required>

        <label for="review_text">Review:</label>
        <textarea name="review_text" rows="4" required><?php echo $existing_review ? $existing_review['review_text'] : ''; ?></textarea>

        <button type="submit">Submit Review</button>
    </form>
</div>

</body>
</html>
