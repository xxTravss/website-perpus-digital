<?php
session_start();
require "../config/config.php";
require "../helpers/helpers.php";

require_login();

// Cegah ADMIN mengakses halaman ini
if ($_SESSION['role'] === 'administrator') {
    header("Location: ../dashboard.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$role = $_SESSION['role'];

// Ambil buku yang stoknya masih ada
$books = mysqli_query($conn, "
    SELECT * FROM books 
    WHERE qty > 0 
    ORDER BY title ASC
");

// Ambil peminjaman aktif user
$borrows = mysqli_query($conn, "
    SELECT br.id AS borrow_id, b.title, br.borrow_date, br.due_date
    FROM borrows br
    JOIN books b ON br.book_id = b.id
    WHERE br.user_id = '$user_id' AND br.status = 'borrowed'
    ORDER BY br.id DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Peminjaman Buku</title>
<link rel="stylesheet" href="../style.css">

<style>
/* Layout utama */
.page-container {
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

.logout-btn {
    margin-top: 20px;
    padding: 10px 16px;
    background: #ef4444;
    color: white;
    border-radius: 10px;
    text-decoration: none;
}
.logout-btn:hover { background: #dc2626; }

/* Content */
.content-box {
    flex-grow: 1;
    background: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.07);
}

.title {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 20px;
}

/* Form */
form {
    background: #f8fafc;
    padding: 25px;
    border-radius: 16px;
    box-shadow: inset 0 0 10px rgba(0,0,0,0.04);
}

label {
    font-weight: 600;
    margin-bottom: 6px;
    display: block;
}

select,
input[type="date"] {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    margin-bottom: 18px;
    font-size: 15px;
}

button {
    width: 100%;
    padding: 14px;
    background: #2563eb;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    color: white;
    font-weight: 700;
    cursor: pointer;
}

button:hover {
    background: #1e40af;
}

/* Table */
.table-container { margin-top: 35px; }
table { width: 100%; border-collapse: collapse; border-radius: 12px; overflow: hidden; }
th { background: #2563eb; color: white; padding: 14px; }
td { padding: 12px; background: white; border-bottom: 1px solid #e2e8f0; }
.return-btn {
    background: #16a34a;
    padding: 8px 12px;
    color: white;
    text-decoration: none;
    border-radius: 8px;
}
.return-btn:hover {
    background: #15803d;
}
</style>

</head>
<body>

<div class="page-container">

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Menu</h3>

        <a href="../dashboard.php">🏠 Dashboard</a>
        <a href="../books/books.php">📚 Data Buku</a>

        <!-- Hanya user biasa yang bisa pinjam -->
        <?php if ($role !== 'administrator'): ?>
            <a href="borrow.php">📖 Peminjaman</a>
        <?php endif; ?>

        <a href="history.php">🕓 Riwayat</a>

        <?php if ($role === 'administrator'): ?>
            <a href="../users/users.php">👤 Kelola User</a>
            <a href="../report/report.php">📄 Laporan</a>
        <?php endif; ?>

        <a class="logout-btn" href="../auth/logout.php">Logout</a>
    </div>

    <!-- Content -->
    <div class="content-box">
        <div class="title">📖 Form Peminjaman Buku</div>

        <form action="process_borrow.php" method="POST">

            <label for="book">Pilih Buku</label>
            <select name="book_id" required>
                <option value="">-- Pilih Buku --</option>

                <?php while ($row = mysqli_fetch_assoc($books)): ?>
                    <option value="<?= $row['id']; ?>">
                        <?= htmlspecialchars($row['title']); ?> (Stok: <?= $row['qty']; ?>)
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="due_date">Tanggal Pengembalian</label>
            <input type="date" name="due_date" required>

            <button type="submit">Pinjam Buku</button>
        </form>

        <!-- List peminjaman -->
        <div class="table-container">
            <h3 style="margin-bottom: 10px; margin-top:20px;">📌 Peminjaman Aktif</h3>

            <table>
                <tr>
                    <th>Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Aksi</th>
                </tr>

                <?php while ($row = mysqli_fetch_assoc($borrows)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['title']); ?></td>
                        <td><?= $row['borrow_date']; ?></td>
                        <td><?= $row['due_date']; ?></td>
                        <td>
                            <a 
                                href="return_book.php?id=<?= $row['borrow_id']; ?>" 
                                class="return-btn"
                                onclick="return confirm('Kembalikan buku ini?')"
                            >
                                Kembalikan
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

    </div>

</div>

</body>
</html>