<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silakan login dahulu!'); window.location='../login.php';</script>";
    exit;
}

$id_user = $_SESSION['user_id'];
$id_produk = $_POST['id_produk'];
$pesan = htmlspecialchars($_POST['pesan']);

// Cek apakah testimoni sudah ada
$cek = mysqli_query($conn, "SELECT * FROM testimoni WHERE id_user = $id_user AND id_produk = $id_produk");
if (mysqli_num_rows($cek) > 0) {
    mysqli_query($conn, "UPDATE testimoni SET pesan='$pesan' WHERE id_user = $id_user AND id_produk = $id_produk");
} else {
    mysqli_query($conn, "INSERT INTO testimoni (id_user, id_produk, pesan) VALUES ($id_user, $id_produk, '$pesan')");
}
mysqli_query($conn, "INSERT INTO aktivitas (id_user, aksi) VALUES ($id_user, 'Mengirim testimoni untuk produk ID $id_produk')");

echo "<script>alert('Testimoni berhasil disimpan!'); window.location='index.php';</script>";
?>
