<?php
$pageTitle = "Login";
require_once 'includes/header.php';
?>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <h2 class="mb-4">Login</h2>

            <!-- Info Alert -->
            <div class="alert alert-info mb-4" style="border-left: 4px solid var(--stranger-red); background-color: rgba(229, 9, 20, 0.1); border-color: var(--stranger-red);">
                <i class="fas fa-info-circle me-2" style="color: var(--stranger-red);"></i>
                <strong>Want to contribute?</strong> You must have an account and log in to add, edit, or delete content in this wiki.
            </div>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
            <?php endif; ?>
            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <form action="actions/login.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-stranger">Login</button>
                <a href="forgot_password.php" class="btn btn-outline-stranger ms-2">Forgot password?</a>
                <a href="register.php" class="btn btn-link ms-2">Create account</a>
            </form>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>
