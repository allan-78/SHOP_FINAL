<?php
// Start session
session_start();

// Database configuration
$host = 'localhost';  // Adjust for your local settings
$dbname = 'ShoeShop';  // Your database name
$username = 'root';    // Your MySQL username (default is 'root')
$password = '';        // Your MySQL password (default is '')

// Create the PDO connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error connecting to the database: " . $e->getMessage());
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and assign the form values
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);
    $email = trim($_POST['email']);
    $role = isset($_POST['role']) ? $_POST['role'] : ''; // Either 'user' or 'admin'
    
    // Additional user-specific fields
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Error handling: Check for missing fields or mismatched passwords
    if (empty($username) || empty($password) || empty($confirmPassword) || empty($email) || empty($role)) {
        $_SESSION['message'] = "All fields are required!";
        header("Location: register.php");
        exit();
    }

    if ($password !== $confirmPassword) {
        $_SESSION['message'] = "Passwords do not match!";
        header("Location: register.php");
        exit();
    }

    // Validate the email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "Invalid email format!";
        header("Location: register.php");
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL query for inserting the user
    try {
        if ($role === 'admin') {
            // Insert the user into the admin_users table
            $sql = "INSERT INTO admin_users (username, password) VALUES (:username, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'username' => $username,
                'password' => $hashedPassword
            ]);
        } else {
            // Insert the user into the users table
            $sql = "INSERT INTO users (username, password, email, first_name, last_name, phone, address, role) 
                    VALUES (:username, :password, :email, :first_name, :last_name, :phone, :address, :role)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'username' => $username,
                'password' => $hashedPassword,
                'email' => $email,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'phone' => $phone,
                'address' => $address,
                'role' => $role
            ]);
        }

        // Success message
        $_SESSION['message'] = "Registration successful! Please log in.";
        header("Location: login.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['message'] = "Error: " . $e->getMessage();
        header("Location: register.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | EM' Quality Shoes</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            padding-top: 50px;
            color: #333;
        }

        /* Header and Footer */
        header, footer {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        header a, footer a {
            color: #fff;
            text-decoration: none;
        }

        /* Register Form Section */
        .register-section {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            margin-top: 5px;
        }

        textarea.form-input {
            height: 100px;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        .role-options {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .submit-btn:focus, .form-input:focus {
            outline: none;
            border-color: #007bff;
        }

        @media (max-width: 600px) {
            .register-section {
                width: 90%;
            }
        }
    </style>
</head>
<body>

    <header>
        <h1>EM' Quality Shoes</h1>
    </header>

    <main>
        <section class="register-section">
            <h2>Register</h2>
            
            <!-- Display error message if exists -->
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert-error">
                    <?php echo $_SESSION['message']; ?>
                </div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            <form method="POST" action="register.php" class="register-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required class="form-input">
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required class="form-input">
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required class="form-input">
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required class="form-input">
                </div>
                
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" class="form-input">
                </div>
                
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" class="form-input">
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" class="form-input">
                </div>
                
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" class="form-input"></textarea>
                </div>
                
                <div class="form-group">
                    <label>Role</label>
                    <div class="role-options">
                        <label for="user">
                            <input type="radio" id="user" name="role" value="user" checked>
                            User
                        </label>
                        <label for="admin">
                            <input type="radio" id="admin" name="role" value="admin">
                            Admin
                        </label>
                    </div>
                </div>

                <button type="submit" class="submit-btn">Register</button>
            </form>
        </section>
    </main>

    <footer>
        <p>EM' Quality Shoes &copy; 2024</p>
    </footer>

</body>
</html>
