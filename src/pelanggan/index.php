<?php
session_start();
include '../config/koneksi.php';

$id_user = $_SESSION['user_id'] ?? 0;
$keyword = $_GET['search'] ?? '';

// Query untuk produk utama
$query = "
    SELECT produk.*, kategori.nama_kategori,
        (SELECT pesan FROM testimoni WHERE id_user = $id_user AND id_produk = produk.id_produk LIMIT 1) AS pesan_testimoni,
        EXISTS (
            SELECT 1 FROM checkout WHERE id_user = $id_user AND id_produk = produk.id_produk
        ) AS sudah_beli
    FROM produk
    JOIN kategori ON produk.id_kategori = kategori.id_kategori
";
if ($keyword) {
    $query .= " WHERE nama_produk LIKE '%$keyword%' OR nama_kategori LIKE '%$keyword%'";
}
$produk = mysqli_query($conn, $query);

$slide_query = "SELECT produk.*, kategori.nama_kategori 
                FROM produk 
                JOIN kategori ON produk.id_kategori = kategori.id_kategori 
                ORDER BY id_produk DESC LIMIT 5";
$slide_products = mysqli_query($conn, $slide_query);

// Daftar gambar khusus untuk slide show
$custom_slides = [
    '../assets/img/slides/slide1.jpg',
    '../assets/img/slides/slide2.jpg',
    '../assets/img/slides/slide3.jpg',
    '../assets/img/slides/slide4.jpg',
    '../assets/img/slides/slide5.jpg'
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Produk - Azta Es Cream</title>
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
            background-attachment: fixed;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: linear-gradient(to right, #e3f2fd, #d1e5ff);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-bottom: 3px solid var(--accent);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--dark) !important;
            display: flex;
            align-items: center;
        }
        
        .navbar-brand img {
            margin-right: 10px;
            transition: transform 0.3s ease;
        }
        
        .navbar-brand:hover img {
            transform: rotate(-10deg);
        }
        
        h3 {
            color: var(--dark);
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            font-weight: 700;
            text-shadow: 1px 1px 2px rgba(255,255,255,0.8);
            position: relative;
            margin-bottom: 2rem;
            text-align: center;
        }
        
        h3:after {
            content: '';
            display: block;
            width: 100px;
            height: 4px;
            background: linear-gradient(to right, transparent, var(--accent), transparent);
            margin: 10px auto 0;
            border-radius: 10px;
        }
        
        /* Slide Show Styles */
        .hero-slider {
            margin-bottom: 40px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            position: relative;
            height: 400px;
        }
        
        .carousel-item {
            height: 400px;
            position: relative;
        }
        
        .carousel-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.7);
        }
        
        .carousel-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 30px;
            background: linear-gradient(transparent, rgba(0,0,0,0.7));
            text-align: left;
        }
        
        .carousel-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }
        
        .carousel-price {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 15px;
        }
        
        .carousel-category {
            background: var(--accent);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            display: inline-block;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }
        
        .carousel-control-prev, .carousel-control-next {
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            margin: 0 20px;
        }
        
        .carousel-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin: 0 5px;
            background-color: rgba(255,255,255,0.5);
            border: none;
        }
        
        .carousel-indicators .active {
            background-color: var(--accent);
        }
        
        .card-img-top {
            height: 220px;
            object-fit: contain;
            padding: 15px;
            transition: transform 0.3s ease;
            background-color: white;
            border-radius: 15px 15px 0 0;
        }
        
        .card {
            background-color: var(--light) !important;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            height: 100%;
            opacity: 1;
            transform: translateY(0);
        }
        
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }
        
        .card:hover .card-img-top {
            transform: scale(1.05);
        }
        
        .card-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
        }
        
        .card-title {
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .price-tag {
            font-weight: 700;
            color: var(--accent);
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }
        
        .btn-purple {
            background: linear-gradient(to right, var(--accent), #8a0080);
            color: white;
            border: none;
            border-radius: 30px;
            padding: 8px 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(179, 0, 160, 0.3);
        }
        
        .btn-purple:hover {
            background: linear-gradient(to right, #8a0080, var(--accent));
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(179, 0, 160, 0.4);
        }
        
        .btn-outline-primary {
            border-color: var(--accent);
            color: var(--accent);
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background-color: var(--accent);
            color: white;
            transform: translateY(-2px);
        }
        
        .testimonial-section {
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 10px;
            padding: 15px;
            margin-top: 15px;
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid rgba(179, 0, 160, 0.2);
        }
        
        .testimonial-section h6 {
            color: var(--dark);
            font-weight: 700;
            border-bottom: 2px solid var(--secondary);
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        
        .testimonial-item {
            background: white;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .testimonial-form textarea {
            resize: none;
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 10px;
        }
        
        .category-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: linear-gradient(to right, var(--accent), #8a0080);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 10;
            box-shadow: 0 3px 8px rgba(0,0,0,0.2);
        }
        
        .search-box {
            position: relative;
        }
        
        .search-box .form-control {
            border-radius: 30px;
            padding-left: 40px;
            border: 2px solid var(--accent);
        }
        
        .search-box i {
            position: absolute;
            left: 15px;
            top: 12px;
            color: var(--accent);
        }
        
        .cart-btn, .logout-btn {
            border-radius: 30px !important;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .cart-btn:hover, .logout-btn:hover {
            transform: translateY(-3px);
        }
        
        .footer {
            background: linear-gradient(to right, var(--dark), #330030);
            color: white;
            padding: 25px 0;
            margin-top: 50px;
            border-top: 3px solid var(--secondary);
        }
        
        .footer a {
            color: var(--secondary);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer a:hover {
            color: white;
            text-decoration: underline;
        }
        
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            margin: 30px 0;
        }
        
        .empty-state i {
            font-size: 5rem;
            color: var(--accent);
            margin-bottom: 20px;
        }
        
        .empty-state h4 {
            color: var(--dark);
            margin-bottom: 15px;
        }
        
        /* Animasi untuk kartu */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .product-card {
            animation: fadeIn 0.5s ease forwards;
        }
        
        .product-card:nth-child(1) { animation-delay: 0.1s; }
        .product-card:nth-child(2) { animation-delay: 0.2s; }
        .product-card:nth-child(3) { animation-delay: 0.3s; }
        .product-card:nth-child(4) { animation-delay: 0.4s; }
        .product-card:nth-child(5) { animation-delay: 0.5s; }
        .product-card:nth-child(6) { animation-delay: 0.6s; }
        
        /* Animasi untuk slide show */
        @keyframes slideIn {
            from { transform: translateX(50px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        .carousel-item.active .carousel-caption {
            animation: slideIn 0.8s ease forwards;
        }
        
    </style>
</head>
<body>

<!-- ✅ NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">
      <img src="../assets/img/logo.png" alt="Logo" width="60">
      <span>Azta Es Cream</span>
    </a>

    <!-- Hamburger toggle -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAzta">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar Content -->
    <div class="collapse navbar-collapse" id="navbarAzta">
      <form class="d-flex w-100 my-2 my-lg-0 me-lg-3 search-box" method="get">
        <i class="fas fa-search"></i>
        <input class="form-control me-2" type="search" name="search" placeholder="Cari produk..." value="<?= htmlspecialchars($keyword); ?>">
        <button class="btn btn-purple" type="submit">Cari</button>
      </form>

      <div class="d-flex flex-column flex-lg-row gap-2 mt-3 mt-lg-0">
        <a href="keranjang.php" class="btn btn-outline-primary d-flex align-items-center justify-content-center cart-btn">
          <i class="fas fa-shopping-cart me-2"></i> Keranjang
        </a>
        <a href="../logout_pelanggan.php" class="btn btn-danger logout-btn">
          <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
      </div>
    </div>
  </div>
</nav>

<!-- ✅ SLIDE SHOW PRODUK -->
<div class="container mt-4">
    <div id="productCarousel" class="carousel slide hero-slider" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?php 
            $slide_count = mysqli_num_rows($slide_products);
            for ($i = 0; $i < $slide_count; $i++) {
                echo '<button type="button" data-bs-target="#productCarousel" data-bs-slide-to="'.$i.'"';
                if ($i === 0) echo ' class="active"';
                echo '></button>';
            }
            ?>
        </div>
        <div class="carousel-inner">
            <?php 
            $active = true;
            $index = 0;
            while ($slide = mysqli_fetch_assoc($slide_products)) {
                // Gunakan gambar khusus dari array, jika tidak ada gunakan gambar produk
                $slide_image = isset($custom_slides[$index]) ? $custom_slides[$index] : '../assets/img/'.$slide['gambar'];
            ?>
            <div class="carousel-item <?= $active ? 'active' : '' ?>">
                <img src="<?= $slide_image ?>" class="d-block w-100 carousel-img" alt="<?= $slide['nama_produk']; ?>">
               
            </div>
            <?php 
                $active = false;
                $index++;
            } 
            ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<!-- ✅ KONTEN PRODUK UTAMA -->
<div class="container pb-5">
    <h3 class="mb-4">Daftar Produk Azta Es Cream</h3>
    
    <?php if (mysqli_num_rows($produk) > 0) { ?>
    <div class="row">
        <?php 
        $index = 0;
        while ($p = mysqli_fetch_assoc($produk)) { 
        ?>
        <div class="col-12 col-sm-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm product-card" id="product-<?= $p['id_produk']; ?>">
                <div class="position-relative">
                    <span class="category-badge"><?= $p['nama_kategori']; ?></span>
                    <img src="../assets/img/<?= $p['gambar']; ?>" class="card-img-top" alt="<?= $p['nama_produk']; ?>">
                </div>

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= $p['nama_produk']; ?></h5>
                    <p class="price-tag">Rp <?= number_format($p['harga']); ?></p>

                    <!-- Form Checkout -->
                    <form action="checkout_form.php" method="post" class="mb-2 mt-auto">
                        <input type="hidden" name="id_produk" value="<?= $p['id_produk']; ?>">
                        <div class="mb-2">
                            <label class="fw-medium">Jumlah:</label>
                            <input type="number" name="jumlah" value="1" min="1" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-purple w-100">
                            <i class="fas fa-bolt me-2"></i>Beli Sekarang
                        </button>
                    </form>

                    <!-- Form Masukkan Keranjang -->
                    <form action="tambah_keranjang.php" method="post" class="mt-2">
                        <input type="hidden" name="id_produk" value="<?= $p['id_produk']; ?>">
                        <input type="hidden" name="jumlah" value="1">
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="fas fa-cart-plus me-2"></i>Masukkan ke Keranjang
                        </button>
                    </form>

                    <!-- Testimoni Semua User -->
                    <div class="testimonial-section">
                        <h6><i class="fas fa-comments me-2"></i>Testimoni Pelanggan:</h6>
                        <?php
                        $all_testimoni = mysqli_query($conn, "
                            SELECT t.pesan, u.nama 
                            FROM testimoni t 
                            JOIN users u ON t.id_user = u.id_user 
                            WHERE t.id_produk = {$p['id_produk']}
                            ORDER BY t.id_testimoni DESC
                            LIMIT 3
                        ");
                        if (mysqli_num_rows($all_testimoni) > 0) {
                            while ($t = mysqli_fetch_assoc($all_testimoni)) {
                                echo '<div class="testimonial-item">';
                                echo '<strong>' . htmlspecialchars($t['nama']) . ':</strong><br>';
                                echo '<span class="d-block mt-1">' . nl2br(htmlspecialchars($t['pesan'])) . '</span>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p class="text-muted text-center py-2">Belum ada testimoni</p>';
                        }
                        ?>
                    </div>

                    <!-- Form Kirim Testimoni Jika Pernah Beli -->
                    <?php if ($p['sudah_beli']) { ?>
                    <form action="simpan_testimoni.php" method="post" class="mt-3 testimonial-form">
                        <input type="hidden" name="id_produk" value="<?= $p['id_produk']; ?>">
                        <div class="mb-2">
                            <textarea name="pesan" class="form-control" placeholder="Tulis testimoni Anda..." rows="2" required><?= htmlspecialchars($p['pesan_testimoni'] ?? '') ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="fas fa-paper-plane me-2"></i>Kirim / Update Testimoni
                        </button>
                    </form>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php 
        $index++;
        } 
        ?>
    </div>
    <?php } else { ?>
        <div class="empty-state">
            <i class="fas fa-ice-cream"></i>
            <h4>Produk Tidak Ditemukan</h4>
            <p class="text-muted">Maaf, tidak ada produk yang sesuai dengan pencarian Anda</p>
            <a href="?" class="btn btn-purple mt-2">Lihat Semua Produk</a>
        </div>
    <?php } ?>
</div>

<!-- ✅ FOOTER -->
<footer class="footer">
    <div class="container text-center">
        <p class="mb-2">
            <i class="fas fa-phone-alt me-2"></i>Hubungi Admin: 
            <strong>0823-5207-4484</strong>
        </p>
        <p class="mb-2">
            <i class="fas fa-envelope me-2"></i>
            <a href="mailto:admin@aztaescream.com">admin@aztaescream.com</a>
        </p>
        <p class="mb-2 small"><i class="fas fa-map-marker-alt me-2"></i>Alamat Toko: Jl. Es Krim Manis No. 123, Bontang</p>
        <p class="mb-0 small">© 2025 Azta Es Cream - Es Krim Terlezat di Bontang</p>
    </div>
</footer>

<!-- ✅ Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Animasi untuk tombol
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('button, a.btn');
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
        
        // Animasi hover untuk navbar brand
        const brand = document.querySelector('.navbar-brand');
        if (brand) {
            brand.addEventListener('mouseenter', function() {
                this.querySelector('img').style.transform = 'rotate(-10deg)';
            });
            
            brand.addEventListener('mouseleave', function() {
                this.querySelector('img').style.transform = 'rotate(0)';
            });
        }
        
        // Animasi untuk kartu saat di-scroll
        const productCards = document.querySelectorAll('.product-card');
        
        function animateOnScroll() {
            productCards.forEach(card => {
                const cardTop = card.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;
                
                if (cardTop < windowHeight * 0.9) {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }
            });
        }
        
        // Jalankan saat pertama kali dimuat
        animateOnScroll();
        
        // Jalankan saat di-scroll
        window.addEventListener('scroll', animateOnScroll);
        
        // Auto slide untuk carousel
        const myCarousel = document.getElementById('productCarousel');
        const carousel = new bootstrap.Carousel(myCarousel, {
            interval: 5000, // Ubah slide setiap 5 detik
            wrap: true
        });
        
        // Tambahkan efek animasi saat slide berubah
        myCarousel.addEventListener('slid.bs.carousel', function() {
            const captions = document.querySelectorAll('.carousel-caption');
            captions.forEach(caption => {
                caption.style.animation = 'none';
                setTimeout(() => {
                    caption.style.animation = 'slideIn 0.8s ease forwards';
                }, 10);
            });
        });
    });
</script>

</body>
</html>