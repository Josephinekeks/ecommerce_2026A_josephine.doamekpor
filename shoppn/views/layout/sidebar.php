<?php
require_once __DIR__ . '/../../controllers/ProductController.php';

// Variable names start with "sidebar" or "s" on purpose.
// Included files share variables with the page that includes them,
// so generic names like $category could overwrite the page's own.
$sidebarController = new ProductController();
$sidebarCategories = $sidebarController->getAllCategories();
$sidebarBrands = $sidebarController->getAllBrands();
?>

<aside>
    <h3>Categories</h3>
    <ul>
        <?php foreach ($sidebarCategories as $sc): ?>
            <li>
                <!-- ?cat=N is read by home.php to filter the products -->
                <a href="<?php echo BASE_URL; ?>/index.php?cat=<?php echo (int)$sc['cat_id']; ?>">
                    <?php echo htmlspecialchars($sc['cat_name']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <h3>Brands</h3>
    <ul>
        <?php foreach ($sidebarBrands as $sb): ?>
            <li>
                <a href="<?php echo BASE_URL; ?>/index.php?brand=<?php echo (int)$sb['brand_id']; ?>">
                    <?php echo htmlspecialchars($sb['brand_name']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</aside>