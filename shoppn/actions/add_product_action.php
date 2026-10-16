<?php
require_once __DIR__ . '/../core/core.php';
require_admin(); // permission check first, before anything else runs
require_once __DIR__ . '/../core/upload.php';
require_once __DIR__ . '/../controllers/ProductController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitise. 
    $cat      = intval($_POST['product_cat']);
    $brand    = intval($_POST['product_brand']);
    $title    = strip_tags(trim($_POST['product_title']));
    $desc     = strip_tags(trim($_POST['product_desc']));
    $keywords = strip_tags(trim($_POST['product_keywords']));

    // FILTER_VALIDATE_FLOAT returns false if the text isn't a real number.
    $price = filter_var($_POST['product_price'], FILTER_VALIDATE_FLOAT);

    // Validate against the real column sizes in your schema.
    $errors = [];
    if ($cat <= 0)                  $errors[] = 'Please choose a category.';
    if ($brand <= 0)                $errors[] = 'Please choose a brand.';
    if (empty($title))              $errors[] = 'Product title is required.';
    if (strlen($title) > 200)       $errors[] = 'Title is too long.';
    if ($price === false || $price <= 0) $errors[] = 'Enter a valid price.';
    if (strlen($desc) > 500)        $errors[] = 'Description is too long (500 max).';
    if (strlen($keywords) > 100)    $errors[] = 'Keywords are too long (100 max).';

    if (!empty($errors)) {
        $_SESSION['error'] = $errors[0];
        redirect('../views/admin/product.php');
    }

    // Image is required when ADDING.
    if (!isset($_FILES['product_image']) || $_FILES['product_image']['error'] === UPLOAD_ERR_NO_FILE) {
        $_SESSION['error'] = 'Please choose a product image.';
        redirect('../views/admin/product.php');
    }

    $upload = upload_product_image($_FILES['product_image']);
    if (!$upload['success']) {
        $_SESSION['error'] = $upload['error'];
        redirect('../views/admin/product.php');
    }

    // PHP throws an exception when a query fails 
    try {
        $productController = new ProductController();
        $success = $productController->addProduct($cat, $brand, $title, $price, $desc, $upload['filename'], $keywords);
    } catch (Exception $e) {
        error_log($e->getMessage());
        $success = false;
    }

    if ($success) {
        $_SESSION['success'] = 'Product added.';
    } else {
        $_SESSION['error'] = 'Failed to add product. Please try again.';
    }

    redirect('../views/admin/product.php');
}
?>