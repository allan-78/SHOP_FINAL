<?php
$conn = new mysqli("localhost", "root", "", "ShoeShop");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully!";
}
?>

<?php

// Database connection
function connectDB() {
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ShoeShop";

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
// Sanitize input
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function getProductsByCategory($category_id) {
    global $db;  // Assuming $db is your database connection object

    // Query to fetch products with their category details
    $query = "
        SELECT p.*, c.name AS category_name, c.type AS category_type
        FROM Products p
        INNER JOIN Categories c ON p.category_id = c.id
        WHERE c.id = $category_id
    ";
    $result = mysqli_query($db, $query);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
// User registration
function registerUser($username, $password, $email, $first_name, $last_name, $phone, $address) {
    $conn = connectDB();

    // Sanitize input
    $username = sanitizeInput($username);
    $password = password_hash($password, PASSWORD_DEFAULT); // Hash password
    $email = sanitizeInput($email);
    $first_name = sanitizeInput($first_name);
    $last_name = sanitizeInput($last_name);
    $phone = sanitizeInput($phone);
    $address = sanitizeInput($address);

    $sql = "INSERT INTO users (username, password, email, first_name, last_name, phone, address) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $username, $password, $email, $first_name, $last_name, $phone, $address);

    if ($stmt->execute()) {
        $conn->close();
        return true;
    } else {
        $conn->close();
        return false;
    }
}

// User login
function loginUser($username, $password) {
    $conn = connectDB();
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_id'] = $user['id'];
        $conn->close();
        return true;
    } else {
        $conn->close();
        return false;
    }
}

// User logout
function logoutUser() {
    session_start();
    session_destroy();
}

// Function to get all products
function getProducts() {
    $conn = connectDB();
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    $conn->close();
    return $products;
}

// Function to get a product by its ID
function getProductReviews($productId) {
    global $db;  // Ensure $db is the global variable holding the database connection
    
    if ($db === null) {
        die("Database connection failed.");
    }
    
    // Prepare SQL query
    $stmt = $db->prepare("SELECT * FROM reviews WHERE product_id = :product_id");
    $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
    $stmt->execute();
    
    // Fetch the results
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}




    

// Function to get all categories
function getCategories() {
    $conn = connectDB();
    $sql = "SELECT * FROM categories";
    $result = $conn->query($sql);
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
    $conn->close();
    return $categories;
}

// Function to get category by ID
function getCategoryById($category_id) {
    $conn = connectDB();
    $sql = "SELECT * FROM categories WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();
    $conn->close();
    return $category;
}

// Function to get products by category ID
function getProductsByCategoryId($category_id) {
    $conn = connectDB();
    $sql = "SELECT * FROM products WHERE category_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    $conn->close();
    return $products;
}

// Function to get all categories (alternative name)
function getAllCategories() {
    return getCategories();
}

// Function to get user details by ID
function getUserDetails($user_id) {
    $conn = connectDB();
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $conn->close();
    return $user;
}

// Function to update user details
function updateUserDetails($user_id, $username, $email, $first_name, $last_name, $phone, $address) {
    $conn = connectDB();

    // Sanitize input
    $username = sanitizeInput($username);
    $email = sanitizeInput($email);
    $first_name = sanitizeInput($first_name);
    $last_name = sanitizeInput($last_name);
    $phone = sanitizeInput($phone);
    $address = sanitizeInput($address);

    $sql = "UPDATE users SET username = ?, email = ?, first_name = ?, last_name = ?, phone = ?, address = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $username, $email, $first_name, $last_name, $phone, $address, $user_id);

    if ($stmt->execute()) {
        $conn->close();
        return true;
    } else {
        $conn->close();
        return false;
    }
}

// Function to get order items by order ID
function getOrderItemsByOrderId($order_id) {
    $conn = connectDB();
    $sql = "SELECT oi.*, p.name AS product_name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order_items = [];
    while ($row = $result->fetch_assoc()) {
        $order_items[] = $row;
    }
    $conn->close();
    return $order_items;
}
// In functions.php
function emailExists($email) {
    $conn = connectDB(); // Establish the connection here
    $email = sanitizeInput($email); // Make sure to sanitize input

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $conn->close(); // Always close the connection
    return $result->num_rows > 0;
}
function usernameExists($username) {
    $conn = connectDB(); // Establish the connection
    $username = sanitizeInput($username); // Sanitize input

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $conn->close(); // Close connection
    return $result->num_rows > 0; // Returns true if username exists
}

// In your functions.php file
function getFilteredProducts($gender, $age_group, $size, $color, $rating, $category_id) {
    global $conn; // Assuming you're using $conn as your MySQLi connection

    $sql = "SELECT * FROM products WHERE 1"; // Basic query

    // Add conditions based on the filters
    if ($gender) {
        $sql .= " AND gender = ?";
    }
    if ($age_group) {
        $sql .= " AND age_group = ?";
    }
    if ($size) {
        $sql .= " AND size = ?";
    }
    if ($color) {
        $sql .= " AND color = ?";
    }
    if ($rating) {
        $sql .= " AND rating >= ?";
    }
    if ($category_id) {
        $sql .= " AND category_id = ?";
    }

    $stmt = $conn->prepare($sql);
    
    // Bind the parameters dynamically based on the conditions
    $types = ''; // This will store the types for binding parameters
    $params = []; // This will store the parameters

    // Bind the parameters based on the condition
    if ($gender) {
        $types .= 's'; // 's' for string
        $params[] = $gender;
    }
    if ($age_group) {
        $types .= 's';
        $params[] = $age_group;
    }
    if ($size) {
        $types .= 's';
        $params[] = $size;
    }
    if ($color) {
        $types .= 's';
        $params[] = $color;
    }
    if ($rating) {
        $types .= 'i'; // 'i' for integer
        $params[] = $rating;
    }
    if ($category_id) {
        $types .= 'i';
        $params[] = $category_id;
    }

    // Bind the parameters to the prepared statement
    if ($types) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    
    // Fetch the results
    $result = $stmt->get_result();
    $products = [];
    
    // Fetch each row and store it in the products array
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    return $products; // Return the array of products
}



function getProduct($product_id) {
    $conn = connectDB(); // Make sure this function connects to your database properly.

    $product_id = (int) $product_id; // Sanitize input

    $sql = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // If a product is found, return it, otherwise return null
        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Return the product as an associative array
        } else {
            return null; // No product found with this ID
        }
    } else {
        return null; // Query execution failed
    }
}


function getProductsByName($searchQuery) {
    global $conn;  // Assuming you have a $conn variable for the database connection

    $searchQuery = "%" . $searchQuery . "%"; // Adding wildcard for LIKE query
    $sql = "SELECT * FROM products WHERE name LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $searchQuery);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

// Add more functions as needed
?>
