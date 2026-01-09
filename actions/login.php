<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if (empty($email) || empty($password)) {
    $_SESSION['error'] = 'Please provide both email and password.';
    header('Location: ../login.php');
    exit;
}

$conn = getDBConnection();
$stmt = $conn->prepare('SELECT id, username, email, password_hash FROM users WHERE email = ? LIMIT 1');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result ? $result->fetch_assoc() : null;
$stmt->close();
$conn->close();

if ($user && password_verify($password, $user['password_hash'])) {
    // Remove password hash before storing in session
    unset($user['password_hash']);
    $_SESSION['user'] = $user;
    $_SESSION['success'] = 'Logged in successfully.';
    header('Location: ../index.php');
    exit;
} else {
    $_SESSION['error'] = 'Invalid email or password.';
    header('Location: ../login.php');
    exit;
}
