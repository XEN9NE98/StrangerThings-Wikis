<?php
session_start();
require_once __DIR__ . '/require_login.php';
require_once __DIR__ . '/../config/database.php';

$userId = isset($_SESSION['user']['id']) ? (int)$_SESSION['user']['id'] : 0;
$current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
$new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
$new_password_confirm = isset($_POST['new_password_confirm']) ? $_POST['new_password_confirm'] : '';

// Basic validation
if (empty($current_password) || empty($new_password) || empty($new_password_confirm)) {
    $_SESSION['error'] = 'Please fill in all password fields.';
    header('Location: ../manage_account.php');
    exit;
}

if ($new_password !== $new_password_confirm) {
    $_SESSION['error'] = 'New passwords do not match.';
    header('Location: ../manage_account.php');
    exit;
}

// Enforce stronger password policy for account change
if (strlen($new_password) < 8) {
    $_SESSION['error'] = 'New password must be at least 8 characters.';
    header('Location: ../manage_account.php');
    exit;
}

$conn = getDBConnection();

// Fetch current hash
$stmt = $conn->prepare('SELECT password_hash FROM users WHERE id = ? LIMIT 1');
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result ? $result->fetch_assoc() : null;
$stmt->close();

if (!$row) {
    $conn->close();
    $_SESSION['error'] = 'User not found.';
    header('Location: ../manage_account.php');
    exit;
}

// Verify current password
if (!password_verify($current_password, $row['password_hash'])) {
    $conn->close();
    $_SESSION['error'] = 'Current password is incorrect.';
    header('Location: ../manage_account.php');
    exit;
}

// Avoid reusing the same password (optional but helpful)
if (password_verify($new_password, $row['password_hash'])) {
    $conn->close();
    $_SESSION['error'] = 'New password cannot be the same as current password.';
    header('Location: ../manage_account.php');
    exit;
}

// Update to new password
$new_hash = password_hash($new_password, PASSWORD_DEFAULT);
$update = $conn->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
$update->bind_param('si', $new_hash, $userId);
$ok = $update->execute();
$update->close();
$conn->close();

if ($ok) {
    $_SESSION['success'] = 'Password updated successfully.';
} else {
    $_SESSION['error'] = 'Failed to update password. Please try again later.';
}

header('Location: ../manage_account.php');
exit;
