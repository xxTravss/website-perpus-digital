<?php
session_start();
require "../config/config.php";
require "../helpers/helpers.php";

require_login();

if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$borrow_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// 1. Ambil data peminjaman untuk memastikan milik user ini
$check = mysqli_query($conn, "
    SELECT * FROM borrows 
    WHERE id = '$borrow_id' AND user_id = '$user_id' AND status = 'borrowed'
");

if (mysqli_num_rows($check) == 0) {
    die("Data peminjaman tidak ditemukan.");
}

$borrow = mysqli_fetch_assoc($check);
$book_id = $borrow['book_id'];

// 2. Update status & tanggal pengembalian
$today = date('Y-m-d');

mysqli_query($conn, "
    UPDATE borrows 
    SET status = 'returned', return_date = '$today'
    WHERE id = '$borrow_id'
");

// 3. Tambah stok buku
mysqli_query($conn, "
    UPDATE books 
    SET qty = qty + 1 
    WHERE id = '$book_id'
");

// 4. Redirect kembali ke history
header("Location: history.php?success=returned");
exit;
?>