<?php
require_once __DIR__ . '/../core/core.php';
require_admin();

require_once __DIR__ . '/../controllers/ProductController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $brandId = intval($_POST['brand_id']);
    $brandName = strip_tags(trim($_POST['brand_name']));

    $errors = [];

    
    if ($brandId <= 0) {
        $errors[] = 'Invalid brand.';
    }

    if (empty($brandName)) {
        $errors[] = 'Brand name is required.';
    }

    if (strlen($brandName) > 100) {
        $errors[] = 'Brand name is too long.';
    }

    if (!empty($errors)) {
        $_SESSION['error'] = $errors[0];
        redirect('../views/admin/brand.php');
    }

    $productController = new ProductController();
    $success = $productController->updateBrand($brandId, $brandName);

    if ($success) {
        $_SESSION['success'] = 'Brand updated.';
    } else {
        $_SESSION['error'] = 'Failed to update brand.';
    }

    redirect('../views/admin/brand.php');
}
?>