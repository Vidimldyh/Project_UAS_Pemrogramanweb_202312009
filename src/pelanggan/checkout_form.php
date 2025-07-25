<?php
session_start();
include '../config/koneksi.php';

if (!isset($_POST['id_produk']) || !isset($_SESSION['user_id'])) {
    echo "<script>alert('Akses tidak valid!');window.location='index.php';</script>";
    exit;
}

$id_produk = $_POST['id_produk'];
$jumlah = $_POST['jumlah'];

// Ambil detail produk
$produk = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = $id_produk");
$data = mysqli_fetch_assoc($produk);
$total = $data['harga'] * $jumlah;

// Tanggal minimal untuk pengantaran adalah besok
$minDate = date('Y-m-d', strtotime('+1 day'));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Azta Es Cream</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #e070d7;
            --secondary: #ffc2f9;
            --accent: #b300a0;
            --light: #fff0fd;
            --dark: #4d0047;
        }
        
        body {
            background: linear-gradient(135deg, #ffc2f9, #e070d7);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 30px 10px;
        }
        
        .navbar {
            background: linear-gradient(to right, #e3f2fd, #d1e5ff);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-bottom: 3px solid var(--accent);
            border-radius: 0 0 20px 20px;
        }
        
        .card-custom {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            max-width: 700px;
            margin: auto;
            padding: 30px;
            border: none;
            animation: fadeInUp 0.6s ease;
            transform: translateY(0);
            opacity: 1;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        h3 {
            color: var(--dark);
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 15px;
        }
        
        h3:after {
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
        
        .product-detail {
            background: var(--light);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            border: 1px dashed var(--accent);
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid rgba(179, 0, 160, 0.1);
        }
        
        .detail-item:last-child {
            border-bottom: none;
        }
        
        .total-price {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--accent);
            margin-top: 10px;
        }
        
        label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
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
        
        .btn-checkout {
            background: linear-gradient(to right, var(--accent), #8a0080);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 6px 15px rgba(179, 0, 160, 0.4);
            width: 100%;
            margin-top: 10px;
        }
        
        .btn-checkout:hover {
            background: linear-gradient(to right, #8a0080, var(--accent));
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(179, 0, 160, 0.5);
        }
        
        .btn-back {
            background: white;
            color: var(--accent);
            border: 2px solid var(--accent);
            border-radius: 50px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 15px;
        }
        
        .btn-back:hover {
            background: var(--light);
            transform: translateY(-3px);
        }
        
        .icon-highlight {
            display: inline-block;
            background: linear-gradient(to right, var(--primary), var(--accent));
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            text-align: center;
            line-height: 50px;
            margin-bottom: 20px;
            font-size: 1.5rem;
            box-shadow: 0 5px 15px rgba(179, 0, 160, 0.3);
        }
        
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        
        .step {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
            font-weight: 700;
            color: #777;
            position: relative;
        }
        
        .step.active {
            background: linear-gradient(to right, var(--primary), var(--accent));
            color: white;
        }
        
        .step:not(:last-child):after {
            content: '';
            position: absolute;
            width: 40px;
            height: 3px;
            background: #ddd;
            right: -40px;
            top: 50%;
            transform: translateY(-50%);
        }
        
        .step.active:after {
            background: linear-gradient(to right, var(--primary), var(--accent));
        }
        
        .payment-options {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }
        
        .payment-option {
            flex: 1;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .payment-option:hover, .payment-option.selected {
            border-color: var(--accent);
            background: rgba(179, 0, 160, 0.05);
            transform: translateY(-3px);
        }
        
        .payment-icon {
            font-size: 2rem;
            margin-bottom: 10px;
            color: var(--accent);
        }
        
        .hidden-radio {
            display: none;
        }
        
        .hidden-radio:checked + .payment-option {
            border-color: var(--accent);
            background: rgba(179, 0, 160, 0.05);
        }
        
        .form-section {
            margin-bottom: 25px;
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @media (max-width: 576px) {
            .card-custom {
                padding: 20px 15px;
            }
            
            .payment-options {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<!-- ✅ NAVBAR -->
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">
      <img src="../assets/img/logo.png" alt="Logo" width="60" class="me-2">
      <span style="color: var(--dark);">Azta Es Cream</span>
    </a>
  </div>
</nav>

<div class="container mt-4">
    <div class="step-indicator">
        <div class="step">1</div>
        <div class="step active">2</div>
        <div class="step">3</div>
    </div>
    
    <div class="card-custom">
        <div class="text-center">
            <div class="icon-highlight">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h3>Checkout Produk</h3>
        </div>
        
        <form action="proses_checkout.php" method="post" id="checkoutForm">
            <input type="hidden" name="id_produk" value="<?= $id_produk; ?>">
            <input type="hidden" name="jumlah" value="<?= $jumlah; ?>">
            <input type="hidden" name="total" value="<?= $total; ?>">
            
            <!-- Detail Produk -->
            <div class="product-detail form-section">
                <h5 class="mb-3" style="color: var(--accent);"><i class="fas fa-ice-cream me-2"></i>Detail Produk</h5>
                <div class="detail-item">
                    <span>Produk</span>
                    <span><?= $data['nama_produk']; ?></span>
                </div>
                <div class="detail-item">
                    <span>Harga Satuan</span>
                    <span>Rp <?= number_format($data['harga']); ?></span>
                </div>
                <div class="detail-item">
                    <span>Jumlah</span>
                    <span><?= $jumlah; ?></span>
                </div>
                <div class="detail-item">
                    <span>Total Harga</span>
                    <span class="total-price">Rp <?= number_format($total); ?></span>
                </div>
            </div>
            
            <!-- Alamat Pengantaran -->
            <div class="form-section">
                <h5 class="mb-3" style="color: var(--accent);"><i class="fas fa-map-marker-alt me-2"></i>Alamat Pengantaran</h5>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat Lengkap</label>
                    <textarea name="alamat" id="alamat" class="form-control" required placeholder="Contoh: Jl. Mawar No.12, Bontang" rows="3"></textarea>
                </div>
            </div>
            
            <!-- Tanggal Pengantaran -->
            <div class="form-section">
                <h5 class="mb-3" style="color: var(--accent);"><i class="fas fa-calendar-alt me-2"></i>Tanggal Pengantaran</h5>
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Pilih Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required min="<?= $minDate; ?>">
                </div>
            </div>
            
            <!-- Metode Pembayaran -->
            <div class="form-section">
                <h5 class="mb-3" style="color: var(--accent);"><i class="fas fa-credit-card me-2"></i>Metode Pembayaran</h5>
                <div class="mb-3">
                    <label class="form-label">Pilih Metode</label>
                    <div class="payment-options">
                        <label>
                            <input type="radio" name="pembayaran" value="COD" class="hidden-radio" required>
                            <div class="payment-option">
                                <div class="payment-icon">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <div>Bayar di Tempat (COD)</div>
                            </div>
                        </label>
                        
                        <label>
                            <input type="radio" name="pembayaran" value="Transfer" class="hidden-radio">
                            <div class="payment-option">
                                <div class="payment-icon">
                                    <i class="fas fa-university"></i>
                                </div>
                                <div>Transfer Bank</div>
                            </div>
                        </label>
                        
                        <label>
                            <input type="radio" name="pembayaran" value="QRIS" class="hidden-radio">
                            <div class="payment-option">
                                <div class="payment-icon">
                                    <i class="fas fa-qrcode"></i>
                                </div>
                                <div>QRIS</div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-checkout">
                    <i class="fas fa-check-circle me-2"></i> Konfirmasi Checkout
                </button>
                <a href="index.php" class="btn btn-back">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Produk
                </a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animasi untuk elemen form
        const formSections = document.querySelectorAll('.form-section');
        formSections.forEach((section, index) => {
            section.style.animationDelay = `${index * 0.2}s`;
        });
        
        // Efek untuk pilihan pembayaran
        const paymentOptions = document.querySelectorAll('.payment-option');
        paymentOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Hapus kelas 'selected' dari semua opsi
                paymentOptions.forEach(opt => opt.classList.remove('selected'));
                
                // Tambahkan kelas 'selected' ke opsi yang diklik
                this.classList.add('selected');
                
                // Tandai radio button yang sesuai
                const radio = this.closest('label').querySelector('input[type="radio"]');
                radio.checked = true;
            });
        });
        
        // Validasi form
        const form = document.getElementById('checkoutForm');
        form.addEventListener('submit', function(e) {
            let valid = true;
            
            // Validasi alamat
            const alamat = document.getElementById('alamat').value.trim();
            if (!alamat) {
                alert('Alamat pengantaran harus diisi!');
                valid = false;
            }
            
            // Validasi tanggal
            const tanggal = document.getElementById('tanggal').value;
            const minDate = new Date('<?= $minDate; ?>');
            const selectedDate = new Date(tanggal);
            
            if (!tanggal || selectedDate < minDate) {
                alert('Tanggal pengantaran minimal besok!');
                valid = false;
            }
            
            // Validasi metode pembayaran
            const pembayaran = document.querySelector('input[name="pembayaran"]:checked');
            if (!pembayaran) {
                alert('Pilih metode pembayaran terlebih dahulu!');
                valid = false;
            }
            
            if (!valid) {
                e.preventDefault();
            }
        });
        
        // Animasi tombol
        const buttons = document.querySelectorAll('button, .btn');
        buttons.forEach(button => {
            button.addEventListener('mousedown', function() {
                this.style.transform = 'translateY(2px)';
            });
            
            button.addEventListener('mouseup', function() {
                this.style.transform = 'translateY(0)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>

</body>
</html>