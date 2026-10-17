<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';

// Work out where to send the visitor back to.
// HTTP_REFERER is the page they clicked from. The browser supplies it, so we
// only trust it when it points at OUR site, otherwise anyone could bounce
// visitors to another website. The '//' prefix lets parse_url read the
// host from HTTP_HOST and drop the port number, which the live server has
// (:442) and localhost doesn't.
$siteHost = parse_url('//' . $_SERVER['HTTP_HOST'], PHP_URL_HOST);
$referer  = $_SERVER['HTTP_REFERER'] ?? '';
$refHost  = parse_url($referer, PHP_URL_HOST);
$back = ($referer !== '' && $refHost === $siteHost) ? $referer : BASE_URL . '/index.php';

// Read ?add_cart=N from the link. intval() turns anything invalid into 0.
$productId = isset($_GET['add_cart']) ? intval($_GET['add_cart']) : 0;
if ($productId <= 0) {
    $_SESSION['error'] = 'Invalid product.';
    redirect($back);
}

$ip = get_ip();
// Logged-in customers get their id saved on the cart row. Guests get null.
$customerId = is_logged_in() ? $_SESSION['customer_id'] : null;

// try/catch turns a database error (for example a product id that doesn't
// exist) into a friendly message instead of a blank page.
try {
    $cartController = new CartController();

    if ($cartController->isInCart($productId, $ip)) {
        $_SESSION['error'] = 'This item is already in your cart. Go to cart to update quantity.';
    } elseif ($cartController->addToCart($productId, 1, $ip, $customerId)) {
        $_SESSION['success'] = 'Item added to cart.';
    } else {
        $_SESSION['error'] = 'Could not add the item to your cart.';
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    $_SESSION['error'] = 'Could not add the item to your cart.';
}

redirect($back);
?>