<?php
session_start();
include '../../config/koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../../login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<script>alert('ID tidak valid!'); window.location='index.php';</script>";
    exit;
}

// Hapus data
mysqli_query($conn, "DELETE FROM pengiriman WHERE id_pengiriman = $id");

echo "<script>alert('Data berhasil dihapus'); window.location='index.php';</script>";
?>
