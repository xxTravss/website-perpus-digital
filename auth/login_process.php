<?php
session_start();
require "../config/config.php";
require "../helpers/helpers.php";

$email = $_POST['email'];
$password = md5($_POST['password']);

$query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$password'");

if (mysqli_num_rows($query) === 1) {
    $user = mysqli_fetch_assoc($query);

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['role'] = $user['role'];

    redirect("../dashboard.php");
} else {
    echo "<script>alert('Email atau password salah!'); window.location='login.php';</script>";
}