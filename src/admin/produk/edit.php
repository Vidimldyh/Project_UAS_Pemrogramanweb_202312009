<?php
session_start();
include '../../config/koneksi.php';

$id = $_GET['id'];
$produk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = $id"));
$kategori = mysqli_query($conn, "SELECT * FROM kategori");

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $id_kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];

    mysqli_query($conn, "UPDATE produk SET 
        nama_produk='$nama',
        id_kategori='$id_kategori',
        harga='$harga',
        stok='$stok',
        deskripsi='$deskripsi'
        WHERE id_produk=$id");
    
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Edit Produk</h3>
    <form method="post">
        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="nama" value="<?= $produk['nama_produk']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori" class="form-control" required>
                <?php while ($row = mysqli_fetch_assoc($kategori)) { ?>
                    <option value="<?= $row['id_kategori']; ?>" <?= ($row['id_kategori'] == $produk['id_kategori']) ? 'selected' : '' ?>>
                        <?= $row['nama_kategori']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" value="<?= $produk['harga']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" value="<?= $produk['stok']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control"><?= $produk['deskripsi']; ?></textarea>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
