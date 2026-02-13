DOKUMENTASI TEKNIS SISTEM HAJI & UMRAH DNT
UNTUK PROGRAMMER

1. STRUKTUR MENU
Sidebar Menu:
├── Dashboard
├── Pendaftaran Jamaah
│   ├── Daftar Jamaah
│   ├── Tambah Jamaah
│   └── Upload Dokumen
├── Keberangkatan
│   ├── Per Keberangkatan
│   ├── Non-Keberangkatan
│   └── Tambah Jadwal
├── Manifest & Visa
│   ├── Manifest Umum
│   ├── Data Passport
│   └── Tambah Passport
├── Embarkasi
├── Riwayat Transaksi
├── Buku Kas
│   ├── Isian (Input)
│   ├── Harian
│   └── Bulanan
├── Database Pegawai
├── Price List
├── Stock & Purchasing
│   ├── Daftar Purchase
│   ├── Posisi Stok
│   └── Database Barang
├── Database Vendor
├── Laporan
└── Pengaturan

2. ROLE AKSES
RoleAkses MenuSuper AdminSemua menu, full CRUD, hapus permanenRegistrasiJamaah (CRUD), Passport (CRUD), Dashboard (R)KasirBuku Kas (CRUD), Transaksi (R), Dashboard (R)KeuanganBuku Kas (CRUD), Laporan Keuangan (Full)Tour LeaderEmbarkasi assigned (R), Dashboard (R)Agen MarketingJamaah (CR), Price List (R)PurchaseStock & Purchasing (CRUD), Vendor (CRUD)

3. ALUR KERJA (WORKFLOW)
3.1 Workflow Pendaftaran Jamaah
1. Marketing input data jamaah (4 step form)
   ↓
2. Auto-generate ID Jamaah (J001, J002, ...)
   ↓
3. Upload dokumen (KTP, KK, Foto, Bukti)
   ↓
4. Input data passport
   ↓
5. Review & Submit
   ↓
6. Data masuk database → Status: "Belum Berangkat"
   ↓
7. Bisa di-assign ke Embarkasi
3.2 Workflow Keberangkatan
1. Admin buat jadwal → Auto-generate Embarkasi ID
   ↓
2. Assign jamaah ke keberangkatan (multi-select)
   ↓
3. Validasi: passport valid & payment OK
   ↓
4. Generate manifest untuk visa Saudi
   ↓
5. Export ke Excel (format Saudi)
   ↓
6. Upload boarding pass
   ↓
7. Status jamaah → "Sudah Berangkat"
3.3 Workflow Transaksi Keuangan
1. Kasir terima pembayaran
   ↓
2. Input di Buku Kas (tab DEBET/KREDIT)
   ↓
3. Link ke Jamaah (jika pembayaran jamaah)
   ↓
4. Upload bukti transfer
   ↓
5. Auto-calculate running balance
   ↓
6. Data masuk table: kas, transaksi
   ↓
7. Muncul di dashboard & laporan
3.4 Workflow Purchasing
1. Buat Purchase Order → PRC-XXX
   ↓
2. Tambah item (search dari stock)
   ↓
3. Status: "Data Kosong" → "Ada Data" → "Lunas"
   ↓
4. Barang datang → Update stock otomatis
   ↓
5. Bayar → Auto-create entry di Buku Kas (KREDIT)
   ↓
6. Low stock alert jika < buffer

4. DATABASE STRUCTURE
4.1 ERD Sederhana
jamaah (1:1) passport (1:1) manifest
  |
  ├─(1:N)─ transaksi
  ├─(1:N)─ barang_jamaah
  └─(1:N)─ embarkasi_detail ─(N:1)─ embarkasi ─(N:1)─ pegawai (tour_leader)

kas ─(N:1)─ kode_akuntansi
    └─(N:1)─ cara_bayar

purchase ─(1:N)─ purchase_detail ─(N:1)─ stok
        └─(N:1)─ supplier

pegawai ─(N:N)─ pegawai_roles ─(N:1)─ roles

