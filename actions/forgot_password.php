<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/email.php';

$email = isset($_POST['email']) ? trim($_POST['email']) : '';

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Please provide a valid email address.';
    header('Location: ../forgot_password.php');
    exit;
}

$conn = getDBConnection();

// Find user
$stmt = $conn->prepare('SELECT id, username FROM users WHERE email = ? LIMIT 1');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result ? $result->fetch_assoc() : null;
$stmt->close();

// Do not reveal if email exists
if (!$user) {
    $_SESSION['success'] = 'If that email exists in our system, a password reset link has been sent.';
    header('Location: ../forgot_password.php');
    $conn->close();
    exit;
}

// Generate token and expiry (1 hour)
$token   = bin2hex(random_bytes(32));
$expires = date('Y-m-d H:i:s', time() + 3600);

// Store token
$update = $conn->prepare(
    'UPDATE users SET password_reset_token = ?, password_reset_expires = ? WHERE id = ?'
);
$update->bind_param('ssi', $token, $expires, $user['id']);
$ok = $update->execute();
$update->close();
$conn->close();

if (!$ok) {
    $_SESSION['error'] = 'Could not generate reset link. Please try again.';
    header('Location: ../forgot_password.php');
    exit;
}

// Build reset link from APP_URL
$baseUrl = rtrim($_ENV['APP_URL'], '/');
$resetLink = $baseUrl . '/reset_password.php?token=' . urlencode($token);

// Email
$emailSubject = 'Password Reset Request - Stranger Things Wiki';
$emailBody = "
<p>Hello <strong>" . htmlspecialchars($user['username']) . "</strong>,</p>
<p>You requested a password reset for your Stranger Things Wiki account.</p>
<p><a href='$resetLink'>Click here to reset your password</a></p>
<p>This link will expire in 1 hour.</p>
<p>If you did not request this, you can ignore this email.</p>
";

if (!sendEmail($email, $emailSubject, $emailBody, true)) {
    $_SESSION['error'] = 'Reset link created, but email failed to send.';
    header('Location: ../forgot_password.php');
    exit;
}

$_SESSION['success'] = 'Password reset link has been sent to your email.';
header('Location: ../forgot_password.php');
exit;
