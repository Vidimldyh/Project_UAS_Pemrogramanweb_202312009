<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])) {
    echo "<script>alert('Keranjang masih kosong!'); window.location='index.php';</script>";
    exit;
}

$keranjang = $_SESSION['keranjang'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang Belanja - Azta Es Cream</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #e070d7;
            --secondary: #ffc2f9;
            --accent: #b300a0;
            --dark: #4d0047;
            --light: #fff0fd;
        }
        
        body {
            background: linear-gradient(135deg, #ffc2f9, #e070d7);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .cart-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .cart-header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }
        
        .cart-header h2 {
            color: var(--dark);
            font-weight: 700;
            position: relative;
            display: inline-block;
            padding-bottom: 15px;
        }
        
        .cart-header h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--accent));
            border-radius: 10px;
        }
        
        .cart-icon {
            font-size: 3rem;
            color: var(--accent);
            margin-bottom: 15px;
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
            40% {transform: translateY(-20px);}
            60% {transform: translateY(-10px);}
        }
        
        .cart-table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            border-collapse: separate;
        }
        
        .cart-table thead {
            background: linear-gradient(to right, var(--accent), var(--primary));
            color: white;
        }
        
        .cart-table th {
            font-weight: 600;
            padding: 15px;
            text-align: center;
            vertical-align: middle;
        }
        
        .cart-table td {
            padding: 15px;
            vertical-align: middle;
            text-align: center;
        }
        
        .cart-table tbody tr {
            transition: all 0.3s ease;
            background: white;
        }
        
        .cart-table tbody tr:nth-child(even) {
            background-color: #fcf7ff;
        }
        
        .cart-table tbody tr:hover {
            background-color: #fff0fd;
            transform: translateX(5px);
        }
        
        .product-info {
            display: flex;
            align-items: center;
        }
        
        .product-img {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            object-fit: cover;
            margin-right: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            border: 2px solid var(--light);
        }
        
        .product-name {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 5px;
        }
        
        .product-category {
            color: #666;
            font-size: 0.9rem;
            background: var(--light);
            padding: 3px 10px;
            border-radius: 15px;
            display: inline-block;
        }
        
        .quantity-badge {
            background: var(--accent);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
            display: inline-block;
            min-width: 50px;
        }
        
        .subtotal {
            font-weight: 700;
            color: var(--accent);
        }
        
        .total-row {
            background: linear-gradient(to right, var(--light), white);
            font-weight: 800;
            font-size: 1.2rem;
        }
        
        .total-row td {
            color: var(--dark);
        }
        
        .total-amount {
            color: var(--accent);
            font-size: 1.3rem;
        }
        
        .form-section {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border: 1px solid var(--light);
        }
        
        .form-section h5 {
            color: var(--accent);
            margin-bottom: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
        }
        
        .form-section h5 i {
            margin-right: 10px;
        }
        
        .form-control, .form-select {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 0.25rem rgba(179, 0, 160, 0.25);
        }
        
        .btn-group {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }
        
        .btn-continue {
            background: linear-gradient(to right, var(--accent), var(--primary));
            color: white;
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 6px 15px rgba(179, 0, 160, 0.4);
            display: flex;
            align-items: center;
            order: 2;
        }
        
        .btn-continue:hover {
            background: linear-gradient(to right, var(--primary), var(--accent));
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(179, 0, 160, 0.5);
            color: white;
        }
        
        .btn-back {
            background: white;
            color: var(--accent);
            border: 2px solid var(--accent);
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            order: 1;
            display: flex;
            align-items: center;
        }
        
        .btn-back:hover {
            background: var(--light);
            transform: translateY(-3px);
            color: var(--accent);
        }
        
        .empty-cart {
            text-align: center;
            padding: 50px 20px;
        }
        
        .empty-cart i {
            font-size: 5rem;
            color: var(--accent);
            margin-bottom: 20px;
            opacity: 0.5;
        }
        
        .empty-cart h4 {
            color: var(--dark);
            margin-bottom: 15px;
        }
        
        @media (max-width: 768px) {
            .cart-container {
                padding: 20px 15px;
            }
            
            .product-info {
                flex-direction: column;
                text-align: center;
            }
            
            .product-img {
                margin-right: 0;
                margin-bottom: 10px;
            }
            
            .btn-group {
                flex-direction: column;
            }
            
            .btn-continue, .btn-back {
                width: 100%;
                justify-content: center;
            }
            
            .btn-continue {
                order: 2;
            }
            
            .btn-back {
                order: 1;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="cart-container">
        <div class="cart-header">
            <div class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h2>Keranjang Belanja Anda</h2>
        </div>
        
        <div class="table-responsive">
            <table class="table cart-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $total = 0;
                    foreach ($keranjang as $id_produk => $jumlah) {
                        // Perbaikan query untuk mendapatkan nama_kategori
                        $produk = mysqli_query($conn, "
                            SELECT p.*, k.nama_kategori 
                            FROM produk p
                            JOIN kategori k ON p.id_kategori = k.id_kategori
                            WHERE p.id_produk = '$id_produk'
                        ");
                        $p = mysqli_fetch_assoc($produk);
                        $subtotal = $p['harga'] * $jumlah;
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td>
                            <div class="product-info">
                                <img src="../assets/img/<?= $p['gambar']; ?>" alt="<?= $p['nama_produk']; ?>" class="product-img">
                                <div>
                                    <div class="product-name"><?= htmlspecialchars($p['nama_produk']); ?></div>
                                    <div class="product-category"><?= htmlspecialchars($p['nama_kategori']); ?></div>
                                </div>
                            </div>
                        </td>
                        <td>Rp <?= number_format($p['harga']); ?></td>
                        <td>
                            <span class="quantity-badge"><?= $jumlah; ?></span>
                        </td>
                        <td class="subtotal">Rp <?= number_format($subtotal); ?></td>
                    </tr>
                    <?php } ?>
                    <tr class="total-row">
                        <td colspan="4" class="text-end fw-bold">Total Pembayaran</td>
                        <td class="total-amount">Rp <?= number_format($total); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <form action="checkout_multi.php" method="post">
            <div class="form-section">
                <h5><i class="fas fa-map-marker-alt"></i> Alamat Pengiriman</h5>
                <textarea name="alamat" class="form-control" rows="3" required placeholder="Contoh: Jl. Mawar No.12, Bontang"></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-section h-100">
                        <h5><i class="fas fa-calendar-alt"></i> Tanggal Pengiriman</h5>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-section h-100">
                        <h5><i class="fas fa-credit-card"></i> Metode Pembayaran</h5>
                        <select name="pembayaran" class="form-select" required>
                            <option value="">Pilih Metode</option>
                            <option value="COD">Bayar di Tempat (COD)</option>
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="QRIS">QRIS</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="btn-group">
                <a href="index.php" class="btn btn-back">
                    <i class="fas fa-arrow-left me-2"></i> Kembali Belanja
                </a>
                <button type="submit" class="btn btn-continue">
                    Lanjutkan Checkout <i class="fas fa-arrow-right ms-2"></i>
                </button>
            </div>
        </form>
    </div>
    
    <footer class="text-center text-white p-3">
        <p class="mb-0 small">© 2025 Azta Es Cream - Es Krim Terlezat di Bontang</p>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Animasi untuk elemen
    document.addEventListener('DOMContentLoaded', function() {
        // Animasi untuk baris tabel
        const rows = document.querySelectorAll('.cart-table tbody tr');
        rows.forEach((row, index) => {
            row.style.opacity = '0';
            row.style.transform = 'translateX(-20px)';
            
            setTimeout(() => {
                row.style.transition = 'all 0.5s ease';
                row.style.opacity = '1';
                row.style.transform = 'translateX(0)';
            }, index * 150);
        });
        
        // Animasi untuk tombol
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
            button.addEventListener('mousedown', function() {
                this.style.transform = 'translateY(3px)';
            });
            
            button.addEventListener('mouseup', function() {
                this.style.transform = 'translateY(0)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
        
        // Set tanggal minimal untuk pengiriman (besok)
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        
        const yyyy = tomorrow.getFullYear();
        const mm = String(tomorrow.getMonth() + 1).padStart(2, '0');
        const dd = String(tomorrow.getDate()).padStart(2, '0');
        
        const minDate = `${yyyy}-${mm}-${dd}`;
        document.querySelector('input[type="date"]').min = minDate;
    });
</script>

</body>
</html>