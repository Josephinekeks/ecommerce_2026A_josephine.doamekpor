<?php
$host = "localhost";
$db_user = "root";
$db_pass = "";

$conn = new mysqli($host, $db_user, $db_pass,);
if($conn ->connect_error) {
    die("Connection failed:".$conn->connect_error);
}

//creating database
$conn->query("CREATE DATABASE IF NOT EXISTS events_manager");
$conn->select_db("events_manager");

//creating tables for database
$sql = "CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(225) NOT NULL,
    event_date DATE NOT NULL,
    location VARCHAR(225),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
if ($conn->query($sql) === TRUE) {
    echo "<h2>Setup complete!</h2>";
    echo "<p><a href='index.php'>Go to Events App</a></p>";
} else {
    echo "Error creating table: " . $conn->error;
}