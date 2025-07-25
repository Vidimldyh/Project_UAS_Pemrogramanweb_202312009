<?php
session_start();
include '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_checkout = $_POST['id_checkout'];
    $nama_kurir = $_POST['nama_kurir'];
    $tanggal_kirim = $_POST['tanggal_kirim'];

    $insert = mysqli_query($conn, "
        INSERT INTO pengiriman (id_checkout, nama_kurir, tanggal_kirim)
        VALUES ('$id_checkout', '$nama_kurir', '$tanggal_kirim')
    ");

    if ($insert) {
        echo "<script>alert('Pengiriman ditambahkan!');window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan!');</script>";
    }
    exit;
}

// Ambil transaksi yang belum dikirim
$checkout = mysqli_query($conn, "
    SELECT c.id_checkout, u.nama, p.nama_produk
    FROM checkout c
    JOIN users u ON c.id_user = u.id_user
    JOIN produk p ON c.id_produk = p.id_produk
    WHERE c.id_checkout NOT IN (SELECT id_checkout FROM pengiriman)
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pengiriman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h3 class="mb-4">Tambah Pengiriman</h3>
    <form method="post">
        <div class="mb-3">
            <label>Transaksi</label>
            <select name="id_checkout" class="form-control" required>
                <option value="">-- Pilih Transaksi --</option>
                <?php while ($row = mysqli_fetch_assoc($checkout)) { ?>
                    <option value="<?= $row['id_checkout']; ?>">
                        <?= $row['nama']; ?> - <?= $row['nama_produk']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Nama Kurir</label>
            <input type="text" name="nama_kurir" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tanggal Kirim</label>
            <input type="date" name="tanggal_kirim" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
