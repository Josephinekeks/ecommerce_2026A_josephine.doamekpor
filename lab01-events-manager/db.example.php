<?php
$host = "localhost";
$db_user = "your_username_here";
$db_pass = "your_password_here";
$db_name = "your_database_name_here";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}