price_list (standalone)
supplier/vendor (standalone)
audit_log (logging semua aktivitas)
settings (konfigurasi sistem)
notifications (notif user)
4.2 Tabel Database
1. jamaah
id_jamaah (PK)
kode_jamaah (UNIQUE) - J001, J002
nama_lengkap
tgl_lahir, tempat_lahir
nik (UNIQUE)
no_hp
jenis_kelamin
alamat, kabupaten
id_mahrom, nama_mahrom, hubungan_mahrom
foto_ktp, foto_kk, foto_diri, bukti_transfer
status_keberangkatan - Belum Berangkat / Sudah Berangkat
is_active
created_by, created_at, updated_by, updated_at, deleted_at
2. passport
id_passport (PK)
id_jamaah (FK, UNIQUE)
no_passport (UNIQUE)
nama_passport, first_name, last_name
gender, birth_date, birth_city
date_issued, date_expire
issuing_office
kategori_mahrom, nama_mahrom, relasi
umur, mahr
scan_passport
status_visa - Pending / Approved / Issued / Rejected
created_at, updated_at
3. manifest
id_manifest (PK)
id_passport (FK)
id_embarkasi (FK)
no_manifest, tgl_manifest
[auto-populated dari passport]
status - Draft / Submitted / Approved
created_at, updated_at
4. embarkasi
id_embarkasi (PK)
kode_embarkasi (UNIQUE) - BTK25-UMRI(3)-01-SEP-2025
paket_haji_umroh, kota_keberangkatan
waktu_keberangkatan, waktu_kepulangan
maskapai, pesawat_pergi, pesawat_pulang
kapasitas_jamaah, jumlah_jamaah, harga_paket
id_tour_leader (FK)
status - Belum Berangkat / Sudah Berangkat / Selesai
boarding_pass_file, manifest_file
created_by, created_at, updated_by, updated_at
5. embarkasi_detail (pivot table)
id (PK)
id_embarkasi (FK)
id_jamaah (FK)
seat_number
payment_status - Lunas / Pending / Belum Lunas
document_status - Lengkap / Belum Lengkap
assigned_at
6. transaksi
id_transaksi (PK)
id_jamaah (FK)
id_faktur
waktu_input
kategori, waktu_bayar, nama_item
total_tagihan, total_cashbon, jumlah_bayar
marketer, tim_syiar
cara_bayar
status - Lunas / Pending / Belum Lunas
created_by, created_at
7. barang_jamaah
id (PK)
id_jamaah (FK)
deskripsi_barang, jumlah
status_penyerahan - Belum Diserahkan / Sudah Diserahkan
tgl_penyerahan
diserahkan_oleh (FK)
created_at
8. kas
id_kas (PK)
cek_id (UNIQUE)
nama_transaksi
tanggal, waktu
jenis - DEBET / KREDIT
form_type - B / C / D / PURCHASE
jumlah
kode_akuntansi (FK), cara_bayar
id_jamaah (FK), id_purchase
keterangan, bukti_file
is_deleted, deleted_reason
created_by, created_at, updated_by, updated_at, deleted_at
9. kode_akuntansi
id (PK)
kode (UNIQUE) - A1, A2, B1, C1, dll
kategori, keterangan
is_active
color (hex)
created_at, updated_at

Data default:
A1 - Operasional
A2 - Barang Habis Pakai
A3 - Barang Modal
A4 - Lainnya
B1 - Pengiriman Paket
B2 - Konsumsi
C1 - DP
C2 - Angsuran
C3 - Pelunasan
10. cara_bayar
id (PK)
nama_bank (UNIQUE) - CASH, BNI, MANDIRI, BSI, dll
tipe - BANK / E-WALLET / CASH
nomor_rekening, atas_nama
logo_url
is_active
urutan
created_at, updated_at

