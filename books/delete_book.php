<?php
session_start();
require "../config/config.php";

// Hanya Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'administrator') {
    die("Akses ditolak!");
}

$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
$stmt->bind_param("i", $id);

$stmt->execute();

header("Location: books.php");
exit;