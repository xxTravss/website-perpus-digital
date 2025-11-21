<?php
session_start();
require "../config/config.php";
require "../helpers/helpers.php";

require_login();

if ($_SESSION['role'] !== "administrator") {
    die("Akses ditolak! Halaman ini khusus admin.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Laporan Peminjaman - Admin</title>
<link rel="stylesheet" href="../style.css">

<style>
body {
    margin: 0;
    background: #eef2f7;
    font-family: "Segoe UI", sans-serif;
}

/* Container */
.container {
    max-width: 1150px;
    margin: 40px auto;
    background: #fff;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
}

/* Header */
h2 {
    margin-bottom: 20px;
    font-size: 26px;
    font-weight: 700;
    color: #1e293b;
}

/* Tombol */
.btn {
    padding: 9px 14px;
    border-radius: 10px;
    text-decoration: none;
    color: white;
    font-size: 14px;
    font-weight: 500;
}

.btn-back {
    background: #64748b;
    margin-bottom: 15px;
    display: inline-block;
}
.btn-back:hover {
    background: #475569;
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    border-radius: 14px;
    overflow: hidden;
}

table th {
    background: #2563eb;
    color: white;
    padding: 14px;
    font-weight: 600;
    font-size: 15px;
}

table td {
    padding: 12px;
    background: #ffffff;
    border-bottom: 1px solid #e2e8f0;
    font-size: 14px;
    color: #334155;
}

table tr:hover td {
    background: #f8fafc;
}

/* Badge */
.badge {
    padding: 6px 12px;
    border-radius: 10px;
    color: #fff;
    font-size: 13px;
    font-weight: 500;
}

.badge-pinjam { background: #f59e0b; }
.badge-kembali { background: #10b981; }
</style>
</head>

<body>

<div class="container">

    <!-- Tombol kembali -->
    <a href="../dashboard.php" class="btn btn-back">← Kembali</a>

    <h2>📄 Laporan Peminjaman (Admin)</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Judul Buku</th>
                <th>Tgl Pinjam</th>
                <th>Jatuh Tempo</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $query = mysqli_query($conn, "
                SELECT borrows.*, users.name AS user_name, books.title AS book_title
                FROM borrows
                JOIN users ON users.id = borrows.user_id
                JOIN books ON books.id = borrows.book_id
                ORDER BY borrows.id DESC
            ");

            $no = 1;
            while ($row = mysqli_fetch_assoc($query)):
            ?>

            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['user_name']) ?></td>
                <td><?= htmlspecialchars($row['book_title']) ?></td>
                <td><?= $row['borrow_date'] ?></td>
                <td><?= $row['due_date'] ?></td>
                <td><?= $row['return_date'] ?: "-" ?></td>
                <td>
                    <?php if ($row['status'] == "dipinjam"): ?>
                        <span class="badge badge-pinjam">Dipinjam</span>
                    <?php else: ?>
                        <span class="badge badge-kembali">Dikembalikan</span>
                    <?php endif; ?>
                </td>
            </tr>

            <?php endwhile; ?>
        </tbody>
    </table>

</div>

</body>
</html>