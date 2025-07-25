<?php
session_start();
include '../config/koneksi.php';

// Validasi jika user belum login
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='../login.php';</script>";
    exit;
}

// Cek apakah request berasal dari form (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form dan session
    $id_user    = $_SESSION['user_id'];
    $id_produk  = $_POST['id_produk'] ?? null;
    $jumlah     = $_POST['jumlah'] ?? 1;
    $total      = $_POST['total'] ?? 0;
    $alamat     = mysqli_real_escape_string(    $conn, $_POST['alamat'] ?? '');
    $tanggal    = $_POST['tanggal'] ?? date('Y-m-d');
    $pembayaran = $_POST['pembayaran'] ?? 'Transfer';

    // Validasi awal
    if (!$id_user || !$id_produk || !$jumlah || !$total || empty($alamat)) {
        echo "<script>alert('Data tidak lengkap.'); window.history.back();</script>";
        exit;
    }

    // Pastikan user ada di database
    $cek_user = mysqli_query($conn, "SELECT id_user FROM users WHERE id_user = '$id_user'");
    if (mysqli_num_rows($cek_user) == 0) {
        echo "<script>alert('User tidak ditemukan.'); window.location='../login.php';</script>";
        exit;
    }

    // Masukkan ke tabel checkout
    $insert = mysqli_query($conn, "INSERT INTO checkout 
        (id_user, id_produk, jumlah, total, alamat, tanggal_kirim, metode_pembayaran, status) 
        VALUES 
        ('$id_user', '$id_produk', '$jumlah', '$total', '$alamat', '$tanggal', '$pembayaran', 'pending')");

    // Cek hasil insert
    if ($insert) {
        echo "<script>alert('Checkout berhasil!'); window.location='nota.php';</script>";
    } else {
        // Tampilkan pesan error lebih jelas (sementara untuk debug)
        $error = mysqli_error($conn);
        echo "<script>alert('Checkout gagal: $error'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Akses tidak diizinkan.'); window.location='index.php';</script>";
}
?>
