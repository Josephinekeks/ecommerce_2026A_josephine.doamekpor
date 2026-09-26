<!-- entry point. the homepage of the app 
this links out to the 2 customerspages
-->
<?php

// Pulls in the session, timezone, DB class, and all our helper
// functions (get_ip, redirect, is_logged_in, is_admin) — available
// from this point on, for this page AND anything it includes below.

require_once 'core/core.php';


// Loads and displays the homepage view.
require_once 'views/home.php';
?>

