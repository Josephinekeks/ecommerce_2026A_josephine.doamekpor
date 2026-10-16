<?php
require_once __DIR__ . '/../core/core.php';

// require_login() any logged-in customer
// should be able to edit their OWN account,
require_login();

require_once __DIR__ . '/../controllers/CustomerController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name    = strip_tags(trim($_POST['name']));
    $country = strip_tags(trim($_POST['country']));
    $city    = strip_tags(trim($_POST['city']));
    $contact = strip_tags(trim($_POST['contact']));
    $address = strip_tags(trim($_POST['address']));

    $errors = [];

    if (empty($name)) {
        $errors[] = 'Name is required.';
    }
    if (strlen($name) > 100)    $errors[] = 'Name is too long.';
    if (strlen($country) > 30)  $errors[] = 'Country is too long.';
    if (strlen($city) > 30)     $errors[] = 'City is too long.';
    if (strlen($contact) > 15)  $errors[] = 'Contact number is too long.';
    if (strlen($address) > 200) $errors[] = 'Address is too long.';

    if (!empty($errors)) {
        $_SESSION['error'] = $errors[0];
        redirect('../views/account/edit_account.php');
    }

   
    $customerController = new CustomerController();
    $success = $customerController->updateAccount(
        $_SESSION['customer_id'],
        $name,
        $country,
        $city,
        $contact,
        $address
    );

    if ($success) {
        // Keep the session's own copy of the name in sync, since
        // header.php's "Welcome, [name]" reads directly from the
        // session, not the database, on every page load.
        $_SESSION['customer_name'] = $name;

        $_SESSION['success'] = 'Account updated.';
        redirect('../views/account/my_account.php');
    } else {
        $_SESSION['error'] = 'Failed to update account. Please try again.';
        redirect('../views/account/edit_account.php');
    }
}
?>