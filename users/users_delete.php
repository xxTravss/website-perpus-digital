<?php
session_start();
require "../config/config.php";
require "../helpers/helpers.php";

require_login();

if ($_SESSION['role'] !== 'administrator') {
    redirect("../dashboard.php");
}

$id = $_GET['id'];

// Jangan hapus akun sendiri
if ($id == $_SESSION['user_id']) {
    echo "<script>alert('Tidak bisa menghapus akun sendiri'); window.location='users.php';</script>";
    exit;
}

mysqli_query($conn, "DELETE FROM users WHERE id = $id");

redirect("users.php");