# 📦 Panduan Instalasi TirtoPesal

Berikut langkah-langkah detail untuk menjalankan aplikasi pemesanan travel **TirtoPesal** di server lokal.

---

## 1. Clone atau Unduh Project

```bash
git https://github.com/pesal21/Project_UAS_PemrogramanWeb_202312013.git

Atau unduh ZIP dan ekstrak ke:
- htdocs (XAMPP) atau
- www (Laragon)
```

## 2. Buat Database dan Import

```bash
- Buka http://localhost/phpmyadmin
- Buat database baru: tirtopesal
- Klik Import, pilih file:
            /sql/tirtopesal.sql
```

## 3. Konfigurasi Koneksi Database
Edit file ini:
```bash
/src/includes/koneksi.php
```
Lalu sesuaikan kredensial:
```php
$host = "localhost";
$user = "root";
$pass = "pesal";  // ganti jika tidak kosong
$db   = "tirtopesal";
```

## 4. Jalankan Aplikasi
Buka browser:
```bash
http://localhost/tirtopesal/src/
```

## 5. Akun Default

|   Role    | Username | Password |
|-----------|----------|----------|
|   Admin   |  pesal   | admin123 |
| Pelanggan |  wenka   | wenka123 |

## 6. Fitur Khusus

```bash
- Sistem pembayaran mendukung:
-- Cash
-- Transfer / QRIS (upload bukti)
- Fitur cetak tiket otomatis
- Ulasan dari pelanggan
- Log aktivitas pengguna
- Dark mode dengan Bootstrap 5
```

## 7. Troubleshooting

```bash
- Jika halaman kosong → cek koneksi database
- Jika error upload → pastikan folder /uploads memiliki izin tulis (CHMOD 755)
- Untuk PDF Export: Tambahkan ekstensi dompdf jika ingin fitur ekspor (opsional)
```

## 8. Kontak Developer

```yaml
Nama    : Faizal Darmawan
NIM     : 202312013
Proyek  : UAS Pemrograman Web
Kelas   : Teknik Informatika – Pagi
```


