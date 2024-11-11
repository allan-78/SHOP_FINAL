-- Create the database
CREATE DATABASE ShoeShop;

-- Use the database
USE ShoeShop;

CREATE TABLE Categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,  -- Primary key for Categories
    name VARCHAR(255) NOT NULL,                  -- Category name
    description TEXT,                            -- Description of the category
    type VARCHAR(255),                           -- Type of category (e.g., "Formal Shoes", "Casual Shoes")
    parent_id INT UNSIGNED DEFAULT NULL,         -- Reference to the parent category (NULL if no parent)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Timestamp for creation
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  -- Timestamp for updates
    FOREIGN KEY (parent_id) REFERENCES Categories(id) ON DELETE SET NULL  -- Self-referencing foreign key (parent category)
);

CREATE TABLE Products (
    product_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,  -- Primary key for Products
    name VARCHAR(255) NOT NULL,                           -- Product name
    description TEXT NOT NULL,                            -- Product description
    price DECIMAL(10, 2) NOT NULL,                        -- Price of the product
    image VARCHAR(255) NOT NULL,                          -- Path to the image of the product
    category_id INT UNSIGNED,                             -- Foreign key referencing Categories
    category_type VARCHAR(255) NOT NULL,                  -- Category type for the product (e.g., "Casual Shoes")
    gender VARCHAR(50) NOT NULL,                          -- Gender specification (Male, Female, Unisex, etc.)
    age_group VARCHAR(50) NOT NULL,                       -- Age group (Adult, Kids, etc.)
    size VARCHAR(50) NOT NULL,                            -- Available sizes (e.g., '7,8,9,10')
    color VARCHAR(50) NOT NULL,                           -- Available colors (e.g., Black, White, Red)
    rating DECIMAL(3, 2) NOT NULL,                        -- Product rating (e.g., 4.5)
    FOREIGN KEY (category_id) REFERENCES Categories(id)  -- Foreign key constraint on category_id
);



-- Create the Users table
CREATE TABLE Users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    phone VARCHAR(20),
    address TEXT,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create the Orders table
