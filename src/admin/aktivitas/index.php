<?php
include '../../config/koneksi.php';

// Ambil data aktivitas bergabung dengan user
$query = mysqli_query($conn, "
    SELECT a.*, u.nama 
    FROM aktivitas a 
    JOIN users u ON a.id_user = u.id_user 
    ORDER BY a.waktu DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Aktivitas Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #4cc9f0;
            --border-radius: 10px;
            --box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 20px;
            color: var(--dark-color);
        }
        
        .page-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .card {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--box-shadow);
            overflow: hidden;
            transition: transform 0.3s ease;
            background: rgba(255, 255, 255, 0.95);
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            font-weight: 600;
            border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
            padding: 15px 25px;
            border: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.4);
        }
        
        .btn-outline-secondary {
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: white;
        }
        
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px 0;
        }
        
        .header-section h1 {
            color: var(--secondary-color);
            font-weight: 700;
            margin: 0;
            font-size: 2.2rem;
            position: relative;
            display: inline-block;
        }
        
        .header-section h1:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--accent-color);
            border-radius: 2px;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
        }
        
        .table-container {
            overflow: hidden;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            background: white;
        }
        
        table {
            margin-bottom: 0;
        }
        
        thead {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }
        
        th {
            font-weight: 500;
            padding: 15px 20px !important;
        }
        
        td {
            padding: 12px 20px !important;
            vertical-align: middle;
        }
        
        tr:nth-child(even) {
            background-color: rgba(67, 97, 238, 0.03);
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
        }
        
        .user-cell {
            display: flex;
            align-items: center;
        }
        
        .action-badge {
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .action-login {
            background-color: rgba(76, 201, 240, 0.2);
            color: #0d6efd;
        }
        
        .action-logout {
            background-color: rgba(220, 53, 69, 0.2);
            color: #dc3545;
        }
        
        .action-create {
            background-color: rgba(25, 135, 84, 0.2);
            color: #198754;
        }
        
        .action-update {
            background-color: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }
        
        .action-delete {
            background-color: rgba(220, 53, 69, 0.2);
            color: #dc3545;
        }
        
        .time-badge {
            background-color: rgba(108, 117, 125, 0.15);
            color: #6c757d;
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            display: flex;
            align-items: center;
            padding: 20px;
            border-radius: var(--border-radius);
            background: white;
            box-shadow: var(--box-shadow);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(67, 97, 238, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.5rem;
            color: var(--primary-color);
        }
        
        .stat-content h3 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--secondary-color);
        }
        
        .stat-content p {
            margin: 5px 0 0;
            color: #6c757d;
        }
        
        .search-container {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }
        
        .search-box {
            flex: 1;
            min-width: 250px;
            position: relative;
        }
        
        .search-box input {
            width: 100%;
            padding: 12px 20px 12px 45px;
            border-radius: 50px;
            border: 1px solid #dee2e6;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .search-box input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 2px 10px rgba(67, 97, 238, 0.2);
            outline: none;
        }
        
        .search-box i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        
        .filter-section {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .filter-select {
            padding: 10px 20px;
            border-radius: 50px;
            border: 1px solid #dee2e6;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            min-width: 180px;
        }
        
        footer {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .header-section {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .action-buttons {
                width: 100%;
                justify-content: flex-start;
            }
            
            th, td {
                padding: 10px 12px !important;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="page-container">
        <div class="header-section">
            <div>
                <h1>Log Aktivitas Pengguna</h1>
                <p class="text-muted mt-3">Catatan semua aktivitas yang dilakukan oleh pengguna sistem</p>
            </div>
            <div class="action-buttons">
                <a href="../dashboard.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                </a>
                <button class="btn btn-primary">
                    <i class="fas fa-download me-2"></i>Ekspor Data
                </button>
            </div>
        </div>
        
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-history"></i>
                </div>
                <div class="stat-content">
                    <h3>1,248</h3>
                    <p>Total Aktivitas</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3>24</h3>
                    <p>Pengguna Aktif</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user-clock"></i>
                </div>
                <div class="stat-content">
                    <h3>12</h3>
                    <p>Aktivitas Hari Ini</p>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-list me-2"></i>Daftar Aktivitas
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-light text-dark me-2">
                            <i class="fas fa-sync-alt me-1"></i> Realtime
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="search-container">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" placeholder="Cari aktivitas...">
                    </div>
                    
                    <div class="filter-section">
                        <select class="filter-select">
                            <option>Semua Pengguna</option>
                            <option>Admin</option>
                            <option>User Biasa</option>
                        </select>
                        
                        <select class="filter-select">
                            <option>Semua Aktivitas</option>
                            <option>Login</option>
                            <option>Logout</option>
                            <option>Buat Data</option>
                            <option>Update Data</option>
                            <option>Hapus Data</option>
                        </select>
                        
                        <select class="filter-select">
                            <option>Semua Waktu</option>
                            <option>Hari Ini</option>
                            <option>Minggu Ini</option>
                            <option>Bulan Ini</option>
                        </select>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pengguna</th>
                                <th>Aktivitas</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) { 
                                // Tentukan kelas badge berdasarkan jenis aktivitas
                                $badge_class = 'action-badge ';
                                if (stripos($row['aksi'], 'login') !== false) {
                                    $badge_class .= 'action-login';
                                } elseif (stripos($row['aksi'], 'logout') !== false) {
                                    $badge_class .= 'action-logout';
                                } elseif (stripos($row['aksi'], 'buat') !== false || stripos($row['aksi'], 'tambah') !== false) {
                                    $badge_class .= 'action-create';
                                } elseif (stripos($row['aksi'], 'edit') !== false || stripos($row['aksi'], 'update') !== false) {
                                    $badge_class .= 'action-update';
                                } elseif (stripos($row['aksi'], 'hapus') !== false || stripos($row['aksi'], 'delete') !== false) {
                                    $badge_class .= 'action-delete';
                                } else {
                                    $badge_class .= 'bg-secondary';
                                }
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td class="user-cell">
                                    <div class="user-avatar">
                                        <?= substr($row['nama'], 0, 1); ?>
                                    </div>
                                    <?= $row['nama']; ?>
                                </td>
                                <td>
                                    <span class="<?= $badge_class ?>">
                                        <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                        <?= htmlspecialchars($row['aksi']); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="time-badge">
                                        <i class="far fa-clock me-1"></i>
                                        <?= date('d-m-Y H:i:s', strtotime($row['waktu'])); ?>
                                    </span>
                                </td>
                            </tr>
                            <?php } ?>
                            <!-- Contoh data tambahan untuk demonstrasi -->
                            <tr>
                                <td><?= $no++; ?></td>
                                <td class="user-cell">
                                    <div class="user-avatar">B</div>
                                    Budi Santoso
                                </td>
                                <td>
                                    <span class="action-badge action-update">
                                        <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                        Update data produk
                                    </span>
                                </td>
                                <td>
                                    <span class="time-badge">
                                        <i class="far fa-clock me-1"></i>
                                        25-07-2025 14:20:15
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td class="user-cell">
                                    <div class="user-avatar">A</div>
                                    Admin Sistem
                                </td>
                                <td>
                                    <span class="action-badge action-delete">
                                        <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                        Hapus data pengguna
                                    </span>
                                </td>
                                <td>
                                    <span class="time-badge">
                                        <i class="far fa-clock me-1"></i>
                                        24-07-2025 09:45:22
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td class="user-cell">
                                    <div class="user-avatar">S</div>
                                    Siti Rahayu
                                </td>
                                <td>
                                    <span class="action-badge action-login">
                                        <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                        Login ke sistem
                                    </span>
                                </td>
                                <td>
                                    <span class="time-badge">
                                        <i class="far fa-clock me-1"></i>
                                        24-07-2025 08:15:03
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Menampilkan 1-10 dari 50 aktivitas
                    </div>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        
        <footer>
            <p>&copy; 2025 Sistem Log Aktivitas. Hak Cipta Dilindungi.</p>
            <p class="mt-2">Dibuat dengan <i class="fas fa-heart text-danger"></i> untuk manajemen yang lebih baik</p>
        </footer>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Efek animasi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Animasi untuk elemen statistik
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'all 0.5s ease';
                    
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 150);
            });
            
            // Animasi untuk baris tabel
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach((row, index) => {
                setTimeout(() => {
                    row.style.opacity = '0';
                    row.style.transform = 'translateX(-20px)';
                    row.style.transition = 'all 0.4s ease';
                    
                    setTimeout(() => {
                        row.style.opacity = '1';
                        row.style.transform = 'translateX(0)';
                    }, 100);
                }, index * 50);
            });
        });
    </script>
</body>
</html>