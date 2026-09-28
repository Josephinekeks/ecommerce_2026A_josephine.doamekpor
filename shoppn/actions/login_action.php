<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CustomerController.php';

// Only act on an actual form submission, not a plain page visit.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize inputs except password; could legitimately contain symbols that
    // strip_tags might mangle
    $email = strip_tags(trim($_POST['email']));
    $pass  = trim($_POST['pass']);

  
    if (empty($email) || empty($pass)) {
        $_SESSION['error'] = 'Please enter both email and password.';
        redirect('../views/login.php');
    }

    $customerController = new CustomerController();
    $result = $customerController->login($email, $pass);

    if ($result['success']) {
        
        $customer = $result['customer'];

        $_SESSION['customer_id']    = $customer['customer_id'];
        $_SESSION['customer_name']  = $customer['customer_name'];
        $_SESSION['customer_email'] = $customer['customer_email'];
        $_SESSION['user_role']      = $customer['user_role'];

        // Deliberately not storing customer_pass even the hashed
        // version in the session 

        redirect('../index.php');
    } else {
        $_SESSION['error'] = $result['error'];
        redirect('../views/login.php');
    }
}
?>