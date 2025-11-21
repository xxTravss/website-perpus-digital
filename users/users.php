<?php
session_start();
require "../config/config.php";
require "../helpers/helpers.php";

require_login();

// Hanya admin yang boleh akses
if ($_SESSION['role'] !== 'administrator') {
    redirect("../dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Kelola User</title>
<link rel="stylesheet" href="../style.css">

<style>
body {
    margin: 0;
    background: #eef2f7;
    font-family: "Segoe UI", sans-serif;
}

/* Wrapper */
.container {
    max-width: 1050px;
    margin: 40px auto;
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
}

/* Header */
h2 {
    margin-bottom: 20px;
    font-size: 26px;
    font-weight: 600;
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
.btn-back:hover { background: #475569; }

.btn-add { background: #2563eb; }
.btn-edit { background: #16a34a; }
.btn-delete { background: #dc2626; }

/* Tabel */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 25px;
}

.table thead {
    background: #f8fafc;
}

.table th, .table td {
    padding: 14px;
    border-bottom: 1px solid #e2e8f0;
    font-size: 15px;
}

.table th {
    text-align: left;
    color: #334155;
    font-weight: 600;
}

.table tr:hover td {
    background: #f1f5f9;
}

/* Kolom aksi */
.actions a {
    margin-right: 8px;
}
</style>
</head>

<body>

<div class="container">

    <!-- Tombol kembali -->
    <a href="../dashboard.php" class="btn btn-back">← Kembali</a>

    <h2>👤 Kelola User</h2>

    <a href="users_add.php" class="btn btn-add">+ Tambah User</a>

    <table class="table">
        <thead>
            <tr>
                <th width="60">ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th width="140">Role</th>
                <th width="180">Aksi</th>
            </tr>
        </thead>

        <tbody>
        <?php
        $query = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
        while ($row = mysqli_fetch_assoc($query)) :
        ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= ucfirst($row['role']) ?></td>
                <td class="actions">
                    <a href="users_edit.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
                    <a href="users_delete.php?id=<?= $row['id'] ?>" class="btn btn-delete" 
                       onclick="return confirm('Hapus user ini?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>

    </table>

</div>

</body>
</html>