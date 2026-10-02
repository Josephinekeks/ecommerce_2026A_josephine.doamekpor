<?php
require_once __DIR__ . '/../core/core.php';
require_admin();
require_once __DIR__ . '/../controllers/ProductController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $categoryName = strip_tags(trim($_POST['cat_name']));

    $errors = [];

    if (empty($categoryName)) {
        $errors[] = 'Category name is required.';
    }

    if (strlen($categoryName) > 100) {
        $errors[] = 'Category name is too long.';
    }

    if (!empty($errors)) {
        $_SESSION['error'] = $errors[0];
        redirect('../views/admin/category.php');
    }

    $productController = new ProductController();
    $success = $productController->addCategory($categoryName);

    if ($success) {
        $_SESSION['success'] = 'Category added.';
    } else {
        $_SESSION['error'] = 'Failed to add category. Please try again.';
    }

    redirect('../views/admin/category.php');
}
?>