<?php
session_start();
require "../config/config.php";
require "../helpers/helpers.php";

require_login();

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Riwayat Peminjaman</title>
<link rel="stylesheet" href="../style.css">

<style>
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
    display: inline-block;
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

/* Table styling */
table {
    width: 100%;
    border-collapse: collapse;
    overflow: hidden;
    border-radius: 12px;
}

th {
    background: #2563eb;
    color: white;
    padding: 14px;
}

td {
    padding: 12px;
    background: white;
    border-bottom: 1px solid #e2e8f0;
}

.status-badge {
    padding: 6px 10px;
    border-radius: 8px;
    color: white;
    font-size: 13px;
    font-weight: 600;
}

.borrowed { background: #2563eb; }
.returned { background: #16a34a; }
.late { background: #dc2626; }
</style>

</head>
<body>

<div class="page-container">

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Menu</h3>

        <a href="../dashboard.php">🏠 Dashboard</a>
        <a href="../books/books.php">📚 Data Buku</a>
        <a href="borrow.php">📖 Peminjaman</a>
        <a href="history.php">🕓 Riwayat</a>

        <?php if ($role === 'administrator'): ?>
            <a href="../users/users.php">👤 Kelola User</a>
            <a href="../report/report.php">📄 Laporan</a>
        <?php endif; ?>

        <a class="logout-btn" href="../auth/logout.php">Logout</a>
    </div>

    <!-- Content -->
    <div class="content-box">

        <div class="title">🕓 Riwayat Peminjaman</div>

        <table>
            <tr>
                <th>Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Jatuh Tempo</th>
                <th>Dikembalikan</th>
                <th>Status</th>
            </tr>

            <?php
            $history = mysqli_query($conn, "
                SELECT b.title, br.borrow_date, br.due_date, br.return_date, br.status
                FROM borrows br
                JOIN books b ON br.book_id = b.id
                WHERE br.user_id = $user_id
                ORDER BY br.id DESC
            ");

            while ($row = mysqli_fetch_assoc($history)) {
                $statusClass = strtolower($row['status']);
                $returnDate = $row['return_date'] ? $row['return_date'] : "-";

                echo "
                <tr>
                    <td>{$row['title']}</td>
                    <td>{$row['borrow_date']}</td>
                    <td>{$row['due_date']}</td>
                    <td>$returnDate</td>
                    <td><span class='status-badge {$statusClass}'>{$row['status']}</span></td>
                </tr>";
            }
            ?>
        </table>

    </div>
</div>

</body>
</html>