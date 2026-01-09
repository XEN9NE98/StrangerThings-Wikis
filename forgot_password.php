<?php
$pageTitle = "Forgot Password";
require_once 'includes/header.php';
?>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <h2 class="mb-4">Forgot Password</h2>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
            <?php endif; ?>
            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            <?php if (!empty($_SESSION['reset_link'])): ?>
                <div class="alert alert-info">
                    <p>Use the button below to open the reset page (for local testing):</p>
                    <a href="<?php echo htmlspecialchars($_SESSION['reset_link']); ?>" class="btn btn-primary" target="_blank">Open password reset page</a>
                </div>
                <?php unset($_SESSION['reset_link']); ?>
            <?php endif; ?>

            <form action="actions/forgot_password.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Enter your account email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <button type="submit" class="btn btn-primary">Send reset link</button>
                <a href="login.php" class="btn btn-link ms-2">Back to login</a>
            </form>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>
