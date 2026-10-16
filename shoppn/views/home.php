<?php
// index.php already loaded core.php before this file runs.
require_once __DIR__ . '/layout/header.php';
require_once __DIR__ . '/../controllers/ProductController.php';

$productController = new ProductController();

// Decide WHICH products to show, based on the URL.
// intval() turns anything weird into 0, which simply matches nothing.
$heading = 'Featured Products';

if (isset($_GET['cat'])) {
    $catId = intval($_GET['cat']);
    $category = $productController->getCategoryById($catId);
    $products = $productController->getProductsByCategory($catId);
    $heading = $category ? $category['cat_name'] : 'Products';

} elseif (isset($_GET['brand'])) {
    $brandId = intval($_GET['brand']);
    $brand = $productController->getBrandById($brandId);
    $products = $productController->getProductsByBrand($brandId);
    $heading = $brand ? $brand['brand_name'] : 'Products';

} else {
    $products = $productController->getFeaturedProducts();
}
?>

<main>
    <div class="page-layout">
        <?php require_once __DIR__ . '/layout/sidebar.php'; ?>

        <section>
            <h1><?php echo htmlspecialchars($heading); ?></h1>

            <?php if (empty($products)): ?>
                <p>No products found.</p>
            <?php else: ?>
                <div class="product-grid">
                    <?php foreach ($products as $product): ?>
                        
                        <?php require __DIR__ . '/layout/product_card.php'; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>