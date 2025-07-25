<?php
session_start();
include '../../config/koneksi.php';

// Cek jika bukan admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location='../login.php';</script>";
    exit;
}

// Ambil semua data transaksi
$query = mysqli_query($conn, "
    SELECT c.*, p.nama_produk, u.nama
    FROM checkout c
    JOIN produk p ON c.id_produk = p.id_produk
    JOIN users u ON c.id_user = u.id_user
    ORDER BY c.id_checkout DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi - Azta Es Cream</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6a11cb;
            --secondary: #2575fc;
            --accent: #ff2d75;
            --light: #f8f9fa;
            --dark: #212529;
            --sidebar: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            --card-gradient: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            --success: #00c9a7;
            --warning: #ffc107;
            --info: #17a2b8;
            --danger: #dc3545;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-color: #f0f5ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            color: #444;
        }
        
        /* Navbar Atas */
        .admin-navbar {
            background: var(--sidebar);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            height: 80px;
            z-index: 1030;
            padding: 0 2rem;
        }
        
        .admin-navbar .navbar-brand {
            display: flex;
            align-items: center;
            font-weight: 700;
            color: white !important;
            font-size: 1.5rem;
            letter-spacing: 0.5px;
        }
        
        .admin-navbar .navbar-brand img {
            height: 50px;
            margin-right: 15px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
        }
        
        /* Sidebar */
        .sidebar {
            background: var(--sidebar);
            min-height: calc(100vh - 80px);
            padding-top: 20px;
            box-shadow: 5px 0 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            position: sticky;
            top: 80px;
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.85);
            padding: 12px 20px;
            margin: 5px 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 1.05rem;
        }
        
        .sidebar .nav-link i {
            width: 30px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.15);
            color: white;
            transform: translateX(5px);
        }
        
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        
        /* Konten Utama */
        .main-content {
            padding: 30px;
            min-height: calc(100vh - 80px);
        }
        
        .content-header {
            background: var(--card-gradient);
            border-radius: 20px;
            padding: 25px 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.03);
        }
        
        .content-header::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: linear-gradient(45deg, rgba(106,17,203,0.1), rgba(37,117,252,0.1));
            border-radius: 50%;
        }
        
        .content-header h1 {
            color: var(--primary);
            font-weight: 700;
            position: relative;
            font-size: 1.8rem;
            margin-bottom: 10px;
        }
        
        .content-header p {
            color: #666;
            max-width: 800px;
            position: relative;
            font-size: 1.05rem;
            line-height: 1.6;
            margin-bottom: 0;
        }
        
        /* Kartu Tabel */
        .card-table {
            background: var(--card-gradient);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.03);
            overflow: hidden;
        }
        
        .card-header-custom {
            background: linear-gradient(135deg, rgba(106,17,203,0.05), rgba(37,117,252,0.05));
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 20px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .card-header-custom h3 {
            color: var(--primary);
            font-weight: 700;
            margin: 0;
            font-size: 1.4rem;
        }
        
        .btn-group-custom {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.15);
        }
        
        .btn-secondary-custom {
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-secondary-custom:hover {
            background: #5a6268;
            color: white;
        }
        
        .btn-print {
            background: linear-gradient(135deg, var(--success), #00d9b6);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-print:hover {
            background: linear-gradient(135deg, #00b395, #00d9b6);
        }
        
        /* Tabel */
        .table-container {
            padding: 0 30px 30px;
            overflow-x: auto;
        }
        
        .table-custom {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 900px;
        }
        
        .table-custom thead tr {
            background: rgba(106,17,203,0.05);
        }
        
        .table-custom thead th {
            padding: 15px 20px;
            color: var(--primary);
            font-weight: 700;
            border-bottom: 2px solid rgba(106,17,203,0.15);
            text-align: center;
            vertical-align: middle;
        }
        
        .table-custom tbody tr {
            transition: all 0.2s ease;
        }
        
        .table-custom tbody tr:nth-child(even) {
            background-color: rgba(0,0,0,0.015);
        }
        
        .table-custom tbody tr:hover {
            background-color: rgba(106,17,203,0.03);
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.03);
        }
        
        .table-custom tbody td {
            padding: 12px 15px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            vertical-align: middle;
        }
        
        .badge-custom {
            padding: 8px 15px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-block;
            min-width: 90px;
            text-align: center;
        }
        
        .badge-selesai {
            background: rgba(0,201,167,0.15);
            color: var(--success);
        }
        
        .badge-proses {
            background: rgba(255,193,7,0.15);
            color: var(--warning);
        }
        
        .badge-batal {
            background: rgba(220,53,69,0.15);
            color: var(--danger);
        }
        
        .text-end {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .total-row {
            background: rgba(106,17,203,0.05);
            font-weight: 700;
        }
        
        .total-row td {
            border-top: 2px solid rgba(106,17,203,0.15);
            padding-top: 15px;
            padding-bottom: 15px;
        }
        
        /* Responsivitas */
        @media (max-width: 992px) {
            .sidebar {
                min-height: auto;
                padding-bottom: 20px;
                position: relative;
                top: 0;
            }
            
            .main-content {
                padding: 20px 15px;
            }
            
            .content-header {
                padding: 20px;
            }
            
            .admin-navbar {
                height: auto;
                padding: 15px;
            }
            
            .admin-navbar .navbar-brand {
                font-size: 1.2rem;
            }
            
            .table-container {
                padding: 0 15px 20px;
            }
            
            .card-header-custom {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .btn-group-custom {
                width: 100%;
                justify-content: center;
            }
        }
        
        @media (max-width: 768px) {
            .content-header h1 {
                font-size: 1.5rem;
            }
            
            .btn-group-custom {
                flex-direction: column;
            }
            
            .btn-group-custom a {
                width: 100%;
                text-align: center;
            }
        }
        
        /* Cetak */
        @media print {
            .admin-navbar, .sidebar, .card-header-custom, .btn-group-custom, .content-header::before {
                display: none !important;
            }
            
            body {
                background: white;
                padding: 20px;
            }
            
            .main-content {
                padding: 0;
                margin: 0;
            }
            
            .content-header {
                box-shadow: none;
                border: none;
                padding: 0 0 20px;
                margin-bottom: 20px;
            }
            
            .card-table {
                box-shadow: none;
                border: none;
            }
            
            .table-container {
                padding: 0;
            }
            
            .table-custom {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>

<!-- Navbar atas -->
<nav class="navbar admin-navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="../../assets/img/logo.png" alt="Logo">
            Azta Es Cream - Admin Dashboard
        </a>
        <div class="d-flex align-items-center">
            <span class="text-white me-3 d-none d-md-block">
                <i class="fas fa-user-circle me-2"></i><?= $_SESSION['nama']; ?>
            </span>
            <a class="btn btn-light btn-sm" href="../../logout.php">
                <i class="fas fa-sign-out-alt me-1"></i> Logout
            </a>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-2 col-md-3 sidebar">
            <div class="d-flex flex-column">
                <a href="../dashboard.php" class="nav-link">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="../produk/index.php" class="nav-link">
                    <i class="fas fa-ice-cream"></i> Manajemen Produk
                </a>
                <a href="../users/index.php" class="nav-link">
                    <i class="fas fa-users"></i> Manajemen User
                </a>
                <a href="transaksi.php" class="nav-link active">
                    <i class="fas fa-chart-line"></i> Laporan Transaksi
                </a>
                <a href="../pengaturan/index.php" class="nav-link">
                    <i class="fas fa-cog"></i> Pengaturan Sistem
                </a>
                <a href="../pengiriman/index.php" class="nav-link">
                    <i class="fas fa-truck"></i> Pengiriman
                </a>
                <a href="../pembayaran/index.php" class="nav-link">
                    <i class="fas fa-credit-card"></i> Pembayaran
                </a>
                <a href="../testimoni/index.php" class="nav-link">
                    <i class="fas fa-comments"></i> Testimoni
                </a>
                <a href="../aktivitas/index.php" class="nav-link">
                    <i class="fas fa-history"></i> Log Aktivitas
                </a>
            </div>
        </div>

        <!-- Konten utama -->
        <div class="col-lg-10 col-md-9 main-content">
            <div class="content-header">
                <h1><i class="fas fa-chart-line me-2"></i>Laporan Transaksi</h1>
                <p>Analisis penjualan dan kinerja transaksi untuk Azta Es Cream</p>
            </div>
            
            <div class="card-table">
                <div class="card-header-custom">
                    <h3>Daftar Transaksi</h3>
                    <div class="btn-group-custom">
                        <a href="../dashboard.php" class="btn btn-secondary-custom">
                            <i class="fas fa-arrow-left me-1"></i> Dashboard
                        </a>
                        <button class="btn btn-print" onclick="window.print()">
                            <i class="fas fa-print me-1"></i> Cetak Laporan
                        </button>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pelanggan</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Total (Rp)</th>
                                <th>Tanggal Kirim</th>
                                <th>Pembayaran</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $total_transaksi = 0;
                            while ($row = mysqli_fetch_assoc($query)) {
                                $total_transaksi += $row['total'];
                                $status_class = 'badge-proses';
                                if ($row['status'] == 'selesai') {
                                    $status_class = 'badge-selesai';
                                } else if ($row['status'] == 'batal') {
                                    $status_class = 'badge-batal';
                                }
                            ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= $row['nama']; ?></td>
                                <td><?= $row['nama_produk']; ?></td>
                                <td class="text-center"><?= $row['jumlah']; ?></td>
                                <td class="text-end"><?= number_format($row['total'], 0, ',', '.'); ?></td>
                                <td class="text-center"><?= date('d-m-Y', strtotime($row['tanggal_kirim'])); ?></td>
                                <td class="text-center"><?= ucfirst($row['metode_pembayaran']); ?></td>
                                <td class="text-center">
                                    <span class="badge-custom <?= $status_class; ?>">
                                        <?= ucfirst($row['status']); ?>
                                    </span>
                                </td>
                            </tr>
                            <?php } ?>
                            
                            <?php if (mysqli_num_rows($query) == 0) { ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fas fa-exclamation-circle me-2"></i>Belum ada transaksi
                                    </td>
                                </tr>
                            <?php } else { ?>
                                <tr class="total-row">
                                    <td colspan="4" class="text-end">Total Transaksi:</td>
                                    <td class="text-end fw-bold">Rp <?= number_format($total_transaksi, 0, ',', '.'); ?></td>
                                    <td colspan="3"></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animasi untuk sidebar
        const navLinks = document.querySelectorAll('.sidebar .nav-link');
        navLinks.forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.querySelector('i').style.transform = 'scale(1.2)';
            });
            
            link.addEventListener('mouseleave', function() {
                this.querySelector('i').style.transform = 'scale(1)';
            });
        });
    });
</script>
</body>
</html>