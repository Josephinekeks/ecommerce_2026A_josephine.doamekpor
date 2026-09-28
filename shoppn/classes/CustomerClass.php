<?php
require_once __DIR__ . '/../core/db_class.php';
// class inherits from  database
class CustomerClass extends Database {

//this checks whether an email is already registered
public function emailExists($email) {
    // using ? as a placeholder to avoid sql injection
    $stmt = $this->conn->prepare(
        "SELECT customer_email FROM customer WHERE customer_email = ?"

    );
    
    $stmt->bind_param("s", $email);
    $stmt->execute();

    //num_rows, how many rows matched, 0= email is free, 1+, taken
    $result = $stmt->get_result();
    $exists = $result->num_rows > 0;

    $stmt->close();
    return $exists;

}
//inserting a new customer row
public function addCustomer($name, $email, $pass, $country, $city, $contact, $address) {

    $stmt = $this->conn->prepare(
        "INSERT INTO customer
            (customer_name, customer_email, customer_pass, customer_country, customer_city, customer_contact, customer_address)
         VALUES (?, ?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "sssssss",
        $name, $email, $pass, $country, $city, $contact, $address
    );

    $success = $stmt->execute();

   
    $newId = $this->conn->insert_id;

    $stmt->close();

    // Instead of returning a plain true/false, return an array that
    // carries BOTH pieces of information the caller might need:
    // whether it worked, and  what ID the new row got.
    if ($success) {
        return ['success' => true, 'id' => $newId];
    } else {
        return ['success' => false, 'id' => null];
    }
}

//looks up a customer row by email
public function getCustomerByEmail($email) {

    $stmt = $this->conn->prepare(
        "SELECT * FROM customer WHERE customer_email = ?"
    );

    $stmt->bind_param("s", $email); 
    $stmt->execute();

    $result = $stmt->get_result();

    // fetch_assoc() on a result with exactly one row (or zero) returns
    // either that one row as an array, or NULL if there no rows.
    $customer = $result->fetch_assoc();

    $stmt->close();

    
    return $customer ?: false;
}

// Attempts to log a customer in.
// Returns the full customer row (array) on success, or false 

public function login($email, $pass) {

    $customer = $this->getCustomerByEmail($email);

    // If no customer with this email exists at all, stop here
    if (!$customer) {
        return false;
    }

    // password_verify(plain text attempt, stored hash) — returns
    // true if they match, false otherwise
    if (password_verify($pass, $customer['customer_pass'])) {
        return $customer;
    }

}
}






?>