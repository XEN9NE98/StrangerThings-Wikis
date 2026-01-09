<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$token = isset($_POST['token']) ? trim($_POST['token']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$password_confirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';

if (empty($token) || empty($password) || empty($password_confirm)) {
    $_SESSION['error'] = 'Please fill in all fields.';
    header('Location: ../forgot_password.php');
    exit;
}

if ($password !== $password_confirm) {
    $_SESSION['error'] = 'Passwords do not match.';
    header('Location: ../reset_password.php?token=' . urlencode($token));
    exit;
}

if (strlen($password) < 6) {
    $_SESSION['error'] = 'Password must be at least 6 characters.';
    header('Location: ../reset_password.php?token=' . urlencode($token));
    exit;
}

$conn = getDBConnection();
$stmt = $conn->prepare('SELECT id, password_reset_expires FROM users WHERE password_reset_token = ? LIMIT 1');
$stmt->bind_param('s', $token);
$stmt->execute();
$result = $stmt->get_result();
$user = $result ? $result->fetch_assoc() : null;
$stmt->close();

if (!$user || strtotime($user['password_reset_expires']) < time()) {
    $conn->close();
    $_SESSION['error'] = 'Reset token is invalid or expired.';
    header('Location: ../forgot_password.php');
    exit;
}

$pw_hash = password_hash($password, PASSWORD_DEFAULT);
$update = $conn->prepare('UPDATE users SET password_hash = ?, password_reset_token = NULL, password_reset_expires = NULL WHERE id = ?');
$update->bind_param('si', $pw_hash, $user['id']);
$ok = $update->execute();
$update->close();
$conn->close();

if ($ok) {
    $_SESSION['success'] = 'Password updated successfully. You can now log in.';
    header('Location: ../login.php');
    exit;
} else {
    $_SESSION['error'] = 'Failed to update password. Please try again later.';
    header('Location: ../reset_password.php?token=' . urlencode($token));
    exit;
}
