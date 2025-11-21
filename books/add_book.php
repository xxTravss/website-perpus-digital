<?php
session_start();
require "../config/config.php";
require "../helpers/helpers.php";

// Hanya Admin yang bisa akses
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'administrator') {
    die("Akses ditolak!");
}

include "../partials/header.php";

// Proses tambah buku
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $isbn = trim($_POST['isbn']);
    $qty = intval($_POST['qty']);

    $stmt = $conn->prepare("INSERT INTO books (title, author, isbn, qty) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $title, $author, $isbn, $qty);

    if ($stmt->execute()) {
        header("Location: books.php");
        exit;
    } else {
        $error = "Gagal menambahkan buku!";
    }
}
?>

<link rel="stylesheet" href="../assets/style-dashboard.css">

<div class="container mt-4">
    <div class="card-wrapper">
        <h2 class="page-title">➕ Tambah Buku</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" class="form-modern">
            <label>Judul Buku</label>
            <input type="text" name="title" required>

            <label>Penulis</label>
            <input type="text" name="author">

            <label>ISBN</label>
            <input type="text" name="isbn">

            <label>Jumlah (Qty)</label>
            <input type="number" name="qty" required min="1">

            <button type="submit" class="btn-primary-custom">Simpan</button>
        </form>
    </div>
</div>

<?php include "../partials/footer.php"; ?>