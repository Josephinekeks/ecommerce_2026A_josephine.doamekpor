<?php
require "db.php";


$id = intval($_GET["id"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
     $name = trim($_POST["name"]);
    $event_date = trim($_POST["event_date"]);
    $location = trim($_POST["location"]);
    $description = trim($_POST["description"]);

    $post_id = intval($_POST["id"]);

     $stmt = $conn->prepare(
        "UPDATE events SET name=?, event_date=?, location=?, description=? WHERE id=?"
    );

    $stmt->bind_param("ssssi", $name, $event_date, $location, $description, $post_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: index.php");
    exit;

}
$stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$event) {
    die("Event not found.");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
</head>
<body>
    <h2>Edit Event</h2>

    <form method="POST" action="edit.php">
        
        <input type="hidden" name="id" value="<?php echo $event['id']; ?>">

        <label>Event Name</label><br>
        <input type="text" name="name"
               value="<?php echo htmlspecialchars($event['name']); ?>" required><br>

        <label>Date</label><br>
        <input type="date" name="event_date"
               value="<?php echo htmlspecialchars($event['event_date']); ?>" required><br>

        <label>Location</label><br>
        <input type="text" name="location"
               value="<?php echo htmlspecialchars($event['location']); ?>"><br>

        <label>Description</label><br>
        <textarea name="description"><?php echo htmlspecialchars($event['description']); ?></textarea><br>

        <button type="submit">Update Event</button>
    </form>

    <a href="index.php">Back</a>
</body>
</html>
