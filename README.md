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
git clone https://github.com/Vidimldyh/Project_UAS_Pemrogramanweb_202312009.git
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
# 🗃 Struktur Database & Relasi Tabel — Azta Es Cream

Database aplikasi **Azta Es Cream** mendukung sistem pemesanan es krim online. Terdiri dari 11 tabel utama yang saling terhubung.

---

## 📄 1. `users`
Menyimpan data akun pengguna (admin dan pelanggan).
| Kolom     | Tipe Data | Keterangan                |
|-----------|-----------|---------------------------|
| id_user   | INT (PK)  | ID unik pengguna          |
| nama      | VARCHAR   | Nama lengkap              |
| email     | VARCHAR   | Email unik                |
| password  | VARCHAR   | Password terenkripsi      |
| role      | ENUM      | 'admin' atau 'pelanggan'  |

---

## 📄 2. `produk`
Menyimpan daftar produk es krim.
| Kolom        | Tipe Data | Keterangan         |
|--------------|-----------|--------------------|
| id_produk    | INT (PK)  | ID produk          |
| nama_produk  | VARCHAR   | Nama produk        |
| harga        | INT       | Harga satuan       |
| gambar       | VARCHAR   | Gambar produk      |
| id_kategori  | INT (FK)  | Kategori produk    |

---

## 📄 3. `kategori`
Kategori produk es krim.
| Kolom         | Tipe Data | Keterangan          |
|---------------|-----------|---------------------|
| id_kategori   | INT (PK)  | ID kategori         |
| nama_kategori | VARCHAR   | Nama kategori       |

---

## 📄 4. `keranjang`
Data belanja sebelum checkout.
| Kolom         | Tipe Data | Keterangan          |
|---------------|-----------|---------------------|
| id_keranjang  | INT (PK)  | ID item keranjang   |
| id_user       | INT (FK)  | Pelanggan           |
| id_produk     | INT (FK)  | Produk              |
| jumlah        | INT       | Jumlah dibeli       |

---

## 📄 5. `checkout`
Data pesanan setelah checkout.
| Kolom             | Tipe Data | Keterangan                     |
|-------------------|-----------|--------------------------------|
| id_checkout       | INT (PK)  | ID pesanan                     |
| id_user           | INT (FK)  | Pelanggan                      |
| id_produk         | INT (FK)  | Produk yang dibeli             |
| jumlah            | INT       | Jumlah beli                    |
| total             | INT       | Total bayar                    |
| alamat            | TEXT      | Alamat pengiriman              |
| tanggal_kirim     | DATE      | Tanggal pengiriman             |
| metode_pembayaran | ENUM      | COD / Transfer / QRIS          |
| status            | ENUM      | Menunggu / Lunas / Batal       |
| tanggal_checkout  | DATETIME  | Tanggal pemesanan dibuat       |

---

## 📄 6. `pengiriman`
Status pengiriman pesanan.
| Kolom             | Tipe Data | Keterangan                    |
|-------------------|-----------|-------------------------------|
| id_pengiriman     | INT (PK)  | ID pengiriman                 |
| id_checkout       | INT (FK)  | ID pesanan                    |
| kurir             | VARCHAR   | Nama kurir                    |
| status_pengiriman | ENUM      | Dalam Proses / Dikirim / Selesai |
| waktu_kirim       | DATETIME  | Tanggal pengiriman            |

---

## 📄 7. `pembayaran`
Data bukti pembayaran.
| Kolom             | Tipe Data | Keterangan                     |
|-------------------|-----------|--------------------------------|
| id_pembayaran     | INT (PK)  | ID pembayaran                  |
| id_checkout       | INT (FK)  | ID pesanan                     |
| bukti             | VARCHAR   | Nama file bukti transfer       |
| status_verifikasi | ENUM      | Terverifikasi / Belum          |

---

## 📄 8. `testimoni`
Testimoni pelanggan terhadap produk.
| Kolom        | Tipe Data | Keterangan                |
|--------------|-----------|---------------------------|
| id_testimoni | INT (PK)  | ID testimoni              |
| id_user      | INT (FK)  | Pelanggan                 |
| id_produk    | INT (FK)  | Produk                    |
| pesan        | TEXT      | Isi testimoni             |
| tanggal      | DATE      | Tanggal ditulis           |

---

## 📄 9. `transaksi`
Ringkasan semua transaksi.
| Kolom         | Tipe Data | Keterangan                |
|---------------|-----------|---------------------------|
| id_transaksi  | INT (PK)  | ID transaksi              |
| id_user       | INT (FK)  | Pelanggan                 |
| total_bayar   | INT       | Total semua belanja       |
| tanggal       | DATETIME  | Waktu transaksi           |

---

## 📄 10. `detail_transaksi`
Produk-produk yang dibeli dalam transaksi.
| Kolom            | Tipe Data | Keterangan              |
|------------------|-----------|-------------------------|
| id_detail        | INT (PK)  | ID detail               |
| id_transaksi     | INT (FK)  | ID transaksi            |
| id_produk        | INT (FK)  | Produk yang dibeli      |
| jumlah           | INT       | Jumlah produk           |
| subtotal         | INT       | Harga * jumlah          |

---

## 📄 11. `kontak`
Pesan dari pelanggan (halaman hubungi kami).
| Kolom      | Tipe Data | Keterangan            |
|------------|-----------|-----------------------|
| id_kontak  | INT (PK)  | ID kontak             |
| nama       | VARCHAR   | Nama pengirim         |
| email      | VARCHAR   | Email                 |
| pesan      | TEXT      | Isi pesan             |
| tanggal    | DATETIME  | Tanggal pengiriman    |

---

## 🔁 Relasi Antar Tabel

- `users` → banyak `checkout`, `keranjang`, `testimoni`, `transaksi`
- `checkout` → satu `pengiriman` dan satu `pembayaran`
- `produk` → banyak `keranjang`, `checkout`, `testimoni`, `detail_transaksi`
- `transaksi` → banyak `detail_transaksi`
---

## 📄 Dokumentasi Tambahan

- 🧩 Database SQL: tersedia di folder `sql/azta_ice_cream.sql`
- 🎥 Video penjelasan: link YouTube telah disediakan
- 📸 Screenshot UI: disertakan dalam laporan atau dokumentasi

---

## 🎓 Identitas Mahasiswa

```yaml
Nama    : Siti Vidi Maulidiyah Sari Anas
NIM     : 202312009
Proyek  : UAS Pemrograman Web
Kelas   : Teknik Informatika – Pagi
Dosen   : Ir. Abadi Nugroho. S,KOM.,M.KOM
```
---

## 📢 Lisensi

Proyek ini dikembangkan **hanya untuk keperluan akademik**. Dilarang dikomersialkan tanpa izin.

