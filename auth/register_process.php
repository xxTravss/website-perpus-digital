<?php
session_start();
require "../config/config.php";
require "../helpers/helpers.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redirect("register.php");
}

// Ambil data
$name     = trim($_POST['name']);
$email    = trim($_POST['email']);
$password = md5($_POST['password']);
$role     = "peminjam";

// Validasi simple
if ($name == "" || $email == "" || $_POST['password'] == "") {
    echo "<script>alert('Semua field harus diisi'); window.location='register.php';</script>";
    exit;
}

// Cek email sudah digunakan atau belum
$check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email' LIMIT 1");

if (mysqli_num_rows($check) > 0) {
    echo "<script>alert('Email sudah terdaftar!'); window.location='register.php';</script>";
    exit;
}

// Insert user baru
$query = mysqli_query($conn, "
    INSERT INTO users (name, email, password, role, created_at)
    VALUES ('$name', '$email', '$password', '$role', NOW())
");

if ($query) {
    echo "<script>alert('Registrasi berhasil! Silahkan login.'); window.location='login.php';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}