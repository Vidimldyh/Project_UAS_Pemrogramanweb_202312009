<?php
session_start();
include '../config/koneksi.php';

$id_user = $_SESSION['user_id'] ?? null;
if (!$id_user) {
    echo "<script>alert('Silakan login terlebih dahulu!');window.location='../login.php';</script>";
    exit;
}

$query = mysqli_query($conn, "
    SELECT c.*, p.nama_produk, p.harga, p.gambar
    FROM checkout c
    JOIN produk p ON c.id_produk = p.id_produk
    WHERE c.id_user = '$id_user'
    AND c.tanggal_checkout = (
        SELECT MAX(tanggal_checkout) 
        FROM checkout 
        WHERE id_user = '$id_user'
    )
");

$items = [];
while ($row = mysqli_fetch_assoc($query)) {
    $items[] = $row;
}

if (empty($items)) {
    echo "<script>alert('Belum ada pesanan.'); window.location='index.php';</script>";
    exit;
}

$total_semua = array_sum(array_column($items, 'total'));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Pembelian - Azta Es Cream</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Library untuk konversi HTML ke gambar -->
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
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
            padding: 30px 10px;
            min-height: 100vh;
        }
        
        .invoice-container {
            max-width: 900px;
            margin: auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.15);
            overflow: hidden;
            position: relative;
        }
        
        .invoice-header {
            background: linear-gradient(135deg, var(--accent), var(--primary));
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .invoice-header::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        
        .invoice-header::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -30px;
            width: 150px;
            height: 150px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        
        .invoice-logo {
            width: 100px;
            margin-bottom: 20px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
        }
        
        .invoice-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 2;
        }
        
        .invoice-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }
        
        .invoice-badge {
            display: inline-block;
            background: white;
            color: var(--accent);
            padding: 8px 25px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            position: relative;
            z-index: 2;
        }
        
        .invoice-body {
            padding: 40px;
        }
        
        .section-title {
            color: var(--dark);
            border-bottom: 2px solid var(--secondary);
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 10px;
            font-size: 1.5rem;
        }
        
        .invoice-details {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .detail-card {
            flex: 1;
            min-width: 250px;
            background: var(--light);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        
        .detail-card h6 {
            color: var(--accent);
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .product-item {
            display: flex;
            padding: 20px 0;
            border-bottom: 1px dashed #eee;
            transition: all 0.3s ease;
        }
        
        .product-item:hover {
            background: rgba(255, 194, 249, 0.1);
            transform: translateX(5px);
        }
        
        .product-img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            border-radius: 12px;
            margin-right: 20px;
            background: white;
            padding: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        
        .product-info {
            flex: 1;
        }
        
        .product-name {
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
        }
        
        .product-price {
            color: #666;
        }
        
        .product-quantity {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        
        .quantity-badge {
            background: var(--accent);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .product-subtotal {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--accent);
            min-width: 150px;
            text-align: right;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .total-section {
            background: linear-gradient(135deg, var(--light), white);
            border-radius: 15px;
            padding: 25px;
            margin-top: 30px;
            text-align: right;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        
        .total-label {
            font-size: 1.2rem;
            color: var(--dark);
            font-weight: 600;
        }
        
        .total-amount {
            font-size: 2rem;
            font-weight: 800;
            color: var(--accent);
            margin-top: 5px;
        }
        
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--accent), var(--primary));
            color: white;
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 6px 15px rgba(179, 0, 160, 0.4);
            display: flex;
            align-items: center;
        }
        
        .btn-primary-custom:hover {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(179, 0, 160, 0.5);
            color: white;
        }
        
        .btn-outline-custom {
            background: white;
            color: var(--accent);
            border: 2px solid var(--accent);
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 700;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .btn-outline-custom:hover {
            background: var(--light);
            transform: translateY(-3px);
            color: var(--accent);
        }
        
        .invoice-footer {
            background: var(--dark);
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 0.9rem;
        }
        
        .status-badge {
            font-size: 1.1rem;
            padding: 8px 20px;
            border-radius: 50px;
            display: inline-block;
            font-weight: 700;
        }
        
        .status-pending {
            background: linear-gradient(135deg, #ffc107, #ff9800);
            color: #333;
        }
        
        .status-processing {
            background: linear-gradient(135deg, #2196f3, #03a9f4);
            color: white;
        }
        
        .status-delivered {
            background: linear-gradient(135deg, #4caf50, #8bc34a);
            color: white;
        }
        
        .thank-you {
            text-align: center;
            padding: 20px;
            margin-top: 20px;
            font-size: 1.2rem;
            color: var(--accent);
            font-weight: 600;
        }
        
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white;
                padding: 0;
            }
            .invoice-container {
                box-shadow: none;
                border-radius: 0;
            }
        }
        
        @media (max-width: 768px) {
            .invoice-body {
                padding: 25px 15px;
            }
            .product-item {
                flex-direction: column;
            }
            .product-subtotal {
                text-align: left;
                margin-top: 15px;
            }
        }
        
        /* Modal untuk preview gambar */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            display: none;
        }
        
        .modal-content {
            background: white;
            border-radius: 15px;
            padding: 20px;
            max-width: 90%;
            max-height: 90%;
            overflow: auto;
            text-align: center;
        }
        
        .modal-content img {
            max-width: 100%;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        
        .modal-actions {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .modal-actions button {
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
        }
        
        .btn-whatsapp {
            background: linear-gradient(135deg, #25D366, #128C7E);
            color: white;
            border: none;
        }
        
        .btn-download {
            background: linear-gradient(135deg, var(--accent), var(--primary));
            color: white;
            border: none;
        }
        
        .btn-close-modal {
            background: #f0f0f0;
            color: #333;
            border: 1px solid #ddd;
        }
        
        .loading-spinner {
            display: none;
            text-align: center;
            padding: 20px;
        }
        
        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border-left-color: var(--accent);
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<div class="invoice-container" id="invoice-to-capture">
    <div class="invoice-header">
        <img src="../assets/img/logo.png" alt="Logo" class="invoice-logo">
        <h1 class="invoice-title">Nota Pembelian</h1>
        <p class="invoice-subtitle">Azta Es Cream - Es Krim Terlezat di Bontang</p>
        <div class="invoice-badge">ID Pesanan: #<?= strtoupper(substr(md5($items[0]['id_checkout']), 0, 8)); ?></div>
    </div>
    
    <div class="invoice-body">
        <!-- Informasi Pesanan -->
        <h4 class="section-title"><i class="fas fa-receipt"></i> Detail Pesanan</h4>
        <div class="invoice-details">
            <div class="detail-card">
                <h6><i class="fas fa-calendar-alt me-2"></i> Tanggal Pemesanan</h6>
                <p><?= date('d F Y H:i', strtotime($items[0]['tanggal_checkout'])); ?></p>
            </div>
            <div class="detail-card">
                <h6><i class="fas fa-truck me-2"></i> Tanggal Pengantaran</h6>
                <p><?= date('d F Y', strtotime($items[0]['tanggal_kirim'])); ?></p>
            </div>
            <div class="detail-card">
                <h6><i class="fas fa-credit-card me-2"></i> Metode Pembayaran</h6>
                <p><?= $items[0]['metode_pembayaran']; ?></p>
            </div>
            <div class="detail-card">
                <h6><i class="fas fa-map-marker-alt me-2"></i> Alamat Pengantaran</h6>
                <p><?= nl2br(htmlspecialchars($items[0]['alamat'])); ?></p>
            </div>
        </div>
        
        <!-- Status Pesanan -->
        <div class="text-center mb-4">
            <h5>Status Pesanan</h5>
            <?php
            $statusClass = 'status-pending';
            if ($items[0]['status'] == 'diproses') $statusClass = 'status-processing';
            if ($items[0]['status'] == 'dikirim') $statusClass = 'status-delivered';
            ?>
            <div class="status-badge <?= $statusClass; ?>">
                <i class="fas fa-circle-notch fa-spin me-2"></i> <?= ucfirst($items[0]['status']); ?>
            </div>
        </div>
        
        <!-- Daftar Produk -->
        <h4 class="section-title"><i class="fas fa-ice-cream"></i> Produk Dipesan</h4>
        <div class="products-list">
            <?php foreach ($items as $item): ?>
            <div class="product-item">
                <img src="../assets/img/<?= $item['gambar']; ?>" alt="<?= $item['nama_produk']; ?>" class="product-img">
                <div class="product-info">
                    <h5 class="product-name"><?= $item['nama_produk']; ?></h5>
                    <p class="product-price">Harga Satuan: Rp <?= number_format($item['harga']); ?></p>
                    <div class="product-quantity">
                        <span class="quantity-badge"><?= $item['jumlah']; ?> pcs</span>
                    </div>
                </div>
                <div class="product-subtotal">
                    <span>Subtotal</span>
                    <span>Rp <?= number_format($item['total']); ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Total Pembayaran -->
        <div class="total-section">
            <div class="total-label">Total Pembayaran</div>
            <div class="total-amount">Rp <?= number_format($total_semua); ?></div>
        </div>
        
        <div class="thank-you">
            <i class="fas fa-heart me-2" style="color: var(--accent);"></i> Terima kasih telah berbelanja di Azta Es Cream!
        </div>
        
        <!-- Tombol Aksi -->
        <div class="action-buttons no-print">
            <a href="index.php" class="btn btn-primary-custom">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Produk
            </a>
            <button onclick="window.print()" class="btn btn-outline-custom">
                <i class="fas fa-print me-2"></i> Cetak Nota
            </button>
            <button id="share-whatsapp" class="btn btn-primary-custom">
                <i class="fab fa-whatsapp me-2"></i> Bagikan via WhatsApp
            </button>
        </div>
    </div>
    
    <div class="invoice-footer">
        <p>Jl. Es Krim Manis No. 123, Bontang | Telp: 0823-5207-4484</p>
        <p>Email: admin@aztaescream.com | Website: www.aztaescream.com</p>
        <p class="mb-0">© 2025 Azta Es Cream. All rights reserved.</p>
    </div>
</div>

<!-- Modal untuk preview gambar -->
<div class="modal-overlay" id="image-modal">
    <div class="modal-content">
        <h4>Preview Nota untuk WhatsApp</h4>
        <div class="loading-spinner" id="loading-spinner">
            <div class="spinner"></div>
            <p>Mengonversi nota ke gambar...</p>
        </div>
        <img id="invoice-image" src="" alt="Nota Pembelian" style="display:none;">
        <div class="modal-actions" id="modal-actions" style="display:none;">
            <button id="send-whatsapp" class="btn-whatsapp">
                <i class="fab fa-whatsapp me-2"></i> Kirim via WhatsApp
            </button>
            <button id="download-invoice" class="btn-download">
                <i class="fas fa-download me-2"></i> Unduh Gambar
            </button>
            <button id="close-modal" class="btn-close-modal">
                <i class="fas fa-times me-2"></i> Tutup
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Fungsi untuk mengirim gambar ke WhatsApp
    function sendToWhatsApp(imageData) {
        try {
            // Simpan gambar ke localStorage untuk digunakan di WhatsApp
            localStorage.setItem('whatsapp_invoice', imageData);
            
            // Buat URL WhatsApp dengan parameter teks
            const message = encodeURIComponent('Lihat nota pembelian saya di Azta Es Cream!');
            const whatsappUrl = `whatsapp://send?text=${message}`;
            
            // Buka WhatsApp
            window.location.href = whatsappUrl;
            
            // Setelah 2 detik, hapus gambar dari localStorage
            setTimeout(() => {
                localStorage.removeItem('whatsapp_invoice');
            }, 2000);
            
        } catch (error) {
            console.error('Error sending to WhatsApp:', error);
            alert('Terjadi kesalahan saat membuka WhatsApp. Pastikan WhatsApp terinstal di perangkat Anda.');
        }
    }

    // Animasi untuk elemen saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Animasi untuk item produk
        const productItems = document.querySelectorAll('.product-item');
        productItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateX(-20px)';
            
            setTimeout(() => {
                item.style.transition = 'all 0.6s ease';
                item.style.opacity = '1';
                item.style.transform = 'translateX(0)';
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
        
        // Fungsi untuk menangani pembagian ke WhatsApp
        document.getElementById('share-whatsapp').addEventListener('click', function() {
            // Tampilkan modal
            const modal = document.getElementById('image-modal');
            modal.style.display = 'flex';
            
            // Tampilkan loading spinner
            document.getElementById('loading-spinner').style.display = 'block';
            document.getElementById('invoice-image').style.display = 'none';
            document.getElementById('modal-actions').style.display = 'none';
            
            // Konversi HTML ke gambar menggunakan html2canvas
            html2canvas(document.getElementById('invoice-to-capture'), {
                scale: 2, // Kualitas lebih tinggi
                useCORS: true,
                logging: false,
                backgroundColor: "#ffffff"
            }).then(canvas => {
                // Simpan gambar ke variabel global
                window.invoiceCanvas = canvas;
                const imageData = canvas.toDataURL('image/png');
                
                // Tampilkan gambar di modal
                document.getElementById('invoice-image').src = imageData;
                document.getElementById('loading-spinner').style.display = 'none';
                document.getElementById('invoice-image').style.display = 'block';
                document.getElementById('modal-actions').style.display = 'flex';
                
            }).catch(error => {
                console.error('Error generating image:', error);
                alert('Gagal membuat gambar nota. Silakan coba lagi.');
                document.getElementById('loading-spinner').style.display = 'none';
                modal.style.display = 'none';
            });
        });
        
        // Fungsi untuk mengunduh gambar
        document.getElementById('download-invoice').addEventListener('click', function() {
            if (window.invoiceCanvas) {
                const link = document.createElement('a');
                link.href = window.invoiceCanvas.toDataURL('image/png');
                link.download = 'nota-azta-escream-' + new Date().getTime() + '.png';
                link.click();
            }
        });
        
        // Fungsi untuk mengirim ke WhatsApp
        document.getElementById('send-whatsapp').addEventListener('click', function() {
            if (window.invoiceCanvas) {
                const imageData = window.invoiceCanvas.toDataURL('image/png');
                sendToWhatsApp(imageData);
            }
        });
        
        // Tutup modal
        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('image-modal').style.display = 'none';
        });
        
        // Tutup modal jika klik di luar konten modal
        document.getElementById('image-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.style.display = 'none';
            }
        });
    });
</script>

</body>
</html>