Data default: CASH, BNI, MANDIRI, BSI, BRI, BCA, DANA, BTN, BRK SYARIAH, MALAYSIA, QRIS, BANK DANAMON
11. pegawai
id_pegawai (PK)
nama_pegawai, nik, no_kk, no_hp, tgl_lahir, alamat
inisial
jabatan - Super Admin / Registrasi / Kasir / Keuangan / Tour Leader / Agen Marketing / Purchase
wilayah, tim_syiar
username (UNIQUE), password (hashed)
foto_pegawai, tanda_tangan
status - AKTIF / TIDAK AKTIF
last_login
created_by, created_at, updated_by, updated_at
12. roles
id_role (PK)
nama_role (UNIQUE)
deskripsi
super_admin, registrasi, kasir, keuangan, tour_leader, agen_marketing, purchase (boolean)
created_at, updated_at
13. pegawai_roles (pivot table)
id (PK)
id_pegawai (FK)
id_role (FK)
assigned_at, assigned_by (FK)
14. price_list
id_pricelist (PK)
nama_item, kode_item
harga
form_a, form_b, form_c, form_d, form_d_barang, form_d_jasa (boolean)
keterangan
tanggal_mulai, tanggal_berakhir
is_active
created_by, created_at, updated_by, updated_at
15. price_history
id (PK)
id_pricelist (FK)
harga_lama, harga_baru
perubahan_persen
alasan_perubahan
changed_by (FK), changed_at
16. purchase
id_purchase (PK) - PRC-001, PRC-002
kode_purchase (UNIQUE)
id_supplier (FK)
waktu_preorder, tgl_barang_datang, tgl_lunas
payment_terms, total_amount
status - Data Masih Kosong / Ada Data / Lunas
galeri (JSON array)
keterangan
created_by, created_at, updated_by, updated_at, deleted_at
17. purchase_detail
id (PK)
id_purchase (FK)
id_stok (FK)
waktu_input
qty, harga_satuan, subtotal
diskon, potongan_manual
ppn (percentage)
hpp, modal_satuan, total_bayar
k1
18. stok
id_stok (PK)
nama_barang, kode_barang (UNIQUE), inisial_barang
buffer_stok, stok_awal, stok_tersedia, stok_keluar
barcode
is_tersedia
keterangan
waktu_input, created_by, created_at, updated_at
19. stock_movement
id (PK)
id_stok (FK)
tipe - IN / OUT / ADJUSTMENT
qty
alasan - Pembelian / Penjualan / Penyesuaian / Rusak / Hilang / Return
keterangan
id_purchase, id_transaksi (references)
stok_sebelum, stok_sesudah
created_by, created_at
20. supplier
id_supplier (PK)
nama_supplier, kontak, email, alamat
kategori, keterangan
is_active
total_order, on_time_delivery_rate, quality_score
created_at, updated_at
21. audit_log
id_log (PK)
id_pegawai (FK), username
modul - Dashboard / Jamaah / Kas / dll
aksi - CREATE / READ / UPDATE / DELETE
deskripsi
target_table, target_id
ip_address, user_agent
data_lama, data_baru (JSON)
created_at
22. settings
id (PK)
setting_key (UNIQUE) - company_name, company_address, dll
setting_value
setting_type - STRING / NUMBER / BOOLEAN / JSON
deskripsi
updated_by (FK), updated_at
23. notifications
id_notif (PK)
id_pegawai (FK)
judul, pesan
tipe - INFO / SUCCESS / WARNING / ERROR
link_url, link_text
is_read, read_at
created_at

5. API ENDPOINTS
Authentication
POST   /api/auth/login
POST   /api/auth/logout
GET    /api/auth/me
POST   /api/auth/forgot-password
POST   /api/auth/reset-password
Jamaah
GET    /api/jamaah
GET    /api/jamaah/:id
POST   /api/jamaah
PUT    /api/jamaah/:id
DELETE /api/jamaah/:id
GET    /api/jamaah/trash
POST   /api/jamaah/:id/restore
POST   /api/jamaah/bulk-delete
GET    /api/jamaah/export
Passport
GET    /api/passport
POST   /api/passport
PUT    /api/passport/:id
DELETE /api/passport/:id
POST   /api/passport/bulk-upload
GET    /api/passport/expiring
Embarkasi
GET    /api/embarkasi
POST   /api/embarkasi
PUT    /api/embarkasi/:id
DELETE /api/embarkasi/:id
POST   /api/embarkasi/:id/assign-jamaah
GET    /api/embarkasi/:id/manifest
GET    /api/embarkasi/:id/export
Kas
GET    /api/kas
POST   /api/kas
PUT    /api/kas/:id
DELETE /api/kas/:id
GET    /api/kas/daily/:date
GET    /api/kas/monthly/:year/:month
GET    /api/kas/export
Purchase & Stock
GET    /api/purchase
POST   /api/purchase
PUT    /api/purchase/:id
DELETE /api/purchase/:id

GET    /api/stock
POST   /api/stock
PUT    /api/stock/:id
POST   /api/stock/:id/adjust
GET    /api/stock/low-stock
Laporan
GET    /api/laporan/keuangan-harian
GET    /api/laporan/keuangan-bulanan
GET    /api/laporan/jamaah
GET    /api/laporan/passport-expiry
GET    /api/laporan/stock-position