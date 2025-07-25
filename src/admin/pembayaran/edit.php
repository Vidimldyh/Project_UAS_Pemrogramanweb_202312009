<?php
session_start();
include '../../config/koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pembayaran WHERE id_pembayaran = '$id'"));

if (isset($_POST['update'])) {
    $jumlah = $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];

    mysqli_query($conn, "UPDATE pembayaran SET jumlah='$jumlah', tanggal='$tanggal' WHERE id_pembayaran='$id'");
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h4>Edit Pembayaran</h4>
    <form method="post">
        <div class="mb-3">
            <label>Jumlah (Rp)</label>
            <input type="number" name="jumlah" value="<?= $data['jumlah']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tanggal Pembayaran</label>
            <input type="date" name="tanggal" value="<?= $data['tanggal']; ?>" class="form-control" required>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
