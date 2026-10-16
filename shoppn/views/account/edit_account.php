<?php
require_once __DIR__ . '/../../core/core.php';
require_login();
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../../controllers/CustomerController.php';

$customerController = new CustomerController();
$account = $customerController->getAccount($_SESSION['customer_id']);
?>

<main>
    <h1>Edit Account</h1>

    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color:red;">' . htmlspecialchars($_SESSION['error']) . '</p>';
        unset($_SESSION['error']);
    }
    ?>

    <form method="POST" action="../../actions/update_account_action.php">

        <label for="name">Full Name</label><br>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($account['customer_name']); ?>" required><br>

        <!-- Email shown but not editable here — changing it safely
             needs its own duplicate-check flow, same reasoning as
             the Model not touching it directly. -->
        <label>Email</label><br>
        <input type="email" value="<?php echo htmlspecialchars($account['customer_email']); ?>" disabled><br>

        <label for="country">Country</label><br>
        <select id="country" name="country" required>
            <option value="">-- Select Country --</option>
            <?php foreach (['Ghana', 'Nigeria', 'Kenya', 'South Africa', 'Other'] as $c): ?>
                <option value="<?php echo $c; ?>" <?php echo $account['customer_country'] === $c ? 'selected' : ''; ?>>
                    <?php echo $c; ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label for="city">City</label><br>
        <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($account['customer_city']); ?>" required><br>

        <label for="contact">Contact Number</label><br>
        <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($account['customer_contact']); ?>" required><br>

        <label for="address">Address</label><br>
        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($account['customer_address']); ?>"><br>

        <button type="submit">Save Changes</button>
    </form>

    <a href="my_account.php">Cancel</a>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>