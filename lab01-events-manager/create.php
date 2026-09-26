<?php 
require "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

$name = trim($_POST["name"]);
$event_date = trim($_POST["event_date"]);
$location = trim($_POST["location"]);
$description = trim($_POST["description"]);

$stmt = $conn->prepare(
        "INSERT INTO events (name, event_date, location, description) VALUES (?, ?, ?, ?)"
    );

$stmt->bind_param("ssss", $name, $event_date, $location, $description);

//runs insert
$stmt->execute();

$stmt->close();
$conn->close();

//Redirect back to the events list so the user immediately sees
// new event in the list
header("Location: index.php");
exit;

}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Event</title>
</head>
<body>
    <h2>Add Event</h2>

    <form method="POST" action="create.php">
        <label>Event Name</label><br>
        <input type="text" name="name" required><br>

        <label>Date</label><br>
        <input type="date" name="event_date" required><br>

        <label>Location</label><br>
        <input type="text" name="location"><br>

        <label>Description</label><br>
        <textarea name="description"></textarea><br>

        <button type="submit">Save Event</button>
    </form>

    <a href="index.php">Back</a>
</body>
</html>
