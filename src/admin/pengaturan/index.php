<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../../login.php");
    exit;
}

include '../../config/koneksi.php';

$pengaturan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pengaturan LIMIT 1"));

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_aplikasi'];
    $deskripsi = $_POST['deskripsi'];
    $alamat = $_POST['alamat'];

    mysqli_query($conn, "UPDATE pengaturan SET 
        nama_aplikasi='$nama', 
        deskripsi='$deskripsi', 
        alamat_toko='$alamat' 
        WHERE id=1");

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Sistem - Azta Es Cream</title>
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
        
        /* Form Pengaturan */
        .card-settings {
            background: var(--card-gradient);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.03);
            overflow: hidden;
            padding: 30px;
        }
        
        .form-header {
            background: linear-gradient(135deg, rgba(106,17,203,0.05), rgba(37,117,252,0.05));
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }
        
        .form-header i {
            font-size: 2rem;
            color: var(--primary);
            margin-right: 15px;
            width: 60px;
            height: 60px;
            background: rgba(106,17,203,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .form-header h3 {
            color: var(--primary);
            font-weight: 700;
            margin: 0;
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        .form-group label {
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
            display: block;
        }
        
        .form-control-custom {
            width: 100%;
            padding: 14px 20px;
            border: 1px solid rgba(0,0,0,0.1);
            border-radius: 12px;
            background: white;
            transition: all 0.3s ease;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }
        
        .form-control-custom:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(106,17,203,0.15);
            outline: none;
        }
        
        .btn-group-custom {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }
        
        .btn-save {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 50px;
            padding: 12px 35px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-save:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        
        .btn-back {
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-back:hover {
            background: #5a6268;
            color: white;
        }
        
        .setting-icon {
            position: absolute;
            right: 15px;
            top: 40px;
            color: var(--primary);
            opacity: 0.5;
            font-size: 1.2rem;
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
            
            .card-settings {
                padding: 20px;
            }
        }
        
        @media (max-width: 768px) {
            .content-header h1 {
                font-size: 1.5rem;
            }
            
            .btn-group-custom {
                flex-direction: column;
            }
            
            .btn-save, .btn-back {
                width: 100%;
                justify-content: center;
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
                <a href="index.php" class="nav-link active">
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
                <h1><i class="fas fa-cog me-2"></i>Pengaturan Sistem</h1>
                <p>Konfigurasi aplikasi dan pengaturan umum untuk Azta Es Cream</p>
            </div>
            
            <div class="card-settings">
                <form method="post">
                    <div class="form-header">
                        <i class="fas fa-store"></i>
                        <div>
                            <h3>Pengaturan Toko</h3>
                            <p class="mb-0">Informasi dasar tentang toko Anda</p>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="nama_aplikasi">Nama Aplikasi</label>
                        <input type="text" name="nama_aplikasi" id="nama_aplikasi" class="form-control-custom" value="<?= $pengaturan['nama_aplikasi']; ?>" required>
                        <span class="setting-icon"><i class="fas fa-signature"></i></span>
                    </div>
                    
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Toko</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control-custom" rows="4" required><?= $pengaturan['deskripsi']; ?></textarea>
                        <span class="setting-icon"><i class="fas fa-align-left"></i></span>
                    </div>
                    
                    <div class="form-group">
                        <label for="alamat">Alamat Toko</label>
                        <textarea name="alamat" id="alamat" class="form-control-custom" rows="4" required><?= $pengaturan['alamat_toko']; ?></textarea>
                        <span class="setting-icon"><i class="fas fa-map-marker-alt"></i></span>
                    </div>
                    
                    <div class="btn-group-custom">
                        <button type="submit" name="simpan" class="btn-save">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                        <a href="../dashboard.php" class="btn-back">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
                        </a>
                    </div>
                </form>
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
        
        // Efek untuk form input
        const formInputs = document.querySelectorAll('.form-control-custom');
        formInputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.querySelector('.setting-icon').style.color = 'var(--primary)';
                this.parentElement.querySelector('.setting-icon').style.opacity = '1';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.querySelector('.setting-icon').style.color = 'var(--primary)';
                this.parentElement.querySelector('.setting-icon').style.opacity = '0.5';
            });
        });
    });
</script>
</body>
</html>