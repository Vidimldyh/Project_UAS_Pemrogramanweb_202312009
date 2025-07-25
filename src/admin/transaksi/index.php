<?php
include '../../config/koneksi.php';

// Ambil semua data transaksi dengan JOIN ke user dan produk
$query = mysqli_query($conn, "
    SELECT t.*, u.nama AS nama_user, p.nama_produk 
    FROM transaksi t
    JOIN users u ON t.id_user = u.id_user
    JOIN produk p ON t.id_produk = p.id_produk
    ORDER BY t.tanggal_transaksi DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3 class="mb-3">Daftar Transaksi</h3>
    <a href="../dashboard.php" class="btn btn-secondary mb-3">⬅️ Kembali ke Dashboard</a>
    
    <table class="table table-bordered table-hover">
        <thead class="table-success">
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) { ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama_user']; ?></td>
                <td><?= $row['nama_produk']; ?></td>
                <td><?= $row['jumlah']; ?></td>
                <td>Rp <?= number_format($row['total']); ?></td>
                <td><?= date('d-m-Y H:i:s', strtotime($row['tanggal_transaksi'])); ?></td>
                <td>
                    <span class="badge <?= $row['status'] == 'selesai' ? 'bg-success' : 'bg-warning text-dark' ?>">
                        <?= ucfirst($row['status']); ?>
                    </span>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
