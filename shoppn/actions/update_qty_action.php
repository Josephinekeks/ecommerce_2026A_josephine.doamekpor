<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';

$cartUrl = BASE_URL . '/views/cart.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect($cartUrl);
}

// Two parallel lists: update[] holds the product ids, qty[] holds the
// quantities. The item at position 0 in one belongs to position 0 in the other.
$ids  = (isset($_POST['update']) && is_array($_POST['update'])) ? $_POST['update'] : [];
$qtys = (isset($_POST['qty']) && is_array($_POST['qty'])) ? $_POST['qty'] : [];

// If the lists differ in length, the matching would be wrong, so stop.
if (empty($ids) || count($ids) !== count($qtys)) {
    $_SESSION['error'] = 'Nothing to update.';
    redirect($cartUrl);
}

// Step 1: validate EVERY quantity before changing anything.
$clean = [];
foreach ($ids as $i => $rawId) {
    $productId = intval($rawId);

    // FILTER_VALIDATE_INT with min/max returns false unless the value is a
    // whole number from 1 to 99. The cap of 99 also stops absurdly large
    // numbers from reaching the database.
    $qty = filter_var($qtys[$i] ?? '', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => 99]
    ]);

    if ($productId <= 0 || $qty === false) {
        $_SESSION['error'] = 'Quantities must be whole numbers from 1 to 99.';
        redirect($cartUrl);
    }

    $clean[$productId] = $qty;
}

// Step 2: everything is valid, so save the changes.
$ip = get_ip();
$ok = true;

try {
    $cartController = new CartController();

    foreach ($clean as $productId => $qty) {
        if (!$cartController->updateQty($productId, $qty, $ip)) {
            $ok = false;
        }
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    $ok = false;
}

if ($ok) {
    $_SESSION['success'] = 'Cart updated.';
} else {
    $_SESSION['error'] = 'Could not update your cart.';
}

redirect($cartUrl);
?>