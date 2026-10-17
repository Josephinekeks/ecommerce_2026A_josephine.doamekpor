<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

// Read the search text, remove stray spaces, and cap the length.
$query = isset($_GET['user_query']) ? trim($_GET['user_query']) : '';
$query = substr($query, 0, 100);

$productController = new ProductController();

// An empty search shouldn't match every product, so skip the query.
$products = ($query !== '') ? $productController->searchProducts($query) : [];

require_once __DIR__ . '/layout/header.php';
?>

<main>
    <main>
    <?php require_once __DIR__ . '/layout/messages.php'; ?>
    <div class="page-layout">
        <?php require_once __DIR__ . '/layout/sidebar.php'; ?>

        <section>
            <h1>Search Results</h1>

            <?php if ($query === ''): ?>
                <p>Please enter a search term.</p>
            <?php else: ?>
                <p>Results for "<?php echo htmlspecialchars($query); ?>"</p>

                <?php if (empty($products)): ?>
                    <p>No products found.</p>
                <?php else: ?>
                    <div class="product-grid">
                        <?php foreach ($products as $product): ?>
                            <?php require __DIR__ . '/layout/product_card.php'; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>