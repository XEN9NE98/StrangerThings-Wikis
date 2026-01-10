<?php
$pageTitle = "Register";
require_once 'includes/header.php';
?>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <h2 class="mb-4">Create an Account</h2>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
            <?php endif; ?>
            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <form action="actions/register.php" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirm" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                </div>
                
                <hr class="my-4">
                <h5 class="mb-3">Security Question (For Password Recovery)</h5>
                <div class="mb-3">
                    <label for="security_question" class="form-label">Select a Security Question</label>
                    <select class="form-select" id="security_question" name="security_question" required>
                        <option value="">Choose a question...</option>
                        <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                        <option value="What was the name of your first pet?">What was the name of your first pet?</option>
                        <option value="What city were you born in?">What city were you born in?</option>
                        <option value="What is your favorite movie?">What is your favorite movie?</option>
                        <option value="What was your childhood nickname?">What was your childhood nickname?</option>
                        <option value="What is the name of your favorite teacher?">What is the name of your favorite teacher?</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="security_answer" class="form-label">Answer</label>
                    <input type="text" class="form-control" id="security_answer" name="security_answer" required>
                    <div class="form-text">This will be used to recover your password if you forget it.</div>
                </div>
                
                <button type="submit" class="btn btn-stranger">Register</button>
                <a href="login.php" class="btn btn-link ms-2">Already have an account? Login</a>
            </form>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>
