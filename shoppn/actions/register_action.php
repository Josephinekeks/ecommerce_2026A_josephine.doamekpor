<?php
// core.php gives us session_start(), the redirect() helper, and
// pulls in the database class 
require_once __DIR__ . '/../core/core.php';

// Brings in CustomerController, which itself pulls in CustomerClass
require_once __DIR__ . '/../controllers/CustomerController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /*sanitizing every field by removing leading and trailing spaces
    strip tags
    */
    $name    = strip_tags(trim($_POST['name']));
    $email   = strip_tags(trim($_POST['email']));
    //passwords are not striped since  it could contain legitimate symbols
    $pass    = trim($_POST['pass']); 
    $country = strip_tags(trim($_POST['country']));
    $city    = strip_tags(trim($_POST['city']));
    $contact = strip_tags(trim($_POST['contact']));
    $address = strip_tags(trim($_POST['address']));
    //collecting all issues faced by user into an array
    $errors = [];

    // filter_var with FILTER_VALIDATE_EMAIL checks the email
     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    // Reject anything the database physically couldn't store 
    if (strlen($name) > 100)    $errors[] = 'Name is too long.';
    if (strlen($email) > 50)    $errors[] = 'Email is too long.';
    if (strlen($country) > 30)  $errors[] = 'Country is too long.';
    if (strlen($city) > 30)     $errors[] = 'City is too long.';
    if (strlen($contact) > 15)  $errors[] = 'Contact number is too long.';
    if (strlen($address) > 200) $errors[] = 'Address is too long.';

    //  trim() would have already reduced pure whitespace to an empty string.
    if (empty($name) || empty($email) || empty($pass)) {
        $errors[] = 'Name, email, and password are required.';
    }

    
    $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/';

    if (!preg_match($passwordRegex, $pass)) {
        $errors[] = 'Password must be at least 8 characters and include an uppercase letter, a lowercase letter, a number, and a symbol.';
    }

      if (!empty($errors)) {
        $_SESSION['error'] = $errors[0]; 
        redirect('../views/register.php');
    }


 
    $customerController = new CustomerController();

    $result = $customerController->register([
        'name'    => $name,
        'email'   => $email,
        'pass'    => $pass,
        'country' => $country,
        'city'    => $city,
        'contact' => $contact,
        'address' => $address
    ]);

    //  act on the Controller's structured result ---
    if ($result['success']) {
        // Log the new customer in immediately after registering —
        
      $_SESSION['customer_id'] = $result['id'];
      $_SESSION['customer_name'] = $name;
      $_SESSION['customer_email'] = $email;
      $_SESSION['user_role'] = 2; // every new signup is a regular customer
                redirect('../views/account/my_account.php');
    } else {
        $_SESSION['error'] = $result['error'];
        redirect('../views/register.php');
    }

    













}







?>