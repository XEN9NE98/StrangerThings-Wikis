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
    $resetLink = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/reset_password.php?token=' . urlencode($token);
    
    // Build simple HTML email
    $emailSubject = "Password Reset Request - Stranger Things Wiki";
    $emailBody = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
            .container { max-width: 600px; margin: 20px auto; padding: 20px; background-color: white; border: 2px solid #e50914; border-radius: 5px; }
            .header { color: #e50914; font-size: 22px; font-weight: bold; margin-bottom: 15px; }
            .content { line-height: 1.6; color: #333; }
            .link-section { margin: 25px 0; }
            .reset-button { display: inline-block; padding: 12px 30px; background-color: #e50914; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; }
            .reset-button:hover { background-color: #a50611; }
            .copy-link { background-color: #f0f0f0; padding: 10px; margin-top: 10px; border-radius: 3px; word-break: break-all; font-size: 12px; }
            .footer { margin-top: 20px; padding-top: 15px; border-top: 1px solid #ddd; font-size: 11px; color: #999; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>🚨 Password Reset Request</div>
            <div class='content'>
                <p>Hello <strong>" . htmlspecialchars($user['username']) . "</strong>,</p>
                
                <p>You requested a password reset for your Stranger Things Wiki account.</p>
                
                <div class='link-section'>
                    <p><strong>Click the button below to reset your password:</strong></p>
                    <p><a href='" . htmlspecialchars($resetLink) . "' class='reset-button'>Reset Password</a></p>
                </div>
                
                <p>Or copy and paste this link in your browser:</p>
                <div class='copy-link'>" . htmlspecialchars($resetLink) . "</div>
                
                <p><strong>⏱️ This link expires in 1 hour.</strong></p>
                
                <p>If you did not request this password reset, please ignore this email. Your account is safe.</p>
                
            </div>
            <div class='footer'>
                <p>Stranger Things Wiki Team<br>This is an automated message - please do not reply</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    // Send email
    $emailSent = sendEmail($email, $emailSubject, $emailBody, true);
    
    if ($emailSent) {
        $_SESSION['success'] = 'Password reset link has been sent to your email! Please check your inbox.';
    } else {
        $_SESSION['error'] = 'Password reset link generated but email sending failed. Please check your email server configuration.';
    }
    
    header('Location: ../forgot_password.php');
    exit;
    header('Location: ../forgot_password.php');
    exit;
} else {
    $_SESSION['error'] = 'Failed to create reset link. Please try again later.';
    header('Location: ../forgot_password.php');
    exit;
}
