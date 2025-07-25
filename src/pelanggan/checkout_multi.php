<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location='../login.php';</script>";
    exit;
}

$id_user = $_SESSION['user_id'];
$alamat = $_POST['alamat'];
$tanggal = $_POST['tanggal'];
$pembayaran = $_POST['pembayaran'];
$keranjang = $_SESSION['keranjang'] ?? [];

if (empty($keranjang)) {
    echo "<script>alert('Keranjang kosong.'); window.location='index.php';</script>";
    exit;
}

$tanggal_checkout = date('Y-m-d H:i:s');
$total_transaksi = 0; // total semua produk

foreach ($keranjang as $id_produk => $jumlah) {
    $produk = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = '$id_produk'");
    $p = mysqli_fetch_assoc($produk);
    $subtotal = $p['harga'] * $jumlah;
    $total_transaksi += $subtotal;

    // Simpan ke tabel checkout
    mysqli_query($conn, "INSERT INTO checkout 
        (id_user, id_produk, jumlah, total, alamat, tanggal_kirim, metode_pembayaran, status, tanggal_checkout)
        VALUES (
            '$id_user', 
            '$id_produk', 
            '$jumlah', 
            '$subtotal', 
            '$alamat', 
            '$tanggal', 
            '$pembayaran', 
            'menunggu', 
            '$tanggal_checkout'
        )");

    // Ambil ID checkout terakhir untuk transaksi (opsional jika 1 transaksi 1 produk)
    $id_checkout = mysqli_insert_id($conn);
}

// Simpan ke tabel transaksi (satu total semua produk)
mysqli_query($conn, "INSERT INTO transaksi (id_user, total, status, tanggal) 
    VALUES ($id_user, $total_transaksi, 'pending', '$tanggal_checkout')");

// Simpan ke tabel aktivitas
mysqli_query($conn, "INSERT INTO aktivitas (id_user, aksi, waktu) VALUES ($id_user, 'Melakukan checkout', '$tanggal_checkout')");

// Kosongkan keranjang
unset($_SESSION['keranjang']);

echo "<script>alert('Checkout berhasil!'); window.location='nota.php';</script>";
?>
