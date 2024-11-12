<header>
    <h1>EM' Quality Shoes</h1>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="cart.php">Cart</a></li>
            <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']): ?>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Search Form -->
    <form action="search.php" method="GET" class="search-form">
        <input type="text" name="search" placeholder="Search for products..." required>
        <button type="submit">Search</button>
    </form>
</header>

<style>
    /* Header styling */
    header {
        background-color: #343a40;
        color: white;
        padding: 20px;
        text-align: center;
    }

    header h1 {
        margin: 0;
        font-size: 2.5em;
    }

    nav ul {
        list-style: none;
        padding: 0;
        text-align: center;
        margin-top: 20px;
    }

    nav ul li {
        display: inline;
        margin: 0 15px;
    }

    nav ul li a {
        color: white;
        text-decoration: none;
        font-size: 1.1em;
    }

    /* Search bar styling */
    .search-form {
        margin-top: 20px;
        text-align: center;
    }

    .search-form input {
        padding: 10px;
        width: 250px;
        font-size: 1em;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .search-form button {
        padding: 10px 15px;
        font-size: 1em;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .search-form button:hover {
        background-color: #0056b3;
    }
</style>
