<?php
$pageTitle = "Forgot Password";
require_once 'includes/header.php';

// If coming back with security question in session, show step 2
$showSecurityQuestion = isset($_SESSION['forgot_username']);
?>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <h2 class="mb-4">Reset Password</h2>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
            <?php endif; ?>
            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <?php if (!$showSecurityQuestion): ?>
                <!-- Step 1: Enter Username -->
                <p class="text-muted">Enter your username to begin the password reset process.</p>
                <form action="actions/forgot_password.php" method="post">
                    <input type="hidden" name="step" value="1">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required autofocus>
                    </div>
                    <button type="submit" class="btn btn-stranger">Continue</button>
                    <a href="login.php" class="btn btn-link">Back to login</a>
                </form>
            <?php else: ?>
                <!-- Step 2: Answer Security Question -->
                <p class="text-muted">Answer your security question to reset your password.</p>
                <form action="actions/forgot_password.php" method="post">
                    <input type="hidden" name="step" value="2">
                    <div class="mb-3">
                        <label class="form-label">Security Question</label>
                        <div class="form-control-plaintext border rounded p-2 bg-light">
                            <?php echo htmlspecialchars($_SESSION['security_question']); ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="security_answer" class="form-label">Your Answer</label>
                        <input type="text" class="form-control" id="security_answer" name="security_answer" required autofocus>
                        <div class="form-text">Answer is case-insensitive</div>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-stranger">Reset Password</button>
                    <a href="?cancel=1" class="btn btn-link">Cancel</a>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
// Cancel button clears session
if (isset($_GET['cancel'])) {
    unset($_SESSION['forgot_username']);
    unset($_SESSION['security_question']);
    header('Location: forgot_password.php');
    exit;
}

require_once 'includes/footer.php';
?>
