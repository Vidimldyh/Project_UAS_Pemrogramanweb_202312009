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

// Ambil data pengiriman yang mau diedit
$data = mysqli_query($conn, "
    SELECT pg.*, u.nama, p.nama_produk, c.id_checkout 
    FROM pengiriman pg
    JOIN checkout c ON pg.id_checkout = c.id_checkout
    JOIN users u ON c.id_user = u.id_user
    JOIN produk p ON c.id_produk = p.id_produk
    WHERE id_pengiriman = $id
");
$pengiriman = mysqli_fetch_assoc($data);

// Jika form disubmit
if (isset($_POST['simpan'])) {
    $nama_kurir = $_POST['nama_kurir'];
    $tanggal_kirim = $_POST['tanggal_kirim'];

    mysqli_query($conn, "
        UPDATE pengiriman SET 
        nama_kurir = '$nama_kurir', 
        tanggal_kirim = '$tanggal_kirim' 
        WHERE id_pengiriman = $id
    ");

    echo "<script>alert('Data berhasil diubah'); window.location='index.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pengiriman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h3>Edit Data Pengiriman</h3>
    <form method="post">
        <div class="mb-3">
            <label>Nama Pelanggan</label>
            <input type="text" class="form-control" value="<?= $pengiriman['nama']; ?>" disabled>
        </div>
        <div class="mb-3">
            <label>Produk</label>
            <input type="text" class="form-control" value="<?= $pengiriman['nama_produk']; ?>" disabled>
        </div>
        <div class="mb-3">
            <label>Kurir</label>
            <input type="text" name="nama_kurir" class="form-control" value="<?= $pengiriman['nama_kurir']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Tanggal Kirim</label>
            <input type="date" name="tanggal_kirim" class="form-control" value="<?= $pengiriman['tanggal_kirim']; ?>" required>
        </div>
        <button type="submit" name="simpan" class="btn btn-primary">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
