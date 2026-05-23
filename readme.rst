# Sistem Reservasi Lapangan Badminton GOR Harmoni

Sistem Reservasi Lapangan Badminton GOR Harmoni adalah aplikasi berbasis web yang digunakan untuk mengelola reservasi lapangan badminton secara digital dengan dukungan multi cabang, multi lapangan, multi role, serta pembayaran QRIS.

Project ini dibuat menggunakan framework CodeIgniter 3 dan dirancang untuk mempermudah pengelolaan reservasi, jadwal lapangan, transaksi pembayaran, serta manajemen pengguna pada setiap cabang.

# Features

* Multi Role User
* Multi Cabang
* Multi Lapangan
* Reservasi Lapangan
* Payment QRIS (Pakasir)
* Cetak Invoice PDF (DOMPDF)
* QR Code Tiket / Reservasi
* Kamera untuk scan/verifikasi
* Dashboard Statistik
* Manajemen Jadwal Lapangan
* Manajemen Member
* Riwayat Reservasi
* Validasi Booking
* Sistem Login dan Hak Akses

# Roles

## Owner

* Mengelola seluruh cabang
* Mengelola admin cabang
* Monitoring reservasi seluruh cabang
* Monitoring transaksi
* Melihat laporan

## Admin Cabang

* Mengelola lapangan pada cabang masing-masing
* Mengelola petugas reservasi
* Melihat reservasi cabang
* Mengatur jadwal lapangan

## Petugas Reservasi

* Input reservasi
* Verifikasi pembayaran
* Scan QR reservasi
* Check-in member

## Member

* Melakukan booking lapangan
* Melihat jadwal lapangan
* Melihat riwayat reservasi
* Melakukan pembayaran QRIS

# Technology Stack

## Backend

* PHP
* CodeIgniter 3
* MySQL / MariaDB

## Frontend

* Bootstrap
* jQuery
* HTML5
* CSS3
* JavaScript

## Library & Integration

* DOMPDF
* QRCode Generator
* Kamera / Webcam Scanner
* Pakasir QRIS Payment

# Project Structure

::

```
application/
├── controllers/
├── models/
├── views/
├── libraries/
├── helpers/
└── config/

assets/
├── css/
├── js/
├── images/
└── uploads/

system/
vendor/
```

# Installation

1. Clone Repository

---

::

```
git clone https://github.com/username/repository-name.git
```

## 2. Masuk ke Folder Project

::

```
cd repository-name
```

## 3. Pindahkan Project ke Web Server

Contoh:

* XAMPP : `htdocs`
* Laragon : `www`
* Linux : `/var/www/html`

4. Import Database

---

* Buat database baru di MySQL / MariaDB
* Import file SQL ke database

5. Konfigurasi Database

---

Edit file:

::

```
application/config/database.php
```

Sesuaikan:

::

```
'hostname' => 'localhost',
'username' => 'root',
'password' => '',
'database' => 'gor_harmoni',
```

## 6. Konfigurasi Base URL

Edit file:

::

```
application/config/config.php
```

::

```
$config['base_url'] = 'http://localhost/gor-harmoni/';
```

## 7. Jalankan Project

Buka browser:

::

```
http://localhost/gor-harmoni/
```

# QRIS Payment Integration

Project ini mendukung integrasi pembayaran QRIS menggunakan layanan Pakasir.

Fitur pembayaran:

* Generate QRIS otomatis
* Verifikasi pembayaran
* Status transaksi realtime
* Riwayat pembayaran

# Camera & QR Verification

Sistem mendukung penggunaan kamera/webcam untuk:

* Scan QR reservasi
* Validasi tiket booking
* Check-in member

# Default Roles Access

+-------------------+-------------------------------+
| Role              | Hak Akses                     |
+===================+===============================+
| Owner             | Semua akses sistem            |
+-------------------+-------------------------------+
| Admin Cabang      | Kelola cabang masing-masing   |
+-------------------+-------------------------------+
| Petugas Reservasi | Reservasi dan verifikasi      |
+-------------------+-------------------------------+
| Member            | Booking lapangan              |
+-------------------+-------------------------------+

# Screenshots

Tambahkan screenshot project pada folder:

::

```
screenshots/
```

Contoh:

::

```
screenshots/dashboard.png
screenshots/booking.png
screenshots/payment.png
```

Lalu tampilkan pada README.

Example:

::

```
.. image:: screenshots/dashboard.png
   :alt: Dashboard
   :width: 800px
```

# Future Development

* Notifikasi WhatsApp
* Mobile App Android
* Membership Subscription
* Voucher dan Promo
* Integrasi Midtrans
* Export Laporan Excel
* Auto Check-In

# Contributing

Pull request dan kontribusi sangat terbuka untuk pengembangan project ini.

# License

This project is licensed under the MIT License.

# Author

Muhammad Ihza Sofyansyah

* Universitas Peradaban
* Sistem Informasi
* Web Developer
