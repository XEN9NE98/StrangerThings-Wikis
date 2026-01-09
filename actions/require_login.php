<?php
// Require a logged-in user. Place this file in actions/ and include it at the top of protected actions.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['user'])) {
    // Save a message and redirect to login page
    $_SESSION['error'] = 'Please log in to perform that action.';
    header('Location: ../login.php');
    exit;
}

?>
