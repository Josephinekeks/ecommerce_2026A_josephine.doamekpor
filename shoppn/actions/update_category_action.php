<?php
require_once __DIR__ . '/../core/core.php';
require_admin();
require_once __DIR__ . '/../controllers/ProductController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $categoryId = intval($_POST['cat_id']);
    $categoryName = strip_tags(trim($_POST['cat_name']));

    $errors = [];

    if ($categoryId <= 0) {
        $errors[] = 'Invalid category.';
    }

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
    $success = $productController->updateCategory($categoryId, $categoryName);

    if ($success) {
        $_SESSION['success'] = 'Category updated.';
    } else {
        $_SESSION['error'] = 'Failed to update category.';
    }

    redirect('../views/admin/category.php');
}
?>