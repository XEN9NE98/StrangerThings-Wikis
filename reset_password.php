<?php
$pageTitle = "Reset Password";
require_once 'includes/header.php';

$token = isset($_GET['token']) ? trim($_GET['token']) : '';
$valid = false;

if ($token) {
    require_once 'config/database.php';
    $conn = getDBConnection();
    $stmt = $conn->prepare('SELECT id, email, password_reset_expires FROM users WHERE password_reset_token = ? LIMIT 1');
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result ? $result->fetch_assoc() : null;
    $stmt->close();
    $conn->close();

    if ($user && strtotime($user['password_reset_expires']) > time()) {
        $valid = true;
    } else {
        $_SESSION['error'] = 'Reset link is invalid or expired.';
        header('Location: forgot_password.php');
        exit;
    }
} else {
    $_SESSION['error'] = 'No reset token provided.';
    header('Location: forgot_password.php');
    exit;
}
?>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <h2 class="mb-4">Create a New Password</h2>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
            <?php endif; ?>
            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <form action="actions/reset_password.php" method="post">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirm" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                </div>
                <button type="submit" class="btn btn-outline-stranger ms-2">Set new password</button>
                <a href="login.php" class="btn btn-link ms-2">Back to login</a>
            </form>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>
