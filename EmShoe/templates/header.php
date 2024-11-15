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
    /* General Reset */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Header Styles */
    header {
        background-color: #343a40;
        color: #ffffff;
        padding: 20px 0;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    header h1 {
        font-size: 2.8rem;
        font-weight: bold;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    /* Navigation Styles */
    nav {
        padding: 10px 0;
    }

    nav ul {
        list-style: none;
        display: flex;
        justify-content: center;
        gap: 30px; /* Increased spacing between items */
        padding: 0;
        margin: 0;
    }

    nav ul li {
        margin: 0;
    }

    nav ul li a {
        color: #ffffff;
        text-decoration: none;
        font-size: 1.2rem;
        font-weight: bold;
        padding: 10px 20px; /* Added padding for a button-like effect */
        border-radius: 5px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    nav ul li a:hover {
        background-color: #ffc107;
        color: #343a40;
    }

    /* Search Bar Styles */
    .search-form {
        margin-top: 20px;
        text-align: center;
    }

    .search-form input {
        padding: 12px;
        width: 300px;
        font-size: 1rem;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-right: 10px; /* Space between input and button */
    }

    .search-form button {
        padding: 12px 20px;
        font-size: 1rem;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .search-form button:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        nav ul {
            flex-direction: column;
            gap: 15px; /* Reduced spacing for smaller screens */
        }

        header h1 {
            font-size: 2.2rem;
        }

        .search-form input {
            width: 100%;
            margin-bottom: 10px;
        }

        .search-form button {
            width: 100%;
        }
    }
</style>
