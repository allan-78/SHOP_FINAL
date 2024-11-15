<?php
require_once 'includes/functions/functions.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Contact | EM' Quality Shoes</title>
    <link rel="stylesheet" href="layout/css/style.css">
    <style>
        /* General Styles */
        body, html {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            height: 100%; /* Ensure body and html take full height */
            display: flex;
            flex-direction: column; /* Stack elements vertically */
        }

        header, footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            width: 100%;
        }

        /* Footer specific styles */
        footer {
            margin-top: auto; /* Ensure footer stays at the bottom */
        }

        /* Footer Content */
        .footer-content {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 40px;
            margin-top: 30px;
        }

        .footer-content div {
            width: 30%;
            padding: 20px;
            text-align: left;
        }

        .footer-content h3 {
            font-size: 1.8em;
            margin-bottom: 15px;
            color: #fff;
        }

        .footer-content p {
            font-size: 1.1em;
            color: #ddd;
        }

        footer p {
            font-size: 1rem;
            margin-top: 10px;
        }

        /* Section for Contact */
        .section {
            padding: 40px 20px;
            flex-grow: 1; /* Allow the section to grow and take available space */
        }

        /* Category Grid */
        .category-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .category-item {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #ddd;
            text-align: center;
            width: 200px;
        }

        .category-item h3 {
            margin: 0 0 10px 0;
        }
    </style>
</head>
<body>
    <?php include 'templates/header.php'; ?>

    <main>
        <section class="section contact">
            <h2>Contact Us</h2>
            <p>Email: info@emqualityshoes.com</p>
            <p>Phone: 123-456-7890</p>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <div>
                <h3>About Us</h3>
                <p>We offer a wide selection of high-quality shoes at affordable prices.</p>
            </div>
            <div>
                <h3>Contact Us</h3>
                <p>Email: info@emqualityshoes.com</p>
                <p>Phone: 123-456-7890</p>
            </div>
            <div>
                <h3>Follow Us</h3>
                <p>Facebook | Instagram | Twitter</p>
            </div>
        </div>
        <p>&copy; 2024 EM' Quality Shoes. All rights reserved.</p>
    </footer>
</body>
</html>
