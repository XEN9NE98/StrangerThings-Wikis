<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// Simple validation
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$password_confirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';

if (empty($username) || empty($email) || empty($password) || empty($password_confirm)) {
    $_SESSION['error'] = 'Please fill in all fields.';
    header('Location: ../register.php');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Invalid email address.';
    header('Location: ../register.php');
    exit;
}

if ($password !== $password_confirm) {
    $_SESSION['error'] = 'Passwords do not match.';
    header('Location: ../register.php');
    exit;
}

// Password policy: at least 6 chars (simple)
if (strlen($password) < 6) {
    $_SESSION['error'] = 'Password must be at least 6 characters.';
    header('Location: ../register.php');
    exit;
}

$conn = getDBConnection();

// Check existing email
$stmt = $conn->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->close();
    $conn->close();
    $_SESSION['error'] = 'Email is already registered.';
    header('Location: ../register.php');
    exit;
}
$stmt->close();

$pw_hash = password_hash($password, PASSWORD_DEFAULT);
$insert = $conn->prepare('INSERT INTO users (username, email, password_hash, created_at) VALUES (?, ?, ?, NOW())');
$insert->bind_param('sss', $username, $email, $pw_hash);
$ok = $insert->execute();
$insert->close();
$conn->close();

if ($ok) {
    $_SESSION['success'] = 'Registration successful. You can now log in.';
    header('Location: ../login.php');
    exit;
} else {
    $_SESSION['error'] = 'Registration failed. Please try again later.';
    header('Location: ../register.php');
    exit;
}
