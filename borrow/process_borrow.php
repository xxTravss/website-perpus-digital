<?php
session_start();
require "../config/config.php";
require "../helpers/helpers.php";

require_login();

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $book_id = $_POST['book_id'];
    $due_date = $_POST['due_date'];

    if (empty($book_id) || empty($due_date)) {
        echo "Data tidak lengkap.";
        exit;
    }

    // Insert ke tabel 'borrows'
    $query = "
        INSERT INTO borrows (book_id, user_id, borrow_date, due_date, status)
        VALUES ($book_id, $user_id, CURDATE(), '$due_date', 'borrowed')
    ";

    if (mysqli_query($conn, $query)) {
        header("Location: borrow.php?success=1");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
        exit;
    }
}
?>