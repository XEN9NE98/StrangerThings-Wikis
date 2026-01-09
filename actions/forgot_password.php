<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Please provide a valid email address.';
    header('Location: ../forgot_password.php');
    exit;
}

$conn = getDBConnection();
$stmt = $conn->prepare('SELECT id, username FROM users WHERE email = ? LIMIT 1');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result ? $result->fetch_assoc() : null;
$stmt->close();

if (!$user) {
    // Do not reveal that email is not registered; show generic message
    $_SESSION['success'] = 'If that email exists in our system, a password reset link has been created. (For local testing the link is shown below)';
    header('Location: ../forgot_password.php');
    $conn->close();
    exit;
}

// Generate token and expiry (1 hour)
$token = bin2hex(random_bytes(16));
$expires = date('Y-m-d H:i:s', time() + 3600);

$update = $conn->prepare('UPDATE users SET password_reset_token = ?, password_reset_expires = ? WHERE id = ?');
$update->bind_param('ssi', $token, $expires, $user['id']);
$ok = $update->execute();
$update->close();
$conn->close();

if ($ok) {
    // Build reset link using current host and request URI
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) ? 'https' : 'http';
    $base = $protocol . '://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['REQUEST_URI']), '/\\');
    $resetLink = $base . '/reset_password.php?token=' . urlencode($token);
    // For local dev where email isn't configured, put the reset link into session to display on screen.
    $_SESSION['success'] = 'Password reset link created. If your server can send email it will be sent. For testing you can use the link below.';
    $_SESSION['reset_link'] = $resetLink;
    header('Location: ../forgot_password.php');
    exit;
} else {
    $_SESSION['error'] = 'Failed to create reset link. Please try again later.';
    header('Location: ../forgot_password.php');
    exit;
}
