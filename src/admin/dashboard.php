<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Azta Es Cream</title>
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
        }
        
        body {
            background-color: #f0f5ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        
        /* Navbar Atas */
        .admin-navbar {
            background: var(--sidebar);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            height: 80px;
            z-index: 1030;
        }
        
        .admin-navbar .navbar-brand {
            display: flex;
            align-items: center;
            font-weight: 700;
            color: white !important;
            font-size: 1.5rem;
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
        
        .welcome-section {
            background: var(--card-gradient);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }
        
        .welcome-section::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: linear-gradient(45deg, rgba(106,17,203,0.1), rgba(37,117,252,0.1));
            border-radius: 50%;
        }
        
        .welcome-section h3 {
            color: var(--primary);
            font-weight: 700;
            position: relative;
        }
        
        .welcome-section p {
            color: #666;
            max-width: 600px;
            position: relative;
        }
        
        .admin-name {
            color: var(--accent);
            font-weight: 700;
        }
        
        /* Kartu Menu */
        .dashboard-card {
            background: var(--card-gradient);
            border-radius: 15px;
            border: none;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            transition: all 0.4s ease;
            overflow: hidden;
            height: 100%;
            position: relative;
        }
        
        .dashboard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .card-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            opacity: 0.2;
            transition: all 0.3s ease;
        }
        
        .dashboard-card:hover .card-icon {
            opacity: 0.4;
            transform: scale(1.1);
        }
        
        .card-title {
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--dark);
        }
        
        .card-body {
            padding: 25px;
            position: relative;
            z-index: 2;
        }
        
        .btn-dashboard {
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            border: none;
        }
        
        /* Warna khusus untuk setiap kartu */
        .card-product {
            border-top: 4px solid #6a11cb;
        }
        
        .card-product .card-icon {
            background: rgba(106,17,203,0.1);
            color: #6a11cb;
        }
        
        .card-product .btn-dashboard {
            background: linear-gradient(135deg, #6a11cb, #8a2be2);
            color: white;
        }
        
        .card-user {
            border-top: 4px solid #2575fc;
        }
        
        .card-user .card-icon {
            background: rgba(37,117,252,0.1);
            color: #2575fc;
        }
        
        .card-user .btn-dashboard {
            background: linear-gradient(135deg, #2575fc, #4d8eff);
            color: white;
        }
        
        .card-report {
            border-top: 4px solid #00c9a7;
        }
        
        .card-report .card-icon {
            background: rgba(0,201,167,0.1);
            color: #00c9a7;
        }
        
        .card-report .btn-dashboard {
            background: linear-gradient(135deg, #00c9a7, #00d9b6);
            color: white;
        }
        
        /* Responsivitas */
        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
                padding-bottom: 20px;
            }
            
            .main-content {
                padding: 20px 15px;
            }
            
            .welcome-section {
                padding: 20px;
            }
        }
        
        /* Animasi */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-card {
            animation: fadeIn 0.6s ease forwards;
        }
        
        .card-1 { animation-delay: 0.1s; }
        .card-2 { animation-delay: 0.2s; }
        .card-3 { animation-delay: 0.3s; }
    </style>
</head>
<body>

<!-- ✅ Navbar atas -->
<nav class="navbar navbar-expand-lg admin-navbar sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="../assets/img/logo.png" alt="Logo">
            Azta Es Cream - Admin Dashboard
        </a>
        <div class="d-flex align-items-center">
            <span class="text-white me-3 d-none d-md-block"><i class="fas fa-user-circle me-2"></i><?= $_SESSION['nama']; ?></span>
            <a class="btn btn-light btn-sm" href="../logout.php">
                <i class="fas fa-sign-out-alt me-1"></i> Logout
            </a>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- ✅ Sidebar -->
        <div class="col-lg-2 col-md-3 sidebar">
            <div class="d-flex flex-column">
                <a href="dashboard.php" class="nav-link active">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="produk/index.php" class="nav-link">
                    <i class="fas fa-ice-cream"></i> Manajemen Produk
                </a>
                <a href="users/index.php" class="nav-link">
                    <i class="fas fa-users"></i> Manajemen User
                </a>
                <a href="laporan/transaksi.php" class="nav-link">
                    <i class="fas fa-chart-line"></i> Laporan Transaksi
                </a>
                <a href="pengaturan/index.php" class="nav-link">
                    <i class="fas fa-cog"></i> Pengaturan Sistem
                </a>
                <a href="pengiriman/index.php" class="nav-link">
                    <i class="fas fa-truck"></i> Pengiriman
                </a>
                <a href="pembayaran/index.php" class="nav-link">
                    <i class="fas fa-credit-card"></i> Pembayaran
                </a>
                <a href="testimoni/index.php" class="nav-link">
                    <i class="fas fa-comments"></i> Testimoni
                </a>
                <a href="aktivitas/index.php" class="nav-link">
                    <i class="fas fa-history"></i> Log Aktivitas
                </a>
            </div>
        </div>

        <!-- ✅ Konten utama -->
        <div class="col-lg-10 col-md-9 main-content">
            <div class="welcome-section">
                <h3>Selamat datang, <span class="admin-name"><?= $_SESSION['nama']; ?></span> 👋</h3>
                <p>Anda login sebagai Administrator. Gunakan panel ini untuk mengelola seluruh aspek sistem Azta Es Cream.</p>
            </div>

            <div class="row mt-4">
                <div class="col-md-4 mb-4">
                    <div class="dashboard-card card-product animate-card card-1">
                        <div class="card-icon">
                            <i class="fas fa-ice-cream"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Manajemen Produk</h5>
                            <p class="card-text">Kelola produk es krim, kategori, stok, dan harga.</p>
                            <a href="produk/index.php" class="btn btn-dashboard">
                                <i class="fas fa-arrow-right me-1"></i> Akses Menu
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="dashboard-card card-user animate-card card-2">
                        <div class="card-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Manajemen User</h5>
                            <p class="card-text">Kelola pengguna, peran, dan izin akses.</p>
                            <a href="users/index.php" class="btn btn-dashboard">
                                <i class="fas fa-arrow-right me-1"></i> Akses Menu
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="dashboard-card card-report animate-card card-3">
                        <div class="card-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Laporan Transaksi</h5>
                            <p class="card-text">Analisis penjualan, pendapatan, dan transaksi.</p>
                            <a href="laporan/transaksi.php" class="btn btn-dashboard">
                                <i class="fas fa-arrow-right me-1"></i> Akses Menu
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-12">
                    <div class="dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title d-flex align-items-center">
                                <i class="fas fa-tasks me-2 text-primary"></i> Ringkasan Sistem
                            </h5>
                            <div class="row text-center">
                                <div class="col-md-3 mb-3">
                                    <div class="p-3 bg-light rounded">
                                        <h2 class="text-primary">24</h2>
                                        <p class="mb-0">Produk Aktif</p>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="p-3 bg-light rounded">
                                        <h2 class="text-success">142</h2>
                                        <p class="mb-0">Transaksi Hari Ini</p>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="p-3 bg-light rounded">
                                        <h2 class="text-info">18</h2>
                                        <p class="mb-0">Pengiriman Aktif</p>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="p-3 bg-light rounded">
                                        <h2 class="text-warning">7</h2>
                                        <p class="mb-0">Testimoni Baru</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- akhir konten utama -->
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
        
        // Efek untuk kartu saat di-hover
        const cards = document.querySelectorAll('.dashboard-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px)';
                this.style.boxShadow = '0 15px 30px rgba(0,0,0,0.1)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 8px 20px rgba(0,0,0,0.05)';
            });
        });
    });
</script>

</body>
</html>