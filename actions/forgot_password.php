<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/email.php';

header('Content-Type: text/plain');

// Validate email
$email = isset($_POST['email']) ? trim($_POST['email']) : '';

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "error";
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

// Do NOT reveal if email exists
if (!$user) {
    echo "success";
    $conn->close();
    exit;
}

// Generate secure token (1 hour)
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
    echo "error";
    exit;
}

// Build reset link
$baseUrl = rtrim($_ENV['APP_URL'], '/');
$resetLink = $baseUrl . '/reset_password.php?token=' . urlencode($token);

// Email
$emailSubject = "Password Reset Request - Stranger Things Wiki";
$emailBody = "
<p>Hello <strong>" . htmlspecialchars($user['username']) . "</strong>,</p>
<p>You requested a password reset for your Stranger Things Wiki account.</p>
<p><a href='$resetLink'>Click here to reset your password</a></p>
<p>This link expires in 1 hour.</p>
<p>If you did not request this, please ignore this email.</p>
";

// Send email
if (!sendEmail($email, $emailSubject, $emailBody, true)) {
    echo "error";
    exit;
}

echo "success";
exit;
