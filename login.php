<?php
require_once 'includes/functions/functions.php';
session_start();

$message = "";

if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $role = loginUser($username, $password);
    if ($role) {
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_role'] = $role;
        $message = "Logged in successfully!";
        
        if ($role == 'admin') {
            header("Location: ../EmShoe/admin/dashboard.php");
            exit; // It's a good practice to call exit after a header redirect
        } else if ($role == 'user') {
            header("Location: index.php");
            exit; // Call exit again for this branch
        } else {
            header("Location: login.php");
            exit; // Call exit for the else branch as well
        }
    } else {
        $message = "Incorrect username or password. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="layout/css/style.css">
</head>
<body>
    <header>
        <h1>EM' Quality Shoes</h1>
        <!-- Navigation -->
    </header>
    <main>
        <section class="login">
            <h2>Login</h2>
            <?php if (!empty($message)): ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>
            <form method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </section>
    </main>
    <footer>
        <!-- Footer content -->
    </footer>
</body>
</html>
