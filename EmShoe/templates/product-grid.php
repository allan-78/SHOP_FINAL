<div class="product-grid">
  <?php
  // Include the database functions
  require_once 'includes/functions/functions.php';

  // Fetch products from the database
  $products = getProducts();

  // Check if there are products available
  if (count($products) > 0) {
    // Display each product
    foreach ($products as $product) {
  ?>
    <div class="product-item">
      <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
      <h3><?php echo htmlspecialchars($product['name']); ?></h3>
      <p>$<?php echo number_format($product['price'], 2); ?></p>
      <!-- Link to item_details.php with the correct product ID -->
      <a href="item_details.php?id=<?php echo $product['product_id']; ?>">View Details</a>
    </div>
  <?php
    }
  } else {
    echo '<p>No products available at the moment.</p>';
  }
  ?>
</div>
