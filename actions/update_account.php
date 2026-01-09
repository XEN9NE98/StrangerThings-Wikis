<?php
session_start();
require_once __DIR__ . '/require_login.php';
require_once __DIR__ . '/../config/database.php';

$userId = $_SESSION['user']['id'];
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';

if (empty($username) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Please provide a valid username and email.';
    header('Location: ../manage_account.php');
    exit;
}

$conn = getDBConnection();
// Check if another user uses this email
$stmt = $conn->prepare('SELECT id FROM users WHERE email = ? AND id != ? LIMIT 1');
$stmt->bind_param('si', $email, $userId);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->close();
    $conn->close();
    $_SESSION['error'] = 'That email is already taken.';
    header('Location: ../manage_account.php');
    exit;
}
$stmt->close();

$update = $conn->prepare('UPDATE users SET username = ?, email = ? WHERE id = ?');
$update->bind_param('ssi', $username, $email, $userId);
$ok = $update->execute();
$update->close();
$conn->close();

if ($ok) {
    // Update session user
    $_SESSION['user']['username'] = $username;
    $_SESSION['user']['email'] = $email;
    $_SESSION['success'] = 'Profile updated.';
} else {
    $_SESSION['error'] = 'Failed to update profile.';
}

header('Location: ../manage_account.php');
exit;

?>
