<div class="product-grid">
  <?php
  // Include the database functions
  require_once 'includes/functions/functions.php';

  // Fetch products from the database
  $products = getProducts();

  // Display each product
  foreach ($products as $product) {
  ?>
    <div class="product-item">
      <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
      <h3><?php echo $product['name']; ?></h3>
      <p>$<?php echo number_format($product['price'], 2); ?></p>
      <a href="item_details.php?id=<?php echo $product['id']; ?>">View Details</a>
    </div>
  <?php
  }
  ?>
</div>
