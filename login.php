<?php
$pageTitle = "Login";
require_once 'includes/header.php';
?>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">

            <h2 class="mb-4">Login</h2>

            <!-- Error/Success Messages -->
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

            <!-- Info Alert -->
            <div class="alert alert-info mb-4" style="border-left: 5px solid var(--stranger-red); background-color: rgba(229, 9, 20, 0.1); border-color: var(--stranger-red);">
                <i class="fas fa-info-circle me-2" style="color: var(--stranger-red);"></i>
                <strong>Want to contribute?</strong> You must have an account and log in to add, edit, or delete content in this wiki.
            </div>

            <!-- LOGIN FORM -->
            <div id="loginForm">
                <form action="actions/login.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-stranger">Login</button>

                    <button type="button" onclick="showForgot()" class="btn btn-outline-stranger ms-2">
                        Forgot password?
                    </button>

                    <a href="register.php" class="btn btn-link ms-2">Create account</a>
                </form>
            </div>

            <!-- FORGOT PASSWORD FORM -->
            <div id="forgotForm" style="display:none;">
                <div class="mb-3">
                    <label class="form-label">Enter your email</label>
                    <input type="email" id="forgotEmail" class="form-control" placeholder="Your email">
                </div>

                <button class="btn btn-stranger" onclick="sendReset()">Send reset link</button>

                <button class="btn btn-outline-secondary ms-2" onclick="showLogin()">Back</button>

                <div class="mt-3" id="forgotMsg"></div>
            </div>

        </div>
    </div>
</div>

<script>
function showForgot() {
    document.getElementById("loginForm").style.display = "none";
    document.getElementById("forgotForm").style.display = "block";
}

function showLogin() {
    document.getElementById("forgotForm").style.display = "none";
    document.getElementById("loginForm").style.display = "block";
}

function sendReset() {
    const email = document.getElementById("forgotEmail").value;
    const msg = document.getElementById("forgotMsg");

    msg.innerHTML = "<span style='color:#aaa'>Sending…</span>";

    fetch("actions/forgot_password.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "email=" + encodeURIComponent(email)
    })
    .then(res => res.text())
    .then(data => {
        if (data.includes("success")) {
            msg.innerHTML = "<span style='color:#00ff99'>Reset link sent! Check your email.</span>";
        } else {
            msg.innerHTML = "<span style='color:#ff4d4d'>Failed to send reset link.</span>";
        }
    })
    .catch(() => {
        msg.innerHTML = "<span style='color:#ff4d4d'>Server error.</span>";
    });
}
</script>

<?php
require_once 'includes/footer.php';
?>
