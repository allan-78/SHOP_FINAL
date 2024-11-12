<?php
// Include database connection and functions
require_once '../includes/functions/functions.php';
session_start(); // Start the session to handle login state

// Check if the admin is already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php'); // Redirect to dashboard if already logged in
    exit;
}

// Establish database connection
$conn = connectDB();

// Handle login form submission
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepare SQL query with a placeholder
    $loginQuery = "SELECT * FROM admin_users WHERE username = ?";

    // Prepare the query
    $stmt = $conn->prepare($loginQuery);
    
    if ($stmt === false) {
        // If prepare() fails, output the error message
        die("Query Preparation Failed: " . $conn->error);
    }

    // Bind parameters and execute
    $stmt->bind_param("s", $username); // 's' indicates the parameter is a string
    $stmt->execute(); // Execute the query
    $result = $stmt->get_result(); // Get the result of the query

    // Check if we found the user
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc(); // Fetch the admin data
        if (password_verify($password, $admin['password'])) { // Verify the password
            // Set session variables if login is successful
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];
            header('Location: dashboard.php'); // Redirect to dashboard
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }

    // Close the prepared statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - EM' Quality Shoes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f2f2f2;
        }
        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 100px auto;
            max-width: 400px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="login-container">
                <h2 class="text-center mb-4">Admin Login</h2>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" name="login">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
