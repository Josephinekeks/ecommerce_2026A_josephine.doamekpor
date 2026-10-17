<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';

// No require_login(): guests can have a cart too.
$cartController = new CartController();
$items = $cartController->getCartItems(get_ip());
$total = $cartController->getCartTotal(get_ip());

require_once __DIR__ . '/layout/header.php';
?>

<main>
    <?php require_once __DIR__ . '/layout/messages.php'; ?>
    <h1>Your Cart</h1>

    <?php if (empty($items)): ?>
        <p>Your cart is empty.</p>
        <p><a class="button-link" href="<?php echo BASE_URL; ?>/index.php">Continue Shopping</a></p>
    <?php else: ?>

        <!-- One form wraps the table. Each button below sends it to a different
             action with formaction, so we don't need two forms around the same rows. -->
        <form class="cart-form" method="POST">
            <table>
                <thead>
                    <tr>
                        <th>Remove</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <!-- remove[] sends every ticked box as one list of product ids -->
                            <td><input type="checkbox" name="remove[]" value="<?php echo (int)$item['p_id']; ?>"></td>
                            <td>
                                <div class="cart-product">
                                    <?php if (!empty($item['product_image'])): ?>
                                        <img class="product-thumb"
                                             src="<?php echo BASE_URL; ?>/images/products/<?php echo htmlspecialchars($item['product_image']); ?>"
                                             alt="">
                                    <?php endif; ?>
                                    <span><?php echo htmlspecialchars($item['product_title']); ?></span>
                                </div>
                            </td>
                            <!-- qty[5] means "the quantity for product 5" -->
                            <td><input class="qty-input" type="number" min="1"
                                       name="qty[<?php echo (int)$item['p_id']; ?>]"
                                       value="<?php echo (int)$item['qty']; ?>"></td>
                            <td>GH&#8373; <?php echo number_format($item['product_price'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">Subtotal</td>
                        <td>GH&#8373; <?php echo number_format($total, 2); ?></td>
                    </tr>
                </tfoot>
            </table>

            <div class="cart-actions">
                <!-- Update goes first, so pressing Enter in a quantity box updates
                     instead of removing. -->
                <button type="submit" formaction="<?php echo BASE_URL; ?>/actions/update_qty_action.php">Update Quantity</button>
                <button type="submit" formaction="<?php echo BASE_URL; ?>/actions/remove_from_cart_action.php">Remove from Cart</button>
                <a class="button-link" href="<?php echo BASE_URL; ?>/index.php">Continue Shopping</a>
                <a class="button-link" href="<?php echo BASE_URL; ?>/views/checkout.php">Checkout</a>
            </div>
        </form>

    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>