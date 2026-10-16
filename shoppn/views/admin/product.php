<?php
require_once __DIR__ . '/../../core/core.php';
require_admin();
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../../controllers/ProductController.php';

$productController = new ProductController();

//data fro 2 dropdowns and the table
$categories = $productController->getAllCategories();
$brands = $productController->getAllBrands();
$products = $productController->getAllProducts();


//editing mode
$editMode = false;
$editing = null;
if (isset($_GET['edit_id'])) {
    $editing = $productController->getProductById(intval($_GET['edit_id']));
    if ($editing) {
        $editMode = true; 
    }
}



?>
<main>
    <h1><?php echo $editMode ? 'Edit Product' : 'Add Product'; ?></h1>

    <?php
    if (isset($_SESSION['success'])) {
        echo '<p style="color:green;">' . htmlspecialchars($_SESSION['success']) . '</p>';
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo '<p style="color:red;">' . htmlspecialchars($_SESSION['error']) . '</p>';
        unset($_SESSION['error']);
    }
    ?>

    <!-- enctype="multipart/form-data" is REQUIRED for file uploads.
         Without it the browser sends only the file's name, not the file. -->
    <form id="product-form" method="POST" enctype="multipart/form-data"
          action="<?php echo $editMode ? '../../actions/update_product_action.php' : '../../actions/add_product_action.php'; ?>">

        <?php if ($editMode): ?>
            <input type="hidden" name="product_id" value="<?php echo (int)$editing['product_id']; ?>">
            <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($editing['product_image']); ?>">
        <?php endif; ?>

        <label for="product_title">Product Title</label>
        <input type="text" id="product_title" name="product_title" maxlength="200"
               value="<?php echo $editMode ? htmlspecialchars($editing['product_title']) : ''; ?>" required>

        <label for="product_cat">Category</label>
        <select id="product_cat" name="product_cat" required>
            <option value="">-- Select Category --</option>
            <?php foreach ($categories as $c): ?>
                <option value="<?php echo (int)$c['cat_id']; ?>"
                    <?php echo ($editMode && (int)$editing['product_cat'] === (int)$c['cat_id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($c['cat_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="product_brand">Brand</label>
        <select id="product_brand" name="product_brand" required>
            <option value="">-- Select Brand --</option>
            <?php foreach ($brands as $b): ?>
                <option value="<?php echo (int)$b['brand_id']; ?>"
                    <?php echo ($editMode && (int)$editing['product_brand'] === (int)$b['brand_id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($b['brand_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="product_price">Price</label>
        <input type="number" id="product_price" name="product_price" step="0.01" min="0.01"
               value="<?php echo $editMode ? htmlspecialchars($editing['product_price']) : ''; ?>" required>

        <label for="product_desc">Description</label>
        <textarea id="product_desc" name="product_desc" maxlength="500"><?php echo $editMode ? htmlspecialchars($editing['product_desc']) : ''; ?></textarea>

        <label for="product_keywords">Keywords</label>
        <input type="text" id="product_keywords" name="product_keywords" maxlength="100"
               value="<?php echo $editMode ? htmlspecialchars($editing['product_keywords']) : ''; ?>">

        <?php if ($editMode && !empty($editing['product_image'])): ?>
            <p>Current image:</p>
            <img class="current-image"
                 src="<?php echo BASE_URL; ?>/images/products/<?php echo htmlspecialchars($editing['product_image']); ?>"
                 alt="Current product image">
        <?php endif; ?>

        <label for="product_image"><?php echo $editMode ? 'Replace Image (optional)' : 'Product Image'; ?></label>
        <input type="file" id="product_image" name="product_image"
               accept="image/jpeg,image/png,image/gif,image/webp"
               <?php echo $editMode ? '' : 'required'; ?>>
        <span class="error-message" id="image-error"></span>

        <button type="submit"><?php echo $editMode ? 'Update Product' : 'Add Product'; ?></button>
        <?php if ($editMode): ?>
            <a href="product.php">Cancel</a>
        <?php endif; ?>
    </form>

    <h2>All Products</h2>
    <table>
        <thead>
            <tr><th>Image</th><th>Title</th><th>Category</th><th>Brand</th><th>Price</th><th>Action</th></tr>
        </thead>
        <tbody>
            <?php foreach ($products as $p): ?>
                <tr>
                    <td>
                        <?php if (!empty($p['product_image'])): ?>
                            <img class="product-thumb"
                                 src="<?php echo BASE_URL; ?>/images/products/<?php echo htmlspecialchars($p['product_image']); ?>"
                                 alt="">
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($p['product_title']); ?></td>
                    <td><?php echo htmlspecialchars($p['cat_name']); ?></td>
                    <td><?php echo htmlspecialchars($p['brand_name']); ?></td>
                    <td><?php echo number_format($p['product_price'], 2); ?></td>
                    <td><a href="product.php?edit_id=<?php echo (int)$p['product_id']; ?>">Edit</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<script src="<?php echo BASE_URL; ?>/js/product_validate.js"></script>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>