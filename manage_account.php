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

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header Section -->
            <div class="account-header mb-5">
                <h1 class="display-5 mb-2">Account Settings</h1>
                <p class="text-muted">Welcome, <strong><?php echo htmlspecialchars($user['username']); ?></strong></p>
                <p class="small text-muted">Member since <?php echo date('M d, Y', strtotime($user['created_at'])); ?></p>
            </div>

            <!-- Alert Messages -->
            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs account-tabs mb-4" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-content" type="button" role="tab">
                        <i class="bi bi-person-circle me-2"></i>Profile
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password-content" type="button" role="tab">
                        <i class="bi bi-lock me-2"></i>Security
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="danger-tab" data-bs-toggle="tab" data-bs-target="#danger-content" type="button" role="tab">
                        <i class="bi bi-exclamation-triangle me-2"></i>Danger Zone
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content">
                <!-- Profile Tab -->
                <div class="tab-pane fade show active" id="profile-content" role="tabpanel">
                    <div class="account-card">
                        <div class="account-card-header">
                            <h5><i class="bi bi-person-circle me-2"></i>Profile Information</h5>
                            <p class="text-muted small mb-0">Update your basic account information</p>
                        </div>
                        <form action="actions/update_account.php" method="post">
                            <div class="form-section">
                                <div class="mb-4">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control account-input" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                                    <small class="form-text text-muted">Your unique identifier on the platform</small>
                                </div>
                                <div class="mb-4">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control account-input" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                    <small class="form-text text-muted">We'll use this for important notifications</small>
                                </div>
                            </div>
                            <div class="account-card-footer">
                                <button type="submit" class="btn btn-stranger">
                                    <i class="bi bi-check-circle me-2"></i>Save Changes
                                </button>
                                <a href="index.php" class="btn btn-outline-secondary ms-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Security Tab -->
                <div class="tab-pane fade" id="password-content" role="tabpanel">
                    <div class="account-card">
                        <div class="account-card-header">
                            <h5><i class="bi bi-lock me-2"></i>Change Password</h5>
                            <p class="text-muted small mb-0">Update your password to keep your account secure</p>
                        </div>
                        <form action="actions/change_password.php" method="post">
                            <div class="form-section">
                                <div class="mb-4">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" class="form-control account-input" id="current_password" name="current_password" required>
                                    <small class="form-text text-muted">Enter your current password to verify</small>
                                </div>
                                <div class="mb-4">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" class="form-control account-input" id="new_password" name="new_password" required>
                                    <small class="form-text text-muted">Choose a strong password with at least 8 characters</small>
                                </div>
                                <div class="mb-4">
                                    <label for="new_password_confirm" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control account-input" id="new_password_confirm" name="new_password_confirm" required>
                                    <small class="form-text text-muted">Re-enter your new password to confirm</small>
                                </div>
                            </div>
                            <div class="account-card-footer">
                                <button type="submit" class="btn btn-stranger">
                                    <i class="bi bi-shield-check me-2"></i>Update Password
                                </button>
                                <a href="index.php" class="btn btn-outline-secondary ms-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Danger Zone Tab -->
                <div class="tab-pane fade" id="danger-content" role="tabpanel">
                    <div class="account-card danger-zone">
                        <div class="account-card-header">
                            <h5><i class="bi bi-exclamation-triangle me-2"></i>Danger Zone</h5>
                            <p class="text-muted small mb-0">Irreversible actions - proceed with caution</p>
                        </div>
                        <form action="actions/delete_account.php" method="post" onsubmit="return confirm('⚠️ WARNING: This will permanently delete your account and all associated data. This action CANNOT be undone. Are you absolutely sure?');">
                            <div class="form-section">
                                <div class="alert alert-danger mb-4" role="alert">
                                    <i class="bi bi-exclamation-circle me-2"></i>
                                    <strong>Delete Account</strong>
                                    <p class="mb-0 mt-2">Once you delete your account, there is no going back. Please be certain.</p>
                                </div>
                                <div class="mb-4">
                                    <label for="delete_password" class="form-label">Enter your password to confirm deletion</label>
                                    <input type="password" class="form-control account-input" id="delete_password" name="password" required placeholder="Your password">
                                    <small class="form-text text-muted">This is a permanent action</small>
                                </div>
                            </div>
                            <div class="account-card-footer">
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash me-2"></i>Delete Account Permanently
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>
