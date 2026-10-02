<?php
require_once __DIR__ . '/../../controllers/ProductController.php';

$productController = new ProductController();
$categories = $productController->getCategories();
$brands = $productController->getAllBrands();
?>

<aside>
    <h3>Categories</h3>
    <ul>
        <?php foreach ($categories as $category): ?>
            <li><?php echo htmlspecialchars($category['cat_name']); ?></li>
        <?php endforeach; ?>
    </ul>

    <h3>Brands</h3>
    <ul>
        <?php foreach ($brands as $brand): ?>
            <li><?php echo htmlspecialchars($brand['brand_name']); ?></li>
        <?php endforeach; ?>
    </ul>
</aside>