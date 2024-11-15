<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EmShoe</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Make sure the body takes up the full height of the screen */
        body, html {
            height: 100%; /* Full height */
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        /* Flexbox container to center content */
        .container {
            display: flex;
            justify-content: center; /* Horizontally centers */
            align-items: center; /* Vertically centers */
            height: 100%; /* Take up full height */
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h2 {
            font-size: 2rem;
            font-weight: 600;
            color: #343a40;
        }

        .form-group label {
            font-weight: bold;
            color: #343a40;
        }

        .btn-login {
            background-color: #007bff;
            color: white;
            font-size: 1.1rem;
            padding: 12px;
            border-radius: 30px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn-login:hover {
            background-color: #0056b3;
        }

        .alert-danger {
            margin-bottom: 20px;
        }

        .admin-link {
            text-align: center;
            margin-top: 20px;
        }

        .admin-link a {
            color: #007bff;
        }

        .admin-link a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .login-container {
                padding: 20px;
            }

            .login-header h2 {
                font-size: 1.8rem;
            }
        }

        /* Login button */
           
            .btn-login {
             background-color: #007bff;
             color: white;
             font-size: 1.1rem;
             padding: 12px;
             border-radius: 30px;
             width: 100%;
             transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease, color 0.3s ease;
}

        /* Hover effect for the button */
            .btn-login:hover {
             background-color: #0056b3;
             transform: scale(1.05); /* Slightly enlarges the button */
             box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4); /* Adds a subtle shadow for depth */
             color: gold; /* Changes the text color to gold on hover */
        }


    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h2 class="login-header">Login to EmShoe</h2>
            
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            
            <form method="post" action="login.php" autocomplete="off">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required aria-label="Enter your username">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required aria-label="Enter your password">
                </div>
                <button type="submit" class="btn btn-login">Login</button>
            </form>
            
            <div class="admin-link">
                <p>If you are an admin, <a href="../admin/index.php">click here to login as admin</a>.</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
