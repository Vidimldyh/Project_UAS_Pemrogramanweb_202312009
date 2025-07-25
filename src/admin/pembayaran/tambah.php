<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../../login.php");
    exit;
}
include '../../config/koneksi.php';

if (isset($_POST['simpan'])) {
    $id_checkout = $_POST['id_checkout'];
    $jumlah = $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];

    mysqli_query($conn, "INSERT INTO pembayaran (id_checkout, jumlah, tanggal) VALUES ('$id_checkout', '$jumlah', '$tanggal')");
    header("Location: index.php");
    exit;
}

// Ambil daftar checkout
$checkout = mysqli_query($conn, "
    SELECT c.id_checkout, u.nama, p.nama_produk 
    FROM checkout c
    JOIN users u ON c.id_user = u.id_user
    JOIN produk p ON c.id_produk = p.id_produk
    ORDER BY c.id_checkout DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h4>Tambah Pembayaran</h4>
    <form method="post">
        <div class="mb-3">
            <label>Checkout</label>
            <select name="id_checkout" class="form-select" required>
                <option value="">Pilih</option>
                <?php while ($c = mysqli_fetch_assoc($checkout)) { ?>
                    <option value="<?= $c['id_checkout']; ?>">
                        <?= $c['nama']; ?> - <?= $c['nama_produk']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Jumlah (Rp)</label>
            <input type="number" name="jumlah" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tanggal Pembayaran</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>
        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
