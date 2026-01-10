<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$step = isset($_POST['step']) ? (int)$_POST['step'] : 1;

if ($step === 1) {
    // Step 1: Verify username and retrieve security question
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    
    if (empty($username)) {
        $_SESSION['error'] = 'Please enter your username.';
        header('Location: ../forgot_password.php');
        exit;
    }
    
    $conn = getDBConnection();
    $stmt = $conn->prepare('SELECT id, username, security_question FROM users WHERE username = ? LIMIT 1');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result ? $result->fetch_assoc() : null;
    $stmt->close();
    $conn->close();
    
    if (!$user) {
        // Don't reveal if username exists or not
        $_SESSION['error'] = 'Username not found. Please check and try again.';
        header('Location: ../forgot_password.php');
        exit;
    }
    
    // Store username and security question in session for step 2
    $_SESSION['forgot_username'] = $user['username'];
    $_SESSION['forgot_user_id'] = $user['id'];
    $_SESSION['security_question'] = $user['security_question'];
    
    header('Location: ../forgot_password.php');
    exit;
    
} elseif ($step === 2) {
    // Step 2: Verify security answer and reset password
    
    if (!isset($_SESSION['forgot_user_id'])) {
        $_SESSION['error'] = 'Session expired. Please start over.';
        header('Location: ../forgot_password.php');
        exit;
    }
    
    $security_answer = isset($_POST['security_answer']) ? trim($_POST['security_answer']) : '';
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    
    if (empty($security_answer) || empty($new_password) || empty($confirm_password)) {
        $_SESSION['error'] = 'Please fill in all fields.';
        header('Location: ../forgot_password.php');
        exit;
    }
    
    if ($new_password !== $confirm_password) {
        $_SESSION['error'] = 'Passwords do not match.';
        header('Location: ../forgot_password.php');
        exit;
    }
    
    if (strlen($new_password) < 6) {
        $_SESSION['error'] = 'Password must be at least 6 characters.';
        header('Location: ../forgot_password.php');
        exit;
    }
    
    $conn = getDBConnection();
    $stmt = $conn->prepare('SELECT security_answer_hash FROM users WHERE id = ? LIMIT 1');
    $stmt->bind_param('i', $_SESSION['forgot_user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result ? $result->fetch_assoc() : null;
    $stmt->close();
    
    if (!$user) {
        $conn->close();
        $_SESSION['error'] = 'User not found. Please start over.';
        unset($_SESSION['forgot_username']);
        unset($_SESSION['forgot_user_id']);
        unset($_SESSION['security_question']);
        header('Location: ../forgot_password.php');
        exit;
    }
    
    // Verify security answer (case-insensitive)
    if (!password_verify(strtolower($security_answer), $user['security_answer_hash'])) {
        $_SESSION['error'] = 'Security answer is incorrect. Please try again.';
        header('Location: ../forgot_password.php');
        exit;
    }
    
    // Update password
    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $update = $conn->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
    $update->bind_param('si', $new_password_hash, $_SESSION['forgot_user_id']);
    $ok = $update->execute();
    $update->close();
    $conn->close();
    
    if ($ok) {
        // Clear session data
        unset($_SESSION['forgot_username']);
        unset($_SESSION['forgot_user_id']);
        unset($_SESSION['security_question']);
        
        $_SESSION['success'] = 'Password reset successful! You can now log in with your new password.';
        header('Location: ../login.php');
        exit;
    } else {
        $_SESSION['error'] = 'Failed to reset password. Please try again later.';
        header('Location: ../forgot_password.php');
        exit;
    }
}
?>
