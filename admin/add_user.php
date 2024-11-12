<?php
// Include database connection file
require_once('../includes/functions/functions.php');

// Ensure the database connection is set up properly
$conn = connectDB();  // Assuming you have a `connectDB()` function in `functions.php`

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user input to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Remember to hash the password before storing!
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Validation (add more validation as needed)
    if (empty($username) || empty($password) || empty($email)) {
        $error = "Please fill out all required fields.";
    } else {
        // Check if username or email already exists
        $checkUsername = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        $checkEmail = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
        if (mysqli_num_rows($checkUsername) > 0) {
            $error = "Username already exists.";
        } else if (mysqli_num_rows($checkEmail) > 0) {
            $error = "Email already exists.";
        } else {
            // Hash the password using bcrypt
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert the new user into the database
            $sql = "INSERT INTO users (username, password, email, first_name, last_name, phone, address) 
                    VALUES ('$username', '$hashedPassword', '$email', '$first_name', '$last_name', '$phone', '$address')";
            
            if (mysqli_query($conn, $sql)) {
                // Success: user added successfully
                $success = "User added successfully.";
                // Redirect to dashboard after success
                header("Location: dashboard.php");
                exit();  // Stop further code execution after redirection
            } else {
                // Error
                $error = "Error: " . mysqli_error($conn);
            }
        }
    }
} 
?>

<div class="container">
    <h2>Add New User</h2>

    <?php 
        // Display any error or success messages
        if (isset($error)) {
            echo '<div class="message error">' . $error . '</div>';
        }
        if (isset($success)) {
            echo '<div class="message success">' . $success . '</div>';
        }
    ?>

    <!-- User Addition Form -->
    <form method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" id="phone" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" name="address" id="address" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Add User</button>
    </form>

    <!-- Link back to Dashboard (in case the user doesn't get redirected) -->
    <div class="back-link">
        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
</div>

<!-- Minimalist CSS for Styling -->
<style>
    /* General Styles */
    body {
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        background-color: #f4f7f6;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 40%;
        margin: 50px auto;
        padding: 30px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        font-size: 24px;
        color: #333;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        font-size: 14px;
        color: #555;
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        color: #333;
        background-color: #f9f9f9;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        border-color: #007bff;
        outline: none;
    }

    button.btn {
        width: 100%;
        padding: 12px;
        background-color: #007bff;
        border: none;
        border-radius: 4px;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    button.btn:hover {
        background-color: #0056b3;
    }

    .message {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }

    .error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .back-link {
        margin-top: 20px;
    }

    .back-link a {
        padding: 10px 20px;
        background-color: #f0f0f0;
        color: #333;
        border-radius: 4px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .back-link a:hover {
        background-color: #ddd;
    }
</style>
