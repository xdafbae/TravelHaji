# TravelH - Sistem Informasi Manajemen Travel Haji & Umroh

Aplikasi berbasis web untuk mengelola operasional travel Haji dan Umroh, mulai dari pendaftaran jamaah, manajemen keberangkatan, keuangan, hingga inventory perlengkapan.

## 🚀 Fitur Utama

### 1. Pendaftaran & Manajemen Jamaah
*   **Form Pendaftaran Bertahap**: Data Pribadi, Kontak, Dokumen, dan Info Pembayaran.
*   **Database Jamaah**: Pencarian dan pengelolaan data jamaah terpusat.
*   **Riwayat**: Melacak status keberangkatan dan pembayaran jamaah.

### 2. Manajemen Keberangkatan (Embarkasi)
*   **Jadwal Keberangkatan**: Mengelola paket, tanggal, maskapai, dan kapasitas seat.
*   **Manifest Penumpang**: Menambahkan jamaah ke jadwal keberangkatan.
*   **Status Dokumen & Visa**: Tracking status kelengkapan dokumen dan visa (Pending, Approved, Issued, Rejected).
*   **Distribusi Perlengkapan**: Mengelola penyerahan barang (koper, kain ihram, dll) ke jamaah dengan pengurangan stok otomatis.
*   **Upload Dokumen**: Upload Boarding Pass dan Manifest Final.

### 3. Keuangan (Finance)
*   **Buku Kas & Transaksi**: Mencatat Pemasukan dan Pengeluaran (Debet/Kredit).
*   **Otomatisasi Status Pembayaran**: Status pembayaran jamaah otomatis berubah (Belum Lunas/Lunas) saat transaksi pemasukan dicatat.
*   **Laporan Keuangan**: Rekapitulasi arus kas berdasarkan periode.

### 4. Purchasing & Inventory
*   **Purchase Order (PO)**: Membuat pesanan pembelian ke supplier.
*   **Stok Barang (Inventory)**: Mengelola stok perlengkapan (Masuk dari PO, Keluar ke Jamaah).
*   **Data Supplier**: Manajemen database vendor/supplier.

### 5. Master Data & Pengaturan
*   **Paket & Price List**: Mengelola harga dan jenis paket.
*   **Pegawai**: Manajemen akun pengguna dan staf.
*   **Hak Akses**: (To be implemented fully) Role-based access control.

## 🛠️ Teknologi yang Digunakan

*   **Framework**: [Laravel 10.x](https://laravel.com)
*   **Database**: MySQL
*   **Frontend**: Blade Templates
*   **Styling**: [Tailwind CSS](https://tailwindcss.com)
*   **Interactivity**: [Alpine.js](https://alpinejs.dev)
*   **Icons**: FontAwesome

## 📦 Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal Anda:

1.  **Clone Repository**
    ```bash
    git clone https://github.com/username/TravelH.git
    cd TravelH
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install && npm run build
    ```

3.  **Konfigurasi Environment**
    Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database.
    ```bash
    cp .env.example .env
    ```
    Edit file `.env`:
    ```env
    DB_DATABASE=travel_hajj
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  **Generate Key & Migrate Database**
    ```bash
    php artisan key:generate
    php artisan migrate --seed
    ```
    *Note: `--seed` akan mengisi data awal (User Admin, Kode Akuntansi, Supplier, Stok Dummy).*

5.  **Jalankan Server**
    ```bash
    php artisan serve
    ```
    Buka browser dan akses `http://localhost:8000`.

## 👤 Akun Default

*   **Email**: `admin@travelh.com`
*   **Password**: `password`

## 🤝 Kontribusi

1.  Fork repository ini
2.  Buat branch fitur baru (`git checkout -b fitur-baru`)
3.  Commit perubahan Anda (`git commit -m 'Menambahkan fitur baru'`)
4.  Push ke branch (`git push origin fitur-baru`)
5.  Buat Pull Request

## 📄 Lisensi

[MIT License](LICENSE)
