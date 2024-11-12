<?php
require_once 'includes/functions/functions.php';
session_start();
?>
<!DOCTYPE html>
<html>
<style>
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
        .section {
            padding: 40px 20px;
        }
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
<head>
    <title>Contact | EM' Quality Shoes</title>
    <link rel="stylesheet" href="layout/css/style.css">
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
    <?php include 'templates/footer.php'; ?>
</body>
</html>
