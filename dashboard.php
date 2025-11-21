<?php
session_start();
require "config/config.php";
require "helpers/helpers.php";

require_login(); // redirect kalau belum login

$user_name = $_SESSION['user_name'];
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id']; // ambil id user login
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard - Perpustakaan Digital</title>
<link rel="stylesheet" href="style.css">

<style>
/* Layout */
.dashboard-container {
    display: flex;
    gap: 20px;
    max-width: 1250px;
    margin: 40px auto;
    padding: 20px;
}

/* Sidebar */
.sidebar {
    width: 250px;
    background: #ffffff;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.07);
}

.sidebar h3 {
    margin-bottom: 20px;
    font-weight: 700;
    font-size: 20px;
}

.sidebar a {
    display: block;
    padding: 12px;
    border-radius: 10px;
    margin-bottom: 8px;
    color: #333;
    text-decoration: none;
    font-size: 15px;
    transition: 0.2s;
}

.sidebar a:hover {
    background: #2563eb;
    color: white;
}

/* Content */
.dashboard-content {
    flex-grow: 1;
    background: #fff;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.07);
}

.welcome-text {
    font-size: 26px;
    font-weight: 700;
}

.role-badge {
    display: inline-block;
    padding: 6px 12px;
    background: #2563eb;
    color: white;
    border-radius: 8px;
    font-size: 14px;
    margin-left: 4px;
}

/* Cards */
.cards {
    margin-top: 25px;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
}

.card-box {
    background: #f8fafc;
    padding: 22px;
    border-radius: 18px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.card-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 6px;
}

.card-number {
    font-size: 32px;
    font-weight: 800;
    color: #2563eb;
}

.logout-btn {
    margin-top: 20px;
    display: inline-block;
    padding: 10px 16px;
    background: #ef4444;
    color: white;
    border-radius: 10px;
    text-decoration: none;
}

.logout-btn:hover {
    background: #dc2626;
}
</style>
</head>

<body>

<div class="dashboard-container">

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Menu</h3>

        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="books/books.php">📚 Data Buku</a>

        <!-- Menu khusus peminjam -->
        <?php if ($role !== 'administrator'): ?>
            <a href="borrow/borrow.php">📖 Peminjaman</a>
            <a href="borrow/history.php">🕓 Riwayat</a>
        <?php endif; ?>

        <!-- Menu Admin -->
        <?php if ($role === 'administrator'): ?>
            <a href="users/users.php">👤 Kelola User</a>
            <a href="report/report.php">📄 Laporan</a>
        <?php endif; ?>

        <a class="logout-btn" href="auth/logout.php">Logout</a>
    </div>

    <!-- Content -->
    <div class="dashboard-content">
        <div class="welcome-text">
            Halo, <?= $user_name ?>!
            <span class="role-badge"><?= ucfirst($role) ?></span>
        </div>

        <p style="margin-top: 10px; color:#555;">Selamat datang di Sistem Perpustakaan Digital.</p>

        <!-- Dashboard Cards -->
        <div class="cards">

            <!-- Total Buku -->
            <div class="card-box">
                <div class="card-title">Total Buku</div>
                <div class="card-number">
                    <?php
                    $q = mysqli_query($conn, "SELECT COUNT(*) AS total FROM books");
                    echo mysqli_fetch_assoc($q)['total'];
                    ?>
                </div>
            </div>

            <!-- Total Peminjaman (per user login) -->
            <div class="card-box">
                <div class="card-title">Total Peminjaman</div>
                <div class="card-number">
                    <?php
                    $q = mysqli_query($conn, "SELECT COUNT(*) AS total FROM borrows WHERE user_id = $user_id");
                    echo mysqli_fetch_assoc($q)['total'];
                    ?>
                </div>
            </div>

            <!-- User teregistrasi, khusus admin -->
            <?php if ($role === 'administrator'): ?>
            <div class="card-box">
                <div class="card-title">User Terdaftar</div>
                <div class="card-number">
                    <?php
                    $q = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");
                    echo mysqli_fetch_assoc($q)['total'];
                    ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>

</div>

</body>
</html>