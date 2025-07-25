<?php
session_start();
include '../config/koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location='../login.php';</script>";
    exit;
}

$id_user = $_SESSION['user_id'];

// Ambil daftar produk yang pernah dibeli user (hanya produk yang sudah di-checkout)
$produk = mysqli_query($conn, "
    SELECT DISTINCT p.id_produk, p.nama_produk 
    FROM checkout c 
    JOIN produk p ON c.id_produk = p.id_produk 
    WHERE c.id_user = $id_user
");

// Proses kirim testimoni
if (isset($_POST['kirim'])) {
    $id_produk = $_POST['id_produk'];
    $pesan = htmlspecialchars($_POST['pesan']);

    mysqli_query($conn, "INSERT INTO testimoni (id_user, id_produk, pesan) VALUES ('$id_user', '$id_produk', '$pesan')");

    echo "<script>alert('Testimoni berhasil dikirim!'); window.location='index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kirim Testimoni - Azta Es Cream</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Kirim Testimoni Produk</h5>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="id_produk" class="form-label">Pilih Produk</label>
                    <select name="id_produk" id="id_produk" class="form-select" required>
                        <option value="">-- Pilih Produk --</option>
                        <?php while ($p = mysqli_fetch_assoc($produk)) { ?>
                            <option value="<?= $p['id_produk']; ?>"><?= htmlspecialchars($p['nama_produk']); ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="pesan" class="form-label">Pesan Testimoni</label>
                    <textarea name="pesan" id="pesan" class="form-control" rows="4" required></textarea>
                </div>

                <button type="submit" name="kirim" class="btn btn-primary">Kirim</button>
                <a href="index.php" class="btn btn-secondary">Kembali ke Produk</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
