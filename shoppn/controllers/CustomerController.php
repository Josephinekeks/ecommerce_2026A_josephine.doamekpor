<?php
// needs customerclass methods
require_once __DIR__ . '/../classes/CustomerClass.php';

class CustomerController {
    // this holds an instance of customerclass to avoid recreating
    private $customerclass;

    //runs automatically when customercontroller is calle
    public function __construct(){
        $this->customerClass = new CustomerClass();

    }

    public function register($data) {

    if ($this->customerClass->emailExists($data['email'])) {
        return [
            'success' => false,
            'error' => 'Email already registered'
        ];
    }

    $hashedPassword = password_hash($data['pass'], PASSWORD_BCRYPT);

    // addCustomer() now returns an array
    $insertResult = $this->customerClass->addCustomer(
        $data['name'],
        $data['email'],
        $hashedPassword,
        $data['country'],
        $data['city'],
        $data['contact'],
        $data['address']
    );

    if ($insertResult['success']) {
        // Pass the new customer's ID along
        return ['success' => true, 'id' => $insertResult['id']];
    } else {
        return [
            'success' => false,
            'error' => 'Registration failed. Please try again.'
        ];
    }
}
// Takes raw emailand password, asks the Model to attempt a login,
// and returns a structured result.
public function login($email, $pass) {

    $customer = $this->customerClass->login($email, $pass);

    if ($customer) {
        // Wrap the customer row in  structured shape
        return ['success' => true, 'customer' => $customer];
    } else {
        return [
            'success' => false,
            // Deliberately vague matches the Model's own choice not
            // to reveal which part was wrong to avoid information disclosure to an attacker
            'error' => 'Invalid email or password.'
        ];
    }
}
}






?>