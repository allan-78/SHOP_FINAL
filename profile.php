<?php
require_once 'includes/functions/functions.php';
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
    header("Location: login.php");
    exit;
}

// Fetch user details
$user = getUserDetails($_SESSION['user_id']);

// Initialize variables
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $first_name = sanitizeInput($_POST['first_name']);
    $last_name = sanitizeInput($_POST['last_name']);
    $phone = sanitizeInput($_POST['phone']);
    $address = sanitizeInput($_POST['address']);
    
    if (empty($username) || empty($email)) {
        $errors[] = 'Username and email are required.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format.';
    }

    // Update user details if no errors
    if (empty($errors)) {
        $update = updateUserDetails($_SESSION['user_id'], $username, $email, $first_name, $last_name, $phone, $address);
        if ($update) {
            $success = 'Profile updated successfully.';
            // Refresh user details
            $user = getUserDetails($_SESSION['user_id']);
        } else {
            $errors[] = 'Failed to update profile. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profile | EM' Quality Shoes</title>
    <link rel="stylesheet" href="layout/css/style.css">
    <style>
        .profile-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .profile-container h2 {
            margin-bottom: 20px;
        }
        .profile-container form {
            display: flex;
            flex-direction: column;
        }
        .profile-container label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        .profile-container input {
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .profile-container .error {
            color: #ff0000;
            margin-bottom: 10px;
        }
        .profile-container .success {
            color: #28a745;
            margin-bottom: 10px;
        }
        .profile-container button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .profile-container button:hover {
            background-color: #0056b3;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        header, footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        nav ul {
            list-style: none;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin: 0 10px;
        }
        nav ul li a {
            color: #ffffff;
            text-decoration: none;
        }
        .hero {
            background-image: url('layout/images/hero.jpg');
            background-size: cover;
            background-position: center;
            color: #ffffff;
            text-align: center;
            padding: 100px 20px;
        }
        .hero h1 {
            font-size: 3em;
            margin: 0;
        }
        .hero p {
            font-size: 1.5em;
        }
        .hero a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
        }
        .section {
            padding: 40px 20px;
        }
        .product-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .product-item {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #ddd;
            text-align: center;
            width: 200px;
        }
        .product-item img {
            max-width: 100%;
            height: auto;
        }
        .footer-content {
            display: flex;
            justify-content: space-around;
        }
        .footer-content div {
            width: 30%;
        }
    </style>
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <main>
        <div class="profile-container">
            <h2>Your Profile</h2>
            <?php if (!empty($errors)): ?>
                <div class="error"><?php echo implode('<br>', $errors); ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>">
                
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>">
                
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
                
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>">
                
                <button type="submit">Update Profile</button>
            </form>
        </div>
    </main>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
