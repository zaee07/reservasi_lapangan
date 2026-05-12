# Dokumentasi Aplikasi Kasir (POS System)

## Deskripsi Proyek

Aplikasi ini adalah sistem Point of Sale (POS) atau sistem kasir yang dibangun menggunakan framework CodeIgniter 3. Aplikasi ini dirancang untuk mengelola transaksi penjualan, inventori produk, dan pelaporan keuangan.

## Teknologi yang Digunakan

- PHP (versi 5.6 atau lebih baru maks versi 8.0)
- CodeIgniter 3
- MySQL Database
- JavaScript
- CSS
- Libraries:
  - DomPDF (untuk generate laporan PDF)
  - SweetAlert2 (untuk notifikasi)

## Struktur Aplikasi

### Controllers

1. `Dashboard.php`

   - Menampilkan halaman dashboard utama
   - Menampilkan ringkasan data seperti:
     - Total barang
     - Stok minimal
     - Transaksi hari ini
     - Pendapatan (hari ini, bulan ini, tahun ini)

2. `Pos.php`

   - Menangani operasi point of sale
   - Proses transaksi penjualan

3. `Produk.php`

   - Manajemen data produk
   - CRUD operasi untuk produk

4. `Transaksi.php`
   - Pengelolaan data transaksi
   - Riwayat transaksi

### Models

1. `DetailTransaksi_model.php`

   - Model untuk detail setiap transaksi

2. `Produk_model.php`

   - Model untuk manajemen data produk
   - Fungsi untuk cek stok minimal

3. `Transaksi_model.php`
   - Model untuk transaksi
   - Perhitungan pendapatan (harian, bulanan, tahunan)

### Views

Terdapat beberapa folder view utama:

- `templates/` - Template dasar aplikasi
- `barang/` - View untuk manajemen produk
- `transaksi/` - View untuk transaksi
- `dashboard.php` - Halaman dashboard utama

## Fitur Aplikasi

1. Dashboard
   - Total produk
   - Penjualan hari ini
   - Penjualan bulan ini
   - Transaksi hari ini
   - Peringatan stok minimal
2. Manajemen Produk

   - Tambah produk baru
   - Edit produk
   - Hapus produk
   - Monitoring stok

3. Transaksi

   - Proses penjualan
   - Riwayat transaksi
   - Detail transaksi

4. Laporan

   - Laporan penjualan
   - Laporan pendapatan
   - Export data

## Fitur yang Direncanakan

Berdasarkan kode yang ada, beberapa fitur yang masih dalam pengembangan:

- Download data dalam format XLS
- Multi Satuan
- Grafik transaksi

## Persyaratan Server

- PHP 5.6 atau lebih baru \*maks php 8.0
- Web Server (Apache/Nginx)
- MySQL Database
- PHP Extensions:
  - GD Library (untuk manipulasi gambar)
  - DOM PDF (untuk generate PDF)

## Struktur Assets

```
assets/
├── css/
├── js/
├── img/
└── vendor/
```

## Instalasi

1. Clone repository ini ke direktori web server
2. Import file database `PKL.sql`
3. Konfigurasi database di `application/config/database.php`
4. Konfigurasi base URL di `application/config/config.php`
5. Pastikan folder `application/cache` dan `application/logs` memiliki permission write
6. Akses aplikasi melalui web browser

## Keamanan

- Implementasi CSRF protection
- XSS filtering
- SQL injection prevention (menggunakan Query Builder CI)
- Input validation

## Pemeliharaan

- Backup database secara berkala
- Monitor log sistem di `application/logs`
- Periksa stok produk secara rutin
- Update sistem keamanan
