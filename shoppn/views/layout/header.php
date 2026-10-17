<!-- has the header, nav bar, serch bar 
-->
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoppn — Ladies' Fashion</title>
   <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css">
</head>
<body>

<header>
    <nav>
        <a href="<?php echo BASE_URL; ?>/index.php">Shoppn</a>

       <form method="GET" action="<?php echo BASE_URL; ?>/views/search_results.php">
    <input
        type="text"
        name="user_query"
        placeholder="Search products..."
        value="<?php echo isset($_GET['user_query']) ? htmlspecialchars($_GET['user_query']) : ''; ?>"
    >
    <button type="submit">Search</button>
</form>

        <?php if (is_logged_in()): ?>
    <span>Welcome, <?php echo htmlspecialchars($_SESSION['customer_name']); ?></span>
    
    <a href="<?php echo BASE_URL; ?>/views/account/my_account.php">My Account</a>

    <?php if (is_admin()): ?>
         <a href="<?php echo BASE_URL; ?>/views/admin/brand.php">Brands</a>
         <a href="<?php echo BASE_URL; ?>/views/admin/category.php">Categories</a>
         <a href="<?php echo BASE_URL; ?>/views/admin/product.php">Products</a>
    <?php endif; ?>

     <a href="<?php echo BASE_URL; ?>/logout.php">Logout</a>
<?php else: ?>
    <a href="<?php echo BASE_URL; ?>/views/register.php">Register</a>
    <a href="<?php echo BASE_URL; ?>/views/login.php">Login</a>
<?php endif; ?>
    </nav>
</header>
<?php
// Runs on every page, so the cart summary is always up to date.
// Variable names start with "header" so they can't clash with the page's own.
require_once __DIR__ . '/../../controllers/CartController.php';
$headerCart      = new CartController();
$headerCartCount = $headerCart->getCartCount(get_ip());
$headerCartTotal = $headerCart->getCartTotal(get_ip());
?>
<div class="cart-bar">
    <span>Shopping Cart</span>
    <span>Total Items: <?php echo $headerCartCount; ?></span>
    <span>Total Price: GH&#8373; <?php echo number_format($headerCartTotal, 2); ?></span>
    <a href="<?php echo BASE_URL; ?>/views/cart.php">Go to Cart</a>
</div>