<?php
require_once 'core/core.php';

// Removes all data stored in the current session 
session_unset();

// Destroys the session itself on the server side, invalidating the
// session ID entirely.
session_destroy();

redirect('index.php');
?>