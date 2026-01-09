<?php
session_start();
require_once __DIR__ . '/require_login.php';
require_once __DIR__ . '/../config/database.php';

$userId = $_SESSION['user']['id'];
$password = isset($_POST['password']) ? $_POST['password'] : '';

if (empty($password)) {
    $_SESSION['error'] = 'Please enter your password to confirm deletion.';
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

if (!$row || !password_verify($password, $row['password_hash'])) {
    $conn->close();
    $_SESSION['error'] = 'Password is incorrect.';
    header('Location: ../manage_account.php');
    exit;
}

// Delete user
$del = $conn->prepare('DELETE FROM users WHERE id = ?');
$del->bind_param('i', $userId);
$ok = $del->execute();
$del->close();
$conn->close();

// Destroy session and redirect
$_SESSION = [];
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

if ($ok) {
    // Redirect to homepage with a message — because session destroyed, we can't use session flash. Use a query param.
    header('Location: ../index.php?account_deleted=1');
    exit;
} else {
    // Failed to delete — recreate a session to show message
    session_start();
    $_SESSION['error'] = 'Failed to delete account.';
    header('Location: ../manage_account.php');
    exit;
}

?>
