<?php
require_once __DIR__ . '/../../core/core.php';
require_admin();
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../../controllers/ProductController.php';

$productController = new ProductController();

$editMode = false;
$editingCategory = null;

if (isset($_GET['edit_id'])) {
    $editId = intval($_GET['edit_id']);
    $editingCategory = $productController->getCategoryById($editId);

    if ($editingCategory) {
        $editMode = true;
    }
}
?>

<main>
    <h1><?php echo $editMode ? 'Edit Category' : 'Add Category'; ?></h1>

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

    <form method="POST" action="<?php echo $editMode ? '../../actions/update_category_action.php' : '../../actions/add_category_action.php'; ?>">

        <?php if ($editMode): ?>
            <input type="hidden" name="cat_id" value="<?php echo $editingCategory['cat_id']; ?>">
        <?php endif; ?>

        <label for="cat_name">Category Name</label><br>
        <input
            type="text"
            id="cat_name"
            name="cat_name"
            value="<?php echo $editMode ? htmlspecialchars($editingCategory['cat_name']) : ''; ?>"
            required
        ><br>

        <button type="submit"><?php echo $editMode ? 'Update Category' : 'Add Category'; ?></button>

        <?php if ($editMode): ?>
            <a href="category.php">Cancel</a>
        <?php endif; ?>
    </form>

    <h2>All Categories</h2>

    <table>
        <thead>
            <tr>
                <th>Category Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $categories = $productController->getAllCategories();
            foreach ($categories as $category):
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($category['cat_name']); ?></td>
                    <td>
                        <a href="category.php?edit_id=<?php echo $category['cat_id']; ?>">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>