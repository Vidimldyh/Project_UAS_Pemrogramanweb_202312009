<?php
include '../config/koneksi.php';
$data = mysqli_query($conn, "SELECT * FROM kontak_admin LIMIT 1");
$admin = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kontak Admin - Azta Es Cream</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Kontak Admin Azta Es Cream</h3>
    <div class="card shadow mt-3">
        <div class="card-body">
            <h5><?= $admin['nama_admin']; ?></h5>
            <p><strong>No. WhatsApp:</strong> <a href="https://wa.me/<?= $admin['no_wa']; ?>" target="_blank"><?= $admin['no_wa']; ?></a></p>
            <p><strong>Email:</strong> <?= $admin['email']; ?></p>
            <p><strong>Alamat:</strong> <?= $admin['alamat']; ?></p>
        </div>
    </div>
    <a href="index.php" class="btn btn-secondary mt-3">Kembali</a>
</div>
</body>
</html>
