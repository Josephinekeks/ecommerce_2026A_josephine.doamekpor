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

        <form method="GET" action="<?php echo BASE_URL; ?>/index.php">
            <input
                type="text"
                name="search"
                placeholder="Search products..."
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
            >
            <button type="submit">Search</button>
        </form>

        <?php if (is_logged_in()): ?>
    <span>Welcome, <?php echo htmlspecialchars($_SESSION['customer_name']); ?></span>
    
    <a href="<?php echo BASE_URL; ?>/views/account/my_account.php">My Account</a>

    <?php if (is_admin()): ?>
         <a href="<?php echo BASE_URL; ?>/views/admin/brand.php">Brands</a>
         <a href="<?php echo BASE_URL; ?>/views/admin/category.php">Categories</a>
    <?php endif; ?>

     <a href="<?php echo BASE_URL; ?>/logout.php">Logout</a>
<?php else: ?>
    <a href="<?php echo BASE_URL; ?>/views/register.php">Register</a>
    <a href="<?php echo BASE_URL; ?>/views/login.php">Login</a>
<?php endif; ?>
    </nav>
</header>