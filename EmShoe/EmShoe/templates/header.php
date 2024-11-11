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
</header>
