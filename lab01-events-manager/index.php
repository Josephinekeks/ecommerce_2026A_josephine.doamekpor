<?php
require "db.php";

//ask the database for every event referencing newest created firstg
$result = $conn->query("SELECT * FROM events ORDER BY event_date ASC");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Events</title>
</head>
<body>
    <h1>Upcoming Events</h1>
    <a href="create.php">+ Add Events</a>

    <?php
    // // $result holds ALL matching rows at once, but we can only read them
    while ($row = $result->fetch_assoc()):
        ?>
        <div>
            <h3><?php echo htmlspecialchars($row['name']); ?></h3>

            <p>
                <strong>Date:</strong>
                <?php echo htmlspecialchars($row['event_date']); ?>
    </p>
    <p>
    <strong>Location:</strong>
    <?php echo htmlspecialchars($row['location']); ?>
    </p>


    <p><?php echo htmlspecialchars($row['description']); ?></p>

    <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
        <a href="delete.php?id=<?php echo $row['id']; ?>"
        onclick="return confirm('Delete this event?');">Delete</a>
    </div>
    <hr>
    <?php endwhile; ?>


    </body>
    </html>
    <?php $conn->close(); ?>