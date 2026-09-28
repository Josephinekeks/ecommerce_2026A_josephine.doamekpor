<!-- has the header, nav bar, serch bar 
-->
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoppn — Ladies' Fashion</title>
    <link rel="stylesheet" href="/shoppn/assets/css/style.css">
</head>
<body>

<header>
    <nav>
        <a href="/shoppn/index.php">Shoppn</a>

        <form method="GET" action="/shoppn/index.php">
            <input
                type="text"
                name="search"
                placeholder="Search products..."
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
            >
            <button type="submit">Search</button>
        </form>

        <?php if (is_logged_in()): ?>
            <!-- Logged-in state: greet them by name, and give access
                 to their account and a way to log out. -->
            <span>
                Welcome, <?php echo htmlspecialchars($_SESSION['customer_name']); ?>
            </span>
            |
            <a href="/shoppn/views/account/my_account.php">My Account</a>
            |
            <a href="/shoppn/logout.php">Logout</a>
        <?php else: ?>
            <!-- Logged-out state: give them a path to either join
                 or sign in. -->
            <a href="/shoppn/views/register.php">Register</a>
            |
            <a href="/shoppn/views/login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>