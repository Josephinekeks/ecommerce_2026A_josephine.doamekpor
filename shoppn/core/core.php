<?php
//starts and resumes the session for each visitor that logs o

session_start();
//date and time display to my timezone
date_default_timezone_set('Africa/Accra');

//calling the database class
require_once __DIR__ . '/db_class.php';


// helper functions here

// returns visitor ip address
function get_ip() {
    return $_SERVER['REMOTE_ADDR'];

}

// redirecting to another page
function redirect($url) {
    header("Location: $url");
    exit;
}

//Returns true if a customer_id exists in the session, false otherwise
// isset() checks whether a variable exists AND is not null.

function is_logged_in() {
    return isset($_SESSION['customer_id']);

}

// Returns true only if the visitor is BOTH logged in AND their
// stored role equals 1 (admin)

function is_admin() {
    return is_logged_in() && $_SESSION['user_role'] == 1;

}
?>

















