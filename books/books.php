<?php
session_start();
require "../config/config.php";
require "../helpers/helpers.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$books = $conn->query("SELECT * FROM books ORDER BY id DESC");

include "../partials/header.php";
?>

<link rel="stylesheet" href="../assets/style-dashboard.css">

<div class="container mt-4">
    <div class="card-wrapper">

        <!-- Tombol kembali -->
        <a href="../dashboard.php" class="btn-back">← Kembali</a>

        <h2 class="page-title">📚 Daftar Buku</h2>

        <!-- Hanya ADMIN yang bisa tambah buku -->
        <?php if ($_SESSION['role'] === 'administrator'): ?>
            <a href="add_book.php" class="btn-primary-custom">+ Tambah Buku</a>
        <?php endif; ?>

        <table class="table-modern mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>ISBN</th>
                    <th>Qty</th>

                    <!-- Kolom Aksi hanya muncul untuk ADMIN -->
                    <?php if ($_SESSION['role'] === 'administrator'): ?>
                        <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>

            <tbody>
                <?php while ($row = $books->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= htmlspecialchars($row['title']); ?></td>
                    <td><?= htmlspecialchars($row['author']); ?></td>
                    <td><?= $row['isbn']; ?></td>
                    <td><?= $row['qty']; ?></td>

                    <!-- Tombol edit & hapus hanya untuk ADMIN -->
                    <?php if ($_SESSION['role'] === 'administrator'): ?>
                    <td>
                        <a href="edit_book.php?id=<?= $row['id']; ?>" class="btn-warning-custom">Edit</a>
                        <a href="delete_book.php?id=<?= $row['id']; ?>" 
                           onclick="return confirm('Hapus buku ini?')" 
                           class="btn-danger-custom">Hapus</a>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>
</div>

<?php include "../partials/footer.php"; ?> 

<style>
/* Tombol kembali */
.btn-back {
    display: inline-block;
    padding: 9px 14px;
    background: #64748b;
    color: white;
    font-size: 14px;
    font-weight: 500;
    border-radius: 10px;
    text-decoration: none;
    margin-bottom: 15px;
    transition: 0.2s;
}

.btn-back:hover {
    background: #475569;
}
</style>