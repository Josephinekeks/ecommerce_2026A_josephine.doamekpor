<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/layout/header.php';
?>

<main>
    <section>
        <h1>Login</h1>

        <?php
        
        if (isset($_SESSION['error'])) {
            echo '<p style="color:red;">' . htmlspecialchars($_SESSION['error']) . '</p>';
            unset($_SESSION['error']);
        }
        ?>

        <form method="POST" action="../actions/login_action.php">

            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" required><br>

            <label for="pass">Password</label><br>
            <input type="password" id="pass" name="pass" required><br>

            <button type="submit">Login</button>
        </form>

        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    </section>
</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>