# 🍦 Azta Es Cream - Aplikasi Pemesanan Es Krim Online

Azta Es Cream adalah aplikasi web berbasis PHP native dan MySQL untuk sistem pemesanan es krim online. Proyek ini dikembangkan sebagai tugas UAS mata kuliah **Pemrograman Web** di STITEK Bontang.

---

## 🧾 Daftar Isi

- [Fitur Aplikasi](#fitur-aplikasi)
- [Struktur Folder](#struktur-folder)
- [Prasyarat](#prasyarat)
- [Instalasi Cepat](#instalasi-cepat)
- [Link Aplikasi & Video](#link-aplikasi--video)
- [Fitur Detail Per Role](#fitur-detail-per-role)
- [Identitas Mahasiswa](#identitas-mahasiswa)
- [Dokumentasi Tambahan](#dokumentasi-tambahan)
- [Lisensi](#lisensi)

---

## 🚀 Fitur Aplikasi

- Autentikasi login (admin & pelanggan)
- CRUD produk, kategori, testimoni, pembayaran, pengiriman, user (admin)
- Pembelian langsung atau melalui keranjang
- Checkout dan cetak nota otomatis
- Pelanggan dapat memberikan testimoni jika sudah pernah membeli
- Riwayat transaksi pelanggan
- Log aktivitas pengguna
- Responsive UI berbasis Bootstrap 5
- Layout dan warna bertema es krim yang manis

---

## 📁 Struktur Folder

```bash
AZTAICE_CREAM/
├── admin/
│   ├── aktivitas/
│   ├── laporan/
│   ├── pembayaran/
│   ├── pengaturan/
│   ├── pengiriman/
│   ├── produk/
│   ├── testimoni/
│   ├── transaksi/
│   ├── users/
│   └── dashboard.php
├── assets/
│   └── img/
├── config/
│   └── koneksi.php
├── pelanggan/
│   ├── index.php
│   ├── checkout_form.php
│   ├── checkout_multi.php
│   ├── keranjang.php
│   ├── nota.php
├── login.php
├── login_pelanggan.php
├── logout.php
├── logout_pelanggan.php
├── register.php
└── index.php
```

---

## 📦 Prasyarat

- PHP versi 7.4 atau lebih tinggi
- MySQL versi 5.7 atau lebih tinggi
- Web server lokal (XAMPP, Laragon, dsb.)
- Git (opsional)

---

## ⚙️ Instalasi Cepat

1. **Clone repositori**
```bash
git clone https://github.com/username/azta-ice-cream.git
```

2. **Import database**
```bash
- Buka phpMyAdmin
- Buat database baru, misalnya azta_ice_cream
- Import file sql/azta_ice_cream.sql
```

3. **Konfigurasi koneksi database**
- Edit file: `config/koneksi.php`
- Sesuaikan:
```php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "azta_ice_cream";
```

4. **Jalankan aplikasi di browser**
```bash
http://localhost/azta_ice_cream/index.php
```

---

## 🌐 Link Aplikasi & Video

- 🔗 Hosting (jika ada): https://aztaescream.my.id
- 🎥 Video Demo (YouTube): https://youtu.be/link_video

---

## 👥 Fitur Detail Per Role

### 👩‍🍳 Admin
```bash
- Login & logout
- Kelola produk, kategori, testimoni, pembayaran, pengiriman, user
- Lihat laporan dan aktivitas
```

### 🛒 Pelanggan
```bash
- Registrasi & login
- Pesan es krim langsung atau via keranjang
- Tentukan tanggal pengiriman & metode bayar (COD, Transfer, QRIS)
- Cetak nota & kirim testimoni
```

---

## 🎓 Identitas Mahasiswa

```yaml
Nama    : Vidi Maulidiyah Sari
NIM     : 202312XXX
Proyek  : UAS Pemrograman Web
Kelas   : Teknik Informatika – Pagi
Dosen   : Turahyo, ST., M.Eng.
```
# 🗃 Struktur Database & Relasi Tabel — Azta Es Cream

Database aplikasi **Azta Es Cream** dirancang untuk mendukung sistem pemesanan es krim berbasis web. Sistem mencakup manajemen produk, keranjang belanja, transaksi, pengiriman, pembayaran, dan testimoni.

---

## 📄 1. `users`

Menyimpan data akun pelanggan dan admin.

| Kolom        | Tipe Data  | Keterangan                  |
|--------------|------------|-----------------------------|
| id_user      | INT (PK)   | ID unik pengguna            |
| nama         | VARCHAR    | Nama lengkap                |
| email        | VARCHAR    | Alamat email unik           |
| password     | VARCHAR    | Password terenkripsi        |
| role         | ENUM       | `admin` atau `pelanggan`    |

---

## 📄 2. `produk`

Menyimpan daftar produk es krim.

| Kolom         | Tipe Data  | Keterangan                  |
|---------------|------------|-----------------------------|
| id_produk     | INT (PK)   | ID produk                   |
| nama_produk   | VARCHAR    | Nama produk es krim         |
| harga         | INT        | Harga produk                |
| gambar        | VARCHAR    | Nama file gambar            |
| id_kategori   | INT (FK)   | Kategori produk             |

---

## 📄 3. `kategori`

Kategori atau jenis produk es krim.

| Kolom         | Tipe Data  | Keterangan           |
|---------------|------------|----------------------|
| id_kategori   | INT (PK)   | ID kategori          |
| nama_kategori | VARCHAR    | Nama kategori produk |

---

## 📄 4. `keranjang`

Data belanja pelanggan sebelum checkout.

| Kolom         | Tipe Data  | Keterangan                   |
|---------------|------------|------------------------------|
| id_keranjang  | INT (PK)   | ID item keranjang            |
| id_user       | INT (FK)   | Pelanggan                    |
| id_produk     | INT (FK)   | Produk                       |
| jumlah        | INT        | Jumlah barang                |

---

## 📄 5. `checkout`

Data pemesanan setelah pelanggan melakukan checkout.

| Kolom             | Tipe Data  | Keterangan                            |
|-------------------|------------|---------------------------------------|
| id_checkout       | INT (PK)   | ID checkout                           |
| id_user           | INT (FK)   | Pelanggan                             |
| id_produk         | INT (FK)   | Produk yang dibeli                    |
| jumlah            | INT        | Jumlah produk                         |
| total             | INT        | Total harga (harga * jumlah)          |
| alamat            | TEXT       | Alamat pengiriman                     |
| tanggal_kirim     | DATE       | Tanggal pengiriman                    |
| metode_pembayaran | ENUM       | COD / Transfer / QRIS                 |
| status            | ENUM       | Menunggu / Lunas / Dibatalkan         |
| tanggal_checkout  | DATETIME   | Waktu pesanan dibuat                  |

---

## 📄 6. `pengiriman`

Log pengiriman pesanan ke pelanggan.

| Kolom             | Tipe Data  | Keterangan                     |
|-------------------|------------|--------------------------------|
| id_pengiriman     | INT (PK)   | ID pengiriman                  |
| id_checkout       | INT (FK)   | ID pesanan                     |
| kurir             | VARCHAR    | Nama kurir                     |
| status_pengiriman | ENUM       | Dalam Proses / Dikirim / Selesai |
| waktu_kirim       | DATETIME   | Waktu pengiriman dilakukan     |

---

## 📄 7. `pembayaran`

Menyimpan bukti transfer untuk metode non-COD.

| Kolom            | Tipe Data  | Keterangan                      |
|------------------|------------|---------------------------------|
| id_pembayaran    | INT (PK)   | ID pembayaran                   |
| id_checkout      | INT (FK)   | ID pesanan                      |
| bukti            | VARCHAR    | File bukti pembayaran (gambar) |
| status_verifikasi| ENUM       | Terverifikasi / Belum           |

---

## 📄 8. `testimoni`

Testimoni pelanggan terhadap produk es krim.

| Kolom        | Tipe Data  | Keterangan                       |
|--------------|------------|----------------------------------|
| id_testimoni | INT (PK)   | ID testimoni                     |
| id_user      | INT (FK)   | Pelanggan                        |
| id_produk    | INT (FK)   | Produk                           |
| pesan        | TEXT       | Isi testimoni                    |
| tanggal      | DATE       | Tanggal penulisan testimoni      |

---

## 🔁 Relasi Antar Tabel

- 1 user → banyak checkout (1:N)
- 1 user → banyak item keranjang (1:N)
- 1 produk → banyak testimoni (1:N)
- 1 checkout → 1 pengiriman (1:1)
- 1 checkout → 1 pembayaran (1:1)
- 1 kategori → banyak produk (1:N)

---

> Struktur ini mendukung sistem transaksi dan pengalaman pelanggan yang efisien pada aplikasi pemesanan es krim Azta Es Cream.


---

## 📄 Dokumentasi Tambahan

- 🧩 Database SQL: tersedia di folder `sql/azta_ice_cream.sql`
- 🎥 Video penjelasan: link YouTube telah disediakan
- 📸 Screenshot UI: disertakan dalam laporan atau dokumentasi

---

## 📢 Lisensi

Proyek ini dikembangkan **hanya untuk keperluan akademik**. Dilarang dikomersialkan tanpa izin.

