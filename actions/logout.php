<?php
session_start();

// Unset all session variables and destroy
session_unset();
session_destroy();

// Start a new session for logout message
session_start();
$_SESSION['logout_message'] = 'You have been logged out successfully.';

header('Location: ../index.php');
exit;
