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
<title>Register - Perpustakaan Digital</title>
<link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-card">
        <h2>Register</h2>
        <p class="subtitle">Daftar akun perpustakaan baru</p>

        <form action="register_process.php" method="POST">

            <div class="input-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" required>
            </div>

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button class="btn-primary" type="submit">Register</button>
        </form>

        <p class="footnote">
            Sudah punya akun? <a href="login.php">Login</a>
        </p>
    </div>
</div>

</body>
</html>