CREATE TABLE Orders (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create the Order Items table
CREATE TABLE Order_Items (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id INT UNSIGNED NOT NULL,
    product_id INT UNSIGNED NOT NULL,
    quantity INT UNSIGNED NOT NULL,
    price DECIMAL(10, 2) NOT NULL
);
-- Create the Review table
CREATE TABLE reviews (
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id INT(10) UNSIGNED NOT NULL,
    user_id INT(10) UNSIGNED NOT NULL,
    rating INT(1) NOT NULL CHECK (rating >= 1 AND rating <= 5),
    review_text TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create the Cart table
CREATE TABLE Cart (
    cart_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,  -- Primary key for the Cart table
    user_id INT UNSIGNED NOT NULL,                    -- Reference to the user owning the cart
    product_id INT UNSIGNED NOT NULL,                 -- Reference to the product in the cart
    quantity INT UNSIGNED NOT NULL,                   -- Quantity of the product in the cart
    price DECIMAL(10, 2) NOT NULL,                     -- Price of the product at the time it was added to the cart
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,    -- Timestamp for when the cart item was added
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  -- Timestamp for updates to the cart item
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,  -- Foreign key for user
    FOREIGN KEY (product_id) REFERENCES Products(product_id) ON DELETE CASCADE  -- Foreign key for product
);

-- Create the Comments table (optional)
CREATE TABLE Comments (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO Categories (name, description, type) VALUES
('Casual Shoes', 'Shoes for casual wear', 'Casual Shoes'),
('Formal Shoes', 'Shoes for formal occasions', 'Formal Shoes'),
('Running Shoes', 'Shoes designed for running', 'Running Shoes'),
('Slippers', 'Comfortable indoor footwear', 'Slippers'),
('Heels', 'High-heeled shoes for formal events', 'Heels');



-- Insert products with links to categories and additional attributes (gender, age_group, size, color, rating)
INSERT INTO Products (name, description, price, image, category_id, category_type, gender, age_group, size, color, rating) VALUES
-- Casual Shoes
('Casual Loafers', 'Comfortable loafers for casual wear', 39.99, 'images/loafers.jpg', 1, 'Casual Shoes', 'Men', 'Adult', '7,8,9,10,11', 'Black', 4),
('Leather Sneakers', 'Stylish leather sneakers for everyday use', 49.99, 'images/leather_sneakers.jpg', 1, 'Casual Shoes', 'Men', 'Adult', '7,8,9,10,11', 'White', 4),
('Canvas Slip-ons', 'Lightweight and breathable slip-on shoes', 29.99, 'images/canvas_slipons.jpg', 1, 'Casual Shoes', 'Women', 'Adult', '6,7,8,9,10', 'Blue', 5),
('Suede Moccasins', 'Soft and comfortable moccasins for casual wear', 55.99, 'images/suede_moccasins.jpg', 1, 'Casual Shoes', 'Unisex', 'Adult', '7,8,9,10,11', 'Brown', 4),
('Espadrilles', 'Casual summer shoes with a jute sole', 39.99, 'images/espadrilles.jpg', 1, 'Casual Shoes', 'Women', 'Adult', '6,7,8,9,10', 'Red', 5),
('Chukka Boots', 'Casual yet stylish ankle boots', 79.99, 'images/chukka_boots.jpg', 1, 'Casual Shoes', 'Men', 'Adult', '7,8,9,10,11', 'Black', 4),
('Boat Shoes', 'Perfect for summer days, lightweight and breathable', 65.99, 'images/boat_shoes.jpg', 1, 'Casual Shoes', 'Men', 'Adult', '7,8,9,10,11', 'Navy', 4),
('Slip-On Sneakers', 'Easy to wear slip-on sneakers for daily use', 34.99, 'images/slip_on_sneakers.jpg', 1, 'Casual Shoes', 'Unisex', 'Adult', '7,8,9,10,11', 'White', 3),
('Brogues', 'Classic brogue shoes for a smart casual look', 89.99, 'images/brogues.jpg', 1, 'Casual Shoes', 'Men', 'Adult', '8,9,10,11', 'Brown', 5),
('Casual Boots', 'Durable and comfortable boots for casual outings', 79.99, 'images/casual_boots.jpg', 1, 'Casual Shoes', 'Men', 'Adult', '7,8,9,10,11', 'Black', 4),

-- Formal Shoes
('Black Formal Shoes', 'Elegant formal shoes for business meetings', 89.99, 'images/formal_black.jpg', 2, 'Formal Shoes', 'Men', 'Adult', '7,8,9,10,11', 'Black', 5),
('Brown Oxford Shoes', 'Timeless brown oxford shoes for formal events', 120.99, 'images/oxford_brown.jpg', 2, 'Formal Shoes', 'Men', 'Adult', '7,8,9,10,11', 'Brown', 5),
('Loafers for Men', 'Sophisticated loafers for formal attire', 89.99, 'images/loafers_men.jpg', 2, 'Formal Shoes', 'Men', 'Adult', '7,8,9,10,11', 'Black', 4),
('Leather Derby Shoes', 'Classic derby shoes with leather finish', 109.99, 'images/derby_shoes.jpg', 2, 'Formal Shoes', 'Men', 'Adult', '7,8,9,10,11', 'Brown', 5),
('Patent Leather Shoes', 'Shiny black patent leather shoes for special occasions', 135.99, 'images/patent_leather.jpg', 2, 'Formal Shoes', 'Men', 'Adult', '7,8,9,10,11', 'Black', 5),
('Monk Strap Shoes', 'Elegant monk strap shoes with leather construction', 139.99, 'images/monk_strap.jpg', 2, 'Formal Shoes', 'Men', 'Adult', '7,8,9,10,11', 'Brown', 4),
('Formal Brogues', 'Stylish brogue design for a formal and fashionable look', 129.99, 'images/formal_brogues.jpg', 2, 'Formal Shoes', 'Men', 'Adult', '8,9,10,11', 'Black', 4),
('Dress Boots', 'Formal dress boots with sleek design', 149.99, 'images/dress_boots.jpg', 2, 'Formal Shoes', 'Men', 'Adult', '8,9,10,11', 'Black', 5),
('Wingtips', 'Classic wingtip shoes for business and formal settings', 119.99, 'images/wingtips.jpg', 2, 'Formal Shoes', 'Men', 'Adult', '7,8,9,10,11', 'Brown', 5),
('Tuxedo Shoes', 'Classic black shoes for tuxedos and formal events', 160.99, 'images/tuxedo_shoes.jpg', 2, 'Formal Shoes', 'Men', 'Adult', '7,8,9,10,11', 'Black', 5),

-- Running Shoes
('Running Sneakers', 'Running shoes for comfort and performance', 59.99, 'images/running_sneakers.jpg', 3, 'Running Shoes', 'Unisex', 'Adult', '7,8,9,10,11', 'Black', 4),
('Trail Running Shoes', 'Perfect for running on rough terrain', 79.99, 'images/trail_running.jpg', 3, 'Running Shoes', 'Unisex', 'Adult', '7,8,9,10,11', 'Green', 5),
('Waterproof Running Shoes', 'Shoes designed to keep feet dry while running in wet conditions', 89.99, 'images/waterproof_running.jpg', 3, 'Running Shoes', 'Unisex', 'Adult', '7,8,9,10,11', 'Blue', 4),
('Sporty Running Shoes', 'Versatile shoes designed for everyday runs', 59.99, 'images/sporty_running.jpg', 3, 'Running Shoes', 'Unisex', 'Adult', '7,8,9,10,11', 'Grey', 5),
('Lightweight Running Shoes', 'Ultra-light shoes for fast-paced runners', 69.99, 'images/lightweight_running.jpg', 3, 'Running Shoes', 'Unisex', 'Adult', '7,8,9,10,11', 'Yellow', 4),
('Stability Running Shoes', 'Running shoes designed for extra support and stability', 99.99, 'images/stability_running.jpg', 3, 'Running Shoes', 'Unisex', 'Adult', '7,8,9,10,11', 'Black', 5),
('Cushioned Running Shoes', 'Extra cushioning for long-distance runners', 109.99, 'images/cushioned_running.jpg', 3, 'Running Shoes', 'Unisex', 'Adult', '7,8,9,10,11', 'Blue', 5),
('Mesh Running Shoes', 'Breathable mesh design for comfort during runs', 79.99, 'images/mesh_running.jpg', 3, 'Running Shoes', 'Unisex', 'Adult', '7,8,9,10,11', 'Red', 4),
('Cross Training Shoes', 'Shoes that can handle running and training in the gym', 89.99, 'images/cross_training.jpg', 3, 'Running Shoes', 'Unisex', 'Adult', '7,8,9,10,11', 'Black', 4),
('Speed Running Shoes', 'Designed for sprinters with lightweight and speed-focused design', 120.99, 'images/speed_running.jpg', 3, 'Running Shoes', 'Unisex', 'Adult', '7,8,9,10,11', 'Green', 5),

-- Slippers
('Indoor Slippers', 'Soft slippers for home relaxation', 19.99, 'images/slippers.jpg', 4, 'Slippers', 'Women', 'Adult', '5,6,7,8', 'Pink', 3),
('Fleece Slippers', 'Warm and comfortable slippers for cold weather', 24.99, 'images/fleece_slippers.jpg', 4, 'Slippers', 'Unisex', 'Adult', '7,8,9,10', 'Grey', 4),
('Open Toe Slippers', 'Breathable open-toe slippers for comfort', 18.99, 'images/open_toe_slippers.jpg', 4, 'Slippers', 'Women', 'Adult', '6,7,8,9', 'Blue', 4),
('Memory Foam Slippers', 'Slippers with memory foam for ultimate comfort', 29.99, 'images/memory_foam_slippers.jpg', 4, 'Slippers', 'Unisex', 'Adult', '7,8,9,10', 'Black', 5),
('Ballet Slippers', 'Lightweight and soft ballet-style slippers', 14.99, 'images/ballet_slippers.jpg', 4, 'Slippers', 'Women', 'Adult', '5,6,7,8', 'Pink', 5),
('Cushioned Slippers', 'Slippers with extra cushioning for maximum comfort', 22.99, 'images/cushioned_slippers.jpg', 4, 'Slippers', 'Unisex', 'Adult', '7,8,9,10', 'White', 4),
('Wool Slippers', 'Cozy wool slippers to keep feet warm in winter', 35.99, 'images/wool_slippers.jpg', 4, 'Slippers', 'Women', 'Adult', '6,7,8,9', 'Grey', 5),
('Velvet Slippers', 'Luxurious velvet slippers for indoor wear', 45.99, 'images/velvet_slippers.jpg', 4, 'Slippers', 'Women', 'Adult', '6,7,8,9', 'Purple', 5),
('Closed Toe Slippers', 'Comfortable closed-toe slippers for all-day wear', 25.99, 'images/closed_toe_slippers.jpg', 4, 'Slippers', 'Unisex', 'Adult', '7,8,9,10', 'Black', 4),
('Slipper Sandals', 'Combination of slippers and sandals for casual home wear', 19.99, 'images/slipper_sandals.jpg', 4, 'Slippers', 'Unisex', 'Adult', '7,8,9,10', 'White', 4),

-- Heels
('Red Heels', 'Stylish red heels for parties and events', 79.99, 'images/red_heels.jpg', 5, 'Heels', 'Women', 'Adult', '5,6,7,8,9', 'Red', 5),
('Jimmy Choo Anouk Pumps', 'Classic stiletto heels with a pointed toe, perfect for formal occasions.', 799.99, 'images/jimmy_choo_anouk.jpg', 5, 'Heels', 'Women', 'Adult', '5,6,7,8,9', 'Black', 5),
('Christian Louboutin Pigalle Follies', 'Iconic red-bottomed pumps with sharp pointed toes, perfect for formal events.', 1199.99, 'images/louboutin_pigalle_follies.jpg', 5, 'Heels', 'Women', 'Adult', '5,6,7,8,9', 'Red', 5),
('Manolo Blahnik Hangisi Heels', 'Luxurious satin pumps with a crystal-embellished buckle, ideal for weddings.', 899.99, 'images/manolo_blahnik_hangisi.jpg', 5, 'Heels', 'Women', 'Adult', '5,6,7,8,9', 'Blue', 5),
('Kate Spade Sharon Pumps', 'Playful block heel pumps with bow detailing, combining comfort with chic aesthetics.', 149.99, 'images/kate_spade_sharon.jpg', 5, 'Heels', 'Women', 'Adult', '5,6,7,8,9', 'Pink', 5),
('Steve Madden Irenee Heels', 'Simple and stylish with a thin block heel, perfect for everyday wear.', 79.99, 'images/steve_madden_irenee.jpg', 5, 'Heels', 'Women', 'Adult', '5,6,7,8,9', 'Black', 4),
('Sam Edelman Hazel Heels', 'Trendy, open-toe heels with a chunky block heel, great for casual and dressy looks.', 109.99, 'images/sam_edelman_hazel.jpg', 5, 'Heels', 'Women', 'Adult', '5,6,7,8,9', 'Beige', 5),
('Stuart Weitzman Nudist Sandals', 'Strappy minimalist heels with a sleek ankle strap and stiletto heel, perfect for evening wear.', 550.00, 'images/stuart_weitzman_nudist.jpg', 5, 'Heels', 'Women', 'Adult', '5,6,7,8,9', 'Gold', 5),
('Badgley Mischka Gigi Heels', 'Sparkling embellished heels, perfect for formal gatherings or evening events.', 249.99, 'images/badgley_mischka_gigi.jpg', 5, 'Heels', 'Women', 'Adult', '5,6,7,8,9', 'Silver', 5),
('Nine West Lunna Heels', 'Classic pointed-toe heels with moderate heel height, versatile for work or dinners.', 69.99, 'images/nine_west_lunna.jpg', 5, 'Heels', 'Women', 'Adult', '5,6,7,8,9', 'Black', 4);



INSERT INTO Users (username, password, email, first_name, last_name, phone, address, role) VALUES
('john_doe', 'password123', 'john.doe@example.com', 'John', 'Doe', '555-1234', '123 Elm Street, Springfield', 'user'),
('admin_user', 'admin123', 'admin@example.com', 'Admin', 'User', '555-5678', '456 Admin Ave, Springfield', 'admin'),
('jane_smith', 'password456', 'jane.smith@example.com', 'Jane', 'Smith', '555-9876', '789 Oak Road, Springfield', 'user');

INSERT INTO Orders (user_id) VALUES
(1), -- Order for user with id = 1 (John Doe)
(2), -- Order for user with id = 2 (Admin User)
(3);  -- Order for user with id = 3 (Jane Smith)

INSERT INTO Order_Items (order_id, product_id, quantity, price) VALUES
(1, 1, 2, 120.99), -- John Doe's order of 2 Nike Air Max
(1, 3, 1, 35.00), -- John Doe's order of 1 Adidas Slides
(2, 2, 1, 150.50), -- Admin User's order of 1 Timberland PRO
(3, 4, 2, 99.99); -- Jane Smith's order of 2 Oxford Shoes

INSERT INTO Comments (product_id, user_id, content) VALUES
(1, 1, 'These shoes are incredibly comfortable for running!'),
(2, 2, 'Great quality boots, but a bit heavy for everyday use.'),
(3, 3, 'Perfect for summer, very breathable and stylish.'),
(4, 1, 'Nice formal shoes, but the fit was a bit tight.');

INSERT INTO admin_users (username, password) VALUES
('admin1', 'adminpassword1'),
('admin2', 'adminpassword2');

ALTER TABLE Orders ADD COLUMN status ENUM('pending', 'shipped', 'completed') DEFAULT 'pending';
