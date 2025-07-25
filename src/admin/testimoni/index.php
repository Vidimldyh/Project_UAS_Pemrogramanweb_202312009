<?php
session_start();
include '../../config/koneksi.php';

// Cek admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../../login.php");
    exit;
}

$query = mysqli_query($conn, "SELECT t.*, u.nama FROM testimoni t JOIN users u ON t.id_user = u.id_user ORDER BY t.id_testimoni DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Testimoni - Azta Es Cream</title>
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
        
        /* Kartu Testimoni */
        .testimonial-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            padding: 20px 0;
        }
        
        .testimonial-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            padding: 25px;
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .testimonial-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(to bottom, var(--primary), var(--secondary));
        }
        
        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .testimonial-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.2rem;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .user-info {
            flex: 1;
            overflow: hidden;
        }
        
        .user-name {
            font-weight: 700;
            margin-bottom: 3px;
            color: #333;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .testimonial-date {
            font-size: 0.85rem;
            color: #6c757d;
            display: flex;
            align-items: center;
        }
        
        .testimonial-date i {
            margin-right: 5px;
            color: var(--primary);
        }
        
        .testimonial-content {
            color: #555;
            line-height: 1.6;
            flex-grow: 1;
            margin-bottom: 20px;
            position: relative;
            padding-left: 15px;
        }
        
       
        
        .testimonial-actions {
            display: flex;
            gap: 10px;
            margin-top: auto;
        }
        
        .btn-edit {
            background: rgba(37,117,252,0.1);
            color: var(--secondary);
            border: none;
            border-radius: 8px;
            padding: 8px 15px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
            flex: 1;
            justify-content: center;
        }
        
        .btn-edit:hover {
            background: var(--secondary);
            color: white;
        }
        
        .btn-delete {
            background: rgba(220,53,69,0.1);
            color: var(--danger);
            border: none;
            border-radius: 8px;
            padding: 8px 15px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
            flex: 1;
            justify-content: center;
        }
        
        .btn-delete:hover {
            background: var(--danger);
            color: white;
        }
        
        .btn-add {
            background: linear-gradient(135deg, var(--success), #00d9b6);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            width: fit-content;
        }
        
        .btn-add:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            background: linear-gradient(135deg, #00b395, #00d9b6);
        }
        
        .btn-back {
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
            width: fit-content;
        }
        
        .btn-back:hover {
            background: #5a6268;
            color: white;
        }
        
        .no-testimonial {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .no-testimonial i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: rgba(106,17,203,0.2);
        }
        
        .no-testimonial h4 {
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .action-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .card-counter {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 0.9rem;
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
            
            .testimonial-container {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
        }
        
        @media (max-width: 768px) {
            .content-header h1 {
                font-size: 1.5rem;
            }
            
            .testimonial-container {
                grid-template-columns: 1fr;
            }
            
            .action-container {
                flex-direction: column;
                align-items: flex-start;
            }
        }
        
        @media (max-width: 576px) {
            .testimonial-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .user-avatar {
                margin-bottom: 10px;
            }
            
            .testimonial-actions {
                flex-direction: column;
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
                <a href="../laporan/transaksi.php" class="nav-link">
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
                <a href="index.php" class="nav-link active">
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
                <h1><i class="fas fa-comments me-2"></i>Manajemen Testimoni</h1>
                <p>Kelola ulasan dan testimoni pelanggan untuk Azta Es Cream</p>
            </div>
            
            <div class="action-container">
                <a href="tambah.php" class="btn btn-add">
                    <i class="fas fa-plus-circle me-1"></i> Tambah Testimoni
                </a>
                <a href="../dashboard.php" class="btn btn-back">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
            </div>
            
            <div class="testimonial-container">
                <?php if (mysqli_num_rows($query) > 0): ?>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($query)): ?>
                    <div class="testimonial-card">
                        <div class="card-counter"><?= $no; ?></div>
                        <div class="testimonial-header">
                            <div class="user-avatar">
                                <?= strtoupper(substr($row['nama'], 0, 1)); ?>
                            </div>
                            <div class="user-info">
                                <div class="user-name"><?= $row['nama']; ?></div>
                                <div class="testimonial-date">
                                    <i class="far fa-calendar"></i> <?= date('d M Y', strtotime($row['tanggal'])); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="testimonial-content">
                            <?= nl2br(htmlspecialchars($row['pesan'])); ?>
                        </div>
                        
                        <div class="testimonial-actions">
                            <a href="edit.php?id=<?= $row['id_testimoni']; ?>" class="btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="hapus.php?id=<?= $row['id_testimoni']; ?>" class="btn-delete" onclick="return confirm('Yakin hapus testimoni ini?')">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </a>
                        </div>
                    </div>
                    <?php $no++; endwhile; ?>
                <?php else: ?>
                    <div class="no-testimonial">
                        <i class="fas fa-comment-slash"></i>
                        <h4>Belum Ada Testimoni</h4>
                        <p>Tidak ada testimoni yang ditemukan dalam sistem</p>
                        <a href="tambah.php" class="btn btn-add mt-3">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Testimoni Pertama
                        </a>
                    </div>
                <?php endif; ?>
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
        
        // Efek hover untuk kartu testimoni
        const testimonialCards = document.querySelectorAll('.testimonial-card');
        testimonialCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px)';
                this.style.boxShadow = '0 15px 30px rgba(0,0,0,0.1)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.05)';
            });
        });
    });
</script>
</body>
</html>