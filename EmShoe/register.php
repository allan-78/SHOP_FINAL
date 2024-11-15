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
            font-size: 24px;
            font-weight: bold;
        }

        /* Hover effect for the header */
       /* Hover effect for the header */
        header a:hover {
             text-decoration: none;
             color: #FFD700; /* Gold color for text */
             text-shadow: 0 0 10px rgba(255, 215, 0, 0.7), 0 0 20px rgba(255, 215, 0, 0.5); /* Gold glow effect */
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
        <!-- Make header text clickable, redirecting to index.php -->
        <a href="index.php">EM' Quality Shoes</a>
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
