<?php
// Database configuration
$host = 'localhost';  // Database host
$dbname = 'ShoeShop';  // Database name (change this to your actual database name)
$username = 'root';    // Database username (change this as necessary)
$password = '';        // Database password (change this as necessary)

try {
    // Create a new PDO instance
    $pdo = new PDO($username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If there's an error with the database connection
    die("Database connection failed: " . $e->getMessage());
}