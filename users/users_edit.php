<?php
session_start();
require "../config/config.php";
require "../helpers/helpers.php";

require_login();

if ($_SESSION['role'] !== 'administrator') {
    redirect("../dashboard.php");
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
$user = mysqli_fetch_assoc($query);

if (!$user) die("User tidak ditemukan");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // password optional
    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
        $sql = "UPDATE users SET name='$name', email='$email', role='$role', password='$password' WHERE id=$id";
    } else {
        $sql = "UPDATE users SET name='$name', email='$email', role='$role' WHERE id=$id";
    }

    mysqli_query($conn, $sql);
    redirect("users.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit User</title>
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
    background: #16a34a;
    color: white;
    padding: 10px 16px;
    border-radius: 10px;
    border: none;
}
</style>
</head>

<body>
<div class="form-box">
<h2>Edit User</h2>

<form method="POST">
    <div class="input-group">
        <label>Nama</label>
        <input type="text" name="name" value="<?= $user['name'] ?>" required>
    </div>

    <div class="input-group">
        <label>Email</label>
        <input type="email" name="email" value="<?= $user['email'] ?>" required>
    </div>

    <div class="input-group">
        <label>Role</label>
        <select name="role">
            <option value="user" <?= $user['role']=='user'?'selected':'' ?>>User</option>
            <option value="administrator" <?= $user['role']=='administrator'?'selected':'' ?>>Administrator</option>
        </select>
    </div>

    <div class="input-group">
        <label>Password (kosongkan bila tidak diubah)</label>
        <input type="password" name="password">
    </div>

    <button class="btn-submit" type="submit">Update</button>
</form>
</div>
</body>
</html>