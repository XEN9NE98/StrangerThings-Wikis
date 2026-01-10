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
$stmt = $conn->prepare('SELECT id, username FROM users WHERE email = ? LIMIT 1');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result ? $result->fetch_assoc() : null;
$stmt->close();

if (!$user) {
    // Do not reveal if email exists
    $_SESSION['success'] = 'If that email exists in our system, a password reset link has been sent.';
    header('Location: ../forgot_password.php');
    $conn->close();
    exit;
}

// Generate token (1 hour expiry)
$token   = bin2hex(random_bytes(16));
$expires = date('Y-m-d H:i:s', time() + 3600);

$update = $conn->prepare(
    'UPDATE users SET password_reset_token = ?, password_reset_expires = ? WHERE id = ?'
);
$update->bind_param('ssi', $token, $expires, $user['id']);
$ok = $update->execute();
$update->close();
$conn->close();

if ($ok) {
    $protocol  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $resetLink = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/reset_password.php?token=' . urlencode($token);

    // 🔥 HTML EMAIL (NO RAW LINK)
    $emailSubject = "Password Reset Request - Stranger Things Wiki";
    $emailBody = "
<!DOCTYPE html>
<html>
<head>
<style>
body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
.container { max-width: 600px; margin: 20px auto; padding: 20px; background-color: #ffffff; border: 2px solid #e50914; border-radius: 6px; }
.header { color: #e50914; font-size: 22px; font-weight: bold; margin-bottom: 15px; }
.content { color: #333; line-height: 1.6; }
.link-section { margin: 25px 0; text-align: center; }
.reset-button { display: inline-block; padding: 12px 30px; background-color: #e50914; color: #fff !important; text-decoration: none; border-radius: 5px; font-weight: bold; }
.reset-button:hover { background-color: #a50611; }
.footer { margin-top: 25px; padding-top: 15px; border-top: 1px solid #ddd; font-size: 11px; color: #999; text-align: center; }
</style>
</head>

<body>
<div class='container'>
    <div class='header'>🚨 Password Reset Request</div>

    <div class='content'>
        <p>Hello <strong>" . htmlspecialchars($user['username']) . "</strong>,</p>

        <p>You requested a password reset for your <strong>Stranger Things Wiki</strong> account.</p>

        <div class='link-section'>
            <a href='" . htmlspecialchars($resetLink) . "' class='reset-button'>Reset Password</a>
        </div>

        <p><strong>⏱️ This link expires in 1 hour.</strong></p>

        <p>If you did not request this password reset, please ignore this email. Your account is safe.</p>
    </div>

    <div class='footer'>
        Stranger Things Wiki Team<br>
        This is an automated message — please do not reply.
    </div>
</div>
</body>
</html>
";

    $emailSent = sendEmail($email, $emailSubject, $emailBody, true);

    if ($emailSent) {
        $_SESSION['success'] = 'Password reset link has been sent to your email.';
    } else {
        $_SESSION['error'] = 'Failed to send password reset email. Please try again later.';
    }

    header('Location: ../forgot_password.php');
    exit;
}

$_SESSION['error'] = 'Failed to create reset link.';
header('Location: ../forgot_password.php');
exit;
