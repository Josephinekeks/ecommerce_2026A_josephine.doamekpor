<?php

require_once __DIR__ . '/../../core/core.php';

require_admin();

require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../../controllers/ProductController.php';

$productController = new ProductController();

$editMode = false;
$editingBrand = null;

if (isset($_GET['edit_id'])) {
    $editId = intval($_GET['edit_id']); // same intval() safety pattern as Lab01's delete.php
    $editingBrand = $productController->getBrandById($editId);

    if ($editingBrand) {
        $editMode = true;
    }


}
?>

<main>
    <h1><?php echo $editMode ? 'Edit Brand' : 'Add Brand'; ?></h1>
    <?php
    // Same display-then-clear pattern you've used since Task 3,
    // now also handling the new 'success' key alongside 'error'.
    if (isset($_SESSION['success'])) {
        echo '<p style="color:green;">' . htmlspecialchars($_SESSION['success']) . '</p>';
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo '<p style="color:red;">' . htmlspecialchars($_SESSION['error']) . '</p>';
        unset($_SESSION['error']);
    }
    ?>

    <!-- The form's action and hidden fields change based on mode. -->
    <form method="POST" action="<?php echo $editMode ? '../../actions/update_brand_action.php' : '../../actions/add_brand_action.php'; ?>">

        <?php if ($editMode): ?>
            <!-- Hidden field carries the brand's id along, same
                 reasoning as edit.php's hidden id field back in Lab01 —
                 update_brand_action.php needs to know WHICH row to update. -->
            <input type="hidden" name="brand_id" value="<?php echo $editingBrand['brand_id']; ?>">
        <?php endif; ?>

        <label for="brand_name">Brand Name</label><br>
        <input
            type="text"
            id="brand_name"
            name="brand_name"
            value="<?php echo $editMode ? htmlspecialchars($editingBrand['brand_name']) : ''; ?>"
            required
        ><br>

        <button type="submit"><?php echo $editMode ? 'Update Brand' : 'Add Brand'; ?></button>

        <?php if ($editMode): ?>
            <a href="brand.php">Cancel</a>
        <?php endif; ?>
    </form>

    <h2>All Brands</h2>

    <table border="1">
        <thead>
            <tr>
                <th>Brand Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $brands = $productController->getAllBrands();
            foreach ($brands as $brand):
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($brand['brand_name']); ?></td>
                    <td>
                        <a href="brand.php?edit_id=<?php echo $brand['brand_id']; ?>">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>




