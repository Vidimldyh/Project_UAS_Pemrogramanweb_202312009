# 📦 Panduan Instalasi Azta Es Cream

Berikut langkah-langkah detail untuk menjalankan aplikasi pemesanan es krim **Azta Es Cream** di server lokal (XAMPP/Laragon).

---

## 1. Clone atau Unduh Project

```bash
git clone https://github.com/[username]/AztaEsCream.git



Unduh file ZIP, lalu ekstrak ke folder:
- htdocs (untuk XAMPP)
- www (untuk Laragon)
```

---

## 2. Buat Database dan Import

```bash
1. Buka browser: http://localhost/phpmyadmin
2. Buat database baru: azta_es_cream
3. Klik tab Import → Pilih file: /sql/azta_es_cream.sql
4. Klik Go
```

---

## 3. Konfigurasi Koneksi Database

Edit file berikut:

```php
/config/koneksi.php
```

Ganti sesuai environment:

```php
$host = "localhost";
$user = "root";
$pass = "";           // isi password jika 
$db   = "azta_es_cream";
```

---

## 4. Jalankan Aplikasi

Buka browser dan akses:

```bash
http://localhost/AztaEsCream/index.php
```

Atau langsung ke halaman login pelanggan:

```bash
http://localhost/AztaEsCream/login_pelanggan.php
```

---

## 5. Akun Default

|   Role    | Username       | Password     |
|-----------|----------------|--------------|
| Admin     | admin@azta.com | admin123     |
| Pelanggan | vidi@mail.com  | 123456       |

---

## 6. Fitur Utama

```bash
✓ Login pelanggan & admin
✓ Checkout dengan tanggal, alamat, dan metode pembayaran
✓ Keranjang belanja
✓ Riwayat transaksi dan nota cetak
✓ Modul testimoni produk
✓ CRUD admin: produk, user, pengiriman, pembayaran, dll
✓ Tampilan modern dengan Bootstrap 5
```

---

## 7. Troubleshooting

```bash
• Halaman putih? → Cek error_log atau aktifkan display_errors di php.ini
• Gambar tidak muncul? → Pastikan file gambar ada di folder /assets/img
• Keranjang tidak menyimpan? → Periksa session_start() di awal file PHP
• SQL error (misal: "Unknown column") → Pastikan struktur database sudah sesuai
```

---

## 8. Kontak Developer

```yaml
Nama    : Siti Vidi Maulidiyah Sari Anas
NIM     : 202312009
Kelas   : Teknik Informatika Pagi
```