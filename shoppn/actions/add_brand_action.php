<?php
require_once __DIR__ .'/../core/core.php';


require_admin();

require_once __DIR__ . '/../controllers/ProductController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize inputs
    $brandName = strip_tags(trim($_POST['brand_name']));

    // Basic validation 
    $errors = [];

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
    $success = $productController->addBrand($brandName);

    if ($success) {
        $_SESSION['success'] = 'Brand added.';
    } else {
        $_SESSION['error'] = 'Failed to add brand. Please try again.';
    }

    redirect('../views/admin/brand.php');
}

















?>