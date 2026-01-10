<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>
<style>
body {
    background:#000;
    font-family: Arial;
    color:white;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}
.box {
    width:380px;
    background:#111;
    padding:30px;
    border-radius:10px;
    border:1px solid #e50914;
    box-shadow:0 0 15px #e50914;
}
h2 {color:#e50914; text-align:center;}
input {
    width:100%;
    padding:12px;
    background:#222;
    border:none;
    color:white;
    border-radius:5px;
    margin-bottom:15px;
}
button {
    width:100%;
    padding:12px;
    background:#e50914;
    border:none;
    color:white;
    font-weight:bold;
    border-radius:5px;
    cursor:pointer;
}
.msg {margin-top:15px; text-align:center;}
.success {color:#00ff99;}
.error {color:#ff4d4d;}
</style>
</head>
<body>

<div class="box">
    <h2>Forgot Password</h2>
    <p style="text-align:center">Enter your email to receive reset link</p>

    <input type="email" id="email" placeholder="Enter your email">
    <button onclick="sendReset()">Send Reset Link</button>

    <div class="msg" id="msg"></div>
</div>

<script>
function sendReset() {
    const email = document.getElementById("email").value;
    const msg = document.getElementById("msg");

    msg.innerHTML = "Sending...";

    fetch("actions/forgot_password.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "email=" + encodeURIComponent(email)
    })
    .then(res => res.text())
    .then(data => {
        if (data.includes("success")) {
            msg.innerHTML = "<span class='success'>Reset link sent! Check your email.</span>";
        } else {
            msg.innerHTML = "<span class='error'>Failed to send reset link.</span>";
        }
    })
    .catch(() => {
        msg.innerHTML = "<span class='error'>Server error.</span>";
    });
}
</script>

</body>
</html>
