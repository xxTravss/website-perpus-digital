<?php
session_start();
require "../config/config.php";
require "../helpers/helpers.php";

// Hanya Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'administrator') {
    die("Akses ditolak!");
}

include "../partials/header.php";

$id = $_GET['id'] ?? 0;

// Ambil data buku
$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$book = $stmt->get_result()->fetch_assoc();

if (!$book) {
    die("Buku tidak ditemukan!");
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $isbn = trim($_POST['isbn']);
    $qty = intval($_POST['qty']);

    $update = $conn->prepare("UPDATE books SET title=?, author=?, isbn=?, qty=? WHERE id=?");
    $update->bind_param("sssii", $title, $author, $isbn, $qty, $id);

    if ($update->execute()) {
        header("Location: books.php");
        exit;
    } else {
        $error = "Gagal mengedit buku!";
    }
}
?>

<link rel="stylesheet" href="../assets/style-dashboard.css">

<div class="container mt-4">
    <div class="card-wrapper">
        <h2 class="page-title">✏️ Edit Buku</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" class="form-modern">
            <label>Judul Buku</label>
            <input type="text" name="title" value="<?= $book['title'] ?>" required>

            <label>Penulis</label>
            <input type="text" name="author" value="<?= $book['author'] ?>">

            <label>ISBN</label>
            <input type="text" name="isbn" value="<?= $book['isbn'] ?>">

            <label>Jumlah (Qty)</label>
            <input type="number" name="qty" value="<?= $book['qty'] ?>" min="1" required>

            <button type="submit" class="btn-primary-custom">Update</button>
        </form>
    </div>
</div>

<?php include "../partials/footer.php"; ?>