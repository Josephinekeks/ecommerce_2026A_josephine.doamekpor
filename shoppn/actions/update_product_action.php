<?php
require_once __DIR__ . '/../core/core.php';
require_admin();
require_once __DIR__ . '/../core/upload.php';
require_once __DIR__ . '/../controllers/ProductController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id       = intval($_POST['product_id']);
    $cat      = intval($_POST['product_cat']);
    $brand    = intval($_POST['product_brand']);
    $title    = strip_tags(trim($_POST['product_title']));
    $desc     = strip_tags(trim($_POST['product_desc']));
    $keywords = strip_tags(trim($_POST['product_keywords']));
    $price    = filter_var($_POST['product_price'], FILTER_VALIDATE_FLOAT);

    //  basename() strips any folder
    // tricks like "../../" because a hidden field can be edited by the user.
    $image = basename(trim($_POST['existing_image']));

    $errors = [];
    if ($id <= 0)                   $errors[] = 'Invalid product.';
    if ($cat <= 0)                  $errors[] = 'Please choose a category.';
    if ($brand <= 0)                $errors[] = 'Please choose a brand.';
    if (empty($title))              $errors[] = 'Product title is required.';
    if (strlen($title) > 200)       $errors[] = 'Title is too long.';
    if ($price === false || $price <= 0) $errors[] = 'Enter a valid price.';
    if (strlen($desc) > 500)        $errors[] = 'Description is too long (500 max).';
    if (strlen($keywords) > 100)    $errors[] = 'Keywords are too long (100 max).';

    if (!empty($errors)) {
        $_SESSION['error'] = $errors[0];
        redirect('../views/admin/product.php?edit_id=' . $id);
    }

    // Only touch the image if a NEW file was chosen. Otherwise $image
    // keeps the old filename from the hidden field.
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $upload = upload_product_image($_FILES['product_image']);
        if (!$upload['success']) {
            $_SESSION['error'] = $upload['error'];
            redirect('../views/admin/product.php?edit_id=' . $id);
        }
        $image = $upload['filename'];
    }

    try {
        $productController = new ProductController();
        $success = $productController->updateProduct($id, $cat, $brand, $title, $price, $desc, $image, $keywords);
    } catch (Exception $e) {
        error_log($e->getMessage());
        $success = false;
    }

    if ($success) {
        $_SESSION['success'] = 'Product updated.';
    } else {
        $_SESSION['error'] = 'Failed to update product.';
    }

    redirect('../views/admin/product.php');
}
?>