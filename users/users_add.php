<?php
session_start();
require "../config/config.php";
require "../helpers/helpers.php";

require_login();

if ($_SESSION['role'] !== 'administrator') {
    redirect("../dashboard.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = md5($_POST['password']);

    mysqli_query($conn, "INSERT INTO users (name, email, password, role, created_at)
        VALUES ('$name', '$email', '$password', '$role', NOW())");

    redirect("users.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Tambah User</title>
<link rel="stylesheet" href="../style.css">
<style>
.form-box {
    max-width: 500px;
    margin: 30px auto;
    padding: 25px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.07);
}
.input-group { margin-bottom: 15px; }
input, select {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #ccc;
}
.btn-submit {
    background: #2563eb;
    color: white;
    padding: 10px 16px;
    border-radius: 10px;
    border: none;
}
</style>
</head>

<body>
<div class="form-box">
<h2>Tambah User</h2>

<form method="POST">
    <div class="input-group">
        <label>Nama</label>
        <input type="text" name="name" required>
    </div>

    <div class="input-group">
        <label>Email</label>
        <input type="email" name="email" required>
    </div>

    <div class="input-group">
        <label>Role</label>
        <select name="role" required>
            <option value="user">User</option>
            <option value="administrator">Administrator</option>
        </select>
    </div>

    <div class="input-group">
        <label>Password</label>
        <input type="password" name="password" required>
    </div>

    <button class="btn-submit" type="submit">Simpan</button>
</form>
</div>
</body>
</html>