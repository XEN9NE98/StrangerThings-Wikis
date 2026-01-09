<?php
$pageTitle = "Manage Account";
require_once 'actions/require_login.php';
require_once 'config/database.php';
require_once 'includes/header.php';

$userId = $_SESSION['user']['id'];
$conn = getDBConnection();
$stmt = $conn->prepare('SELECT id, username, email, created_at FROM users WHERE id = ? LIMIT 1');
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result ? $result->fetch_assoc() : null;
$stmt->close();
$conn->close();

if (!$user) {
    $_SESSION['error'] = 'User not found.';
    header('Location: index.php');
    exit;
}
?>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <h2>Manage Account</h2>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
            <?php endif; ?>
            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Profile</h5>
                    <form action="actions/update_account.php" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                        <button type="submit" class="btn btn-stranger">Save profile</button>
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Change Password</h5>
                    <form action="actions/change_password.php" method="post">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirm" class="form-label">Confirm new password</label>
                            <input type="password" class="form-control" id="new_password_confirm" name="new_password_confirm" required>
                        </div>
                        <button type="submit" class="btn btn-stranger">Change password</button>
                    </form>
                </div>
            </div>

            <div class="card mb-4 border-danger">
                <div class="card-body">
                    <h5 class="card-title text-danger">Delete Account</h5>
                    <p class="text-muted">This will permanently delete your account. This action cannot be undone.</p>
                    <form action="actions/delete_account.php" method="post" onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.');">
                        <div class="mb-3">
                            <label for="delete_password" class="form-label">Enter your password to confirm</label>
                            <input type="password" class="form-control" id="delete_password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-outline-danger">Delete my account</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>
