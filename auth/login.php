<?php
session_start();
require "../config/config.php";
require "../helpers/helpers.php";

if (is_logged_in()) {
    redirect("../dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login - Perpustakaan Digital</title>
<link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-card">
        <h2>Login</h2>
        <p class="subtitle">Masuk ke akun perpustakaan kamu</p>

        <form action="login_process.php" method="POST">
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button class="btn-primary" type="submit">Login</button>
        </form>

        <p class="footnote">
            Belum punya akun? <a href="register.php">Register</a>
        </p>
    </div>
</div>

</body>
</html>