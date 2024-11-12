<?php
require_once 'includes/functions/functions.php';
$message = "";

// Default role value
$role = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $firstName = $_POST['first_name'] ?? '';
    $lastName = $_POST['last_name'] ?? '';
    $address = $_POST['address'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $role = $_POST['role'] ?? ''; // Get role value from the form

    // Debugging: Check if the role is being received correctly.
    // echo "Selected Role: " . $role;

    // Check if email already exists
    if (emailExists($email)) {
        $message = "Email already registered. Please use a different email.";
    }
    // Check if username already exists
    elseif (usernameExists($username)) {
        $message = "Username already taken. Please choose a different username.";
    } else {
        // Check if role is 'admin' or 'user'
        if ($role == 'admin') {
            // Insert into admin_users table
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO admin_users (username, password) VALUES (?, ?)";
            $conn = connectDB();
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ss', $username, $hashedPassword);
            $result = $stmt->execute();
            $conn->close();

            if ($result) {
                $message = "Admin account created successfully!";
            } else {
                $message = "Failed to create admin account. Please try again.";
            }
        } elseif ($role == 'user') {
            // Insert into regular users table
            $result = registerUser($username, $password, $email, $firstName, $lastName, $phone, $address);
            if ($result) {
                $message = "User account created successfully!";
            } else {
                $message = "Failed to create user account. Please try again.";
            }
        } else {
            $message = "Please select a role.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - EM' Quality Shoes</title>
    <link rel="stylesheet" href="layout/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        main {
            padding: 20px;
        }
        .register-container {
            background-color: #fff;
            padding: 20px;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
        }
        .register-container h2 {
            margin-top: 0;
            color: #333;
        }
        .register-container input, .register-container select, .register-container textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        .register-container button {
            width: 100%;
            padding: 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .register-container button:hover {
            background-color: #0056b3;
        }
        .role-options {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .role-options label {
            flex: 1;
            text-align: center;
        }
        .register-container .message {
            color: red;
            margin-bottom: 15px;
        }
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: 30px;
        }
        .login-links a {
            display: inline-block;
            margin-top: 10px;
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
        }
        .login-links a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h1>EM' Quality Shoes</h1>
    </header>

    <main>
        <div class="register-container">
            <h2>Register</h2>
            <?php if (!empty($message)): ?>
                <p class="message"><?php echo $message; ?></p>
            <?php endif; ?>
            <form method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required>

                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required>

                <label for="address">Address:</label>
                <textarea id="address" name="address" required></textarea>

                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone" required>

                <label for="role">Role:</label>
                <div class="role-options">
                    <label>
                        <input type="radio" name="role" value="user" <?php echo ($role == 'user') ? 'checked' : ''; ?> required> User
                    </label>
                    <label>
                        <input type="radio" name="role" value="admin" <?php echo ($role == 'admin') ? 'checked' : ''; ?> required> Admin
                    </label>
                </div>

                <button type="submit">Register</button>
            </form>

            <div class="login-links">
                <p>Already have an account?</p>
                <a href="login.php">Go to User Login</a>
                <a href="admin/dashboard.php">Go to Admin Login</a>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 EM' Quality Shoes. All rights reserved.</p>
    </footer>
</body>
</html>
