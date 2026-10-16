<?php
require_once __DIR__ . '/../../core/core.php';
require_login();
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../../controllers/CustomerController.php';

$customerController = new CustomerController();
$account = $customerController->getAccount($_SESSION['customer_id']);
?>

<main>
    <h1>My Account</h1>

    <?php
    if (isset($_SESSION['success'])) {
        echo '<p style="color:green;">' . htmlspecialchars($_SESSION['success']) . '</p>';
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo '<p style="color:red;">' . htmlspecialchars($_SESSION['error']) . '</p>';
        unset($_SESSION['error']);
    }
    ?>

    <p><strong>Name:</strong> <?php echo htmlspecialchars($account['customer_name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($account['customer_email']); ?></p>
    <p><strong>Country:</strong> <?php echo htmlspecialchars($account['customer_country']); ?></p>
    <p><strong>City:</strong> <?php echo htmlspecialchars($account['customer_city']); ?></p>
    <p><strong>Contact:</strong> <?php echo htmlspecialchars($account['customer_contact']); ?></p>
    <p><strong>Address:</strong> <?php echo htmlspecialchars($account['customer_address']); ?></p>

    <a href="edit_account.php">Edit Account</a>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>