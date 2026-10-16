<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

// Validate BEFORE any HTML, because redirect() uses header(),
// which fails once output has started.
$proId = isset($_GET['pro_id']) ? intval($_GET['pro_id']) : 0;
if ($proId <= 0) {
    redirect(BASE_URL . '/index.php');
}

$productController = new ProductController();
$product = $productController->getProductById($proId);

// getProductById returns false if no product has that id.
if (!$product) {
    redirect(BASE_URL . '/index.php');
}

require_once __DIR__ . '/layout/header.php';
?>

<main>
    <div class="page-layout">
        <?php require_once __DIR__ . '/layout/sidebar.php'; ?>

        <section class="product-detail">
            <?php if (!empty($product['product_image'])): ?>
                <img src="<?php echo BASE_URL; ?>/images/products/<?php echo htmlspecialchars($product['product_image']); ?>"
                     alt="<?php echo htmlspecialchars($product['product_title']); ?>">
            <?php endif; ?>

            <h1><?php echo htmlspecialchars($product['product_title']); ?></h1>
            <p><strong>Category:</strong> <?php echo htmlspecialchars($product['cat_name']); ?></p>
            <p><strong>Brand:</strong> <?php echo htmlspecialchars($product['brand_name']); ?></p>
            <p class="price">GH&#8373; <?php echo number_format($product['product_price'], 2); ?></p>
            <p><?php echo htmlspecialchars($product['product_desc']); ?></p>
            <p><strong>Keywords:</strong> <?php echo htmlspecialchars($product['product_keywords']); ?></p>

            <p>
                <a class="button-link"
                   href="<?php echo BASE_URL; ?>/actions/add_to_cart_action.php?add_cart=<?php echo (int)$product['product_id']; ?>">Add to Cart</a>
            </p>
        </section>
    </div>
</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>