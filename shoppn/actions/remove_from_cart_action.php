<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';

$cartUrl = BASE_URL . '/views/cart.php';

// POST only. A visitor who types this address in the browser makes a GET
// request, so we send them back to the cart instead of showing a blank page.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect($cartUrl);
}

// remove[] arrives as a list of the ticked product ids. If no box was ticked,
// the browser sends no "remove" field at all, so check it exists first.
$remove = (isset($_POST['remove']) && is_array($_POST['remove'])) ? $_POST['remove'] : [];

if (empty($remove)) {
    $_SESSION['error'] = 'Tick at least one item to remove.';
    redirect($cartUrl);
}

$ip = get_ip();
$removed = 0;

// try/catch turns a database error into a friendly message, not a blank page.
try {
    $cartController = new CartController();

    foreach ($remove as $rawId) {
        $productId = intval($rawId);

        // Skip anything that isn't a positive whole number.
        if ($productId <= 0) {
            continue;
        }

        if ($cartController->removeFromCart($productId, $ip)) {
            $removed++;
        }
    }
} catch (Exception $e) {
    error_log($e->getMessage());
}

if ($removed === 1) {
    $_SESSION['success'] = 'Item removed from your cart.';
} elseif ($removed > 1) {
    $_SESSION['success'] = 'Items removed from your cart.';
} else {
    $_SESSION['error'] = 'Could not remove the selected item.';
}

redirect($cartUrl);
?>