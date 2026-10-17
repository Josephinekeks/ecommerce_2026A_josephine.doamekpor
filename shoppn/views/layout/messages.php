<?php
// Prints one-time messages stored in the session, then clears them so

if (isset($_SESSION['success'])) {
    echo '<p class="flash success">' . htmlspecialchars($_SESSION['success']) . '</p>';
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo '<p class="flash error">' . htmlspecialchars($_SESSION['error']) . '</p>';
    unset($_SESSION['error']);
}
?>