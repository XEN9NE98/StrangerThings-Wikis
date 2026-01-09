<?php
session_start();
require_once __DIR__ . '/require_login.php';
require_once __DIR__ . '/../config/database.php';

$userId = $_SESSION['user']['id'];
$current = isset($_POST['current_password']) ? $_POST['current_password'] : '';
$new = isset($_POST['new_password']) ? $_POST['new_password'] : '';
$confirm = isset($_POST['new_password_confirm']) ? $_POST['new_password_confirm'] : '';

if (empty($current) || empty($new) || empty($confirm)) {
    $_SESSION['error'] = 'Please fill in all password fields.';
    header('Location: ../manage_account.php');
    exit;
}

if ($new !== $confirm) {
    $_SESSION['error'] = 'New passwords do not match.';
    header('Location: ../manage_account.php');
    exit;
}

if (strlen($new) < 6) {
    $_SESSION['error'] = 'New password must be at least 6 characters.';
    header('Location: ../manage_account.php');
    exit;
}

$conn = getDBConnection();
$stmt = $conn->prepare('SELECT password_hash FROM users WHERE id = ? LIMIT 1');
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result ? $result->fetch_assoc() : null;
$stmt->close();

if (!$row || !password_verify($current, $row['password_hash'])) {
    $conn->close();
    $_SESSION['error'] = 'Current password is incorrect.';
    header('Location: ../manage_account.php');
    exit;
}

$newHash = password_hash($new, PASSWORD_DEFAULT);
$update = $conn->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
$update->bind_param('si', $newHash, $userId);
$ok = $update->execute();
$update->close();
$conn->close();

if ($ok) {
    $_SESSION['success'] = 'Password changed successfully.';
} else {
    $_SESSION['error'] = 'Failed to change password.';
}

header('Location: ../manage_account.php');
exit;

?>
