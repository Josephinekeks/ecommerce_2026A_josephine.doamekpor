<?php
// One product card. It expects a variable called $product (one row
// from the products table
?>
<div class="product-card">
    <?php if (!empty($product['product_image'])): ?>
        <img src="<?php echo BASE_URL; ?>/images/products/<?php echo htmlspecialchars($product['product_image']); ?>"
             alt="<?php echo htmlspecialchars($product['product_title']); ?>">
    <?php endif; ?>

    <h3><?php echo htmlspecialchars($product['product_title']); ?></h3>

    <!-- &#8373; is the cedi sign. The HTML code avoids file-encoding problems.
         number_format shows two decimals, e.g. 45.00 -->
    <p class="price">GH&#8373; <?php echo number_format($product['product_price'], 2); ?></p>

    <div class="card-links">
        <a href="<?php echo BASE_URL; ?>/views/single_product.php?pro_id=<?php echo (int)$product['product_id']; ?>">Details</a>
        <a href="<?php echo BASE_URL; ?>/actions/add_to_cart_action.php?add_cart=<?php echo (int)$product['product_id']; ?>">Add to Cart</a>
    </div>
</div>