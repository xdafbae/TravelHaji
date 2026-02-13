<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 12. roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id('id_role');
            $table->string('nama_role')->unique();
            $table->text('deskripsi')->nullable();
            // Permissions
            $table->boolean('super_admin')->default(false);
            $table->boolean('registrasi')->default(false);
            $table->boolean('kasir')->default(false);
            $table->boolean('keuangan')->default(false);
            $table->boolean('tour_leader')->default(false);
            $table->boolean('agen_marketing')->default(false);
            $table->boolean('purchase')->default(false);
            $table->timestamps();
        });

        // 11. pegawai (replacing/extending standard users, but we create separate table as per plan)
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id('id_pegawai');
            $table->string('nama_pegawai');
            $table->string('nik')->nullable();
            $table->string('no_kk')->nullable();
            $table->string('no_hp')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('inisial')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('wilayah')->nullable();
            $table->string('tim_syiar')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('foto_pegawai')->nullable();
            $table->string('tanda_tangan')->nullable();
            $table->enum('status', ['AKTIF', 'TIDAK AKTIF'])->default('AKTIF');
            $table->timestamp('last_login')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        // 13. pegawai_roles
        Schema::create('pegawai_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pegawai')->constrained('pegawai', 'id_pegawai')->onDelete('cascade');
            $table->foreignId('id_role')->constrained('roles', 'id_role')->onDelete('cascade');
            $table->timestamp('assigned_at')->useCurrent();
            $table->unsignedBigInteger('assigned_by')->nullable();
        });

        // 1. jamaah
        Schema::create('jamaah', function (Blueprint $table) {
            $table->id('id_jamaah');
            $table->string('kode_jamaah')->unique(); // J001
            $table->string('nama_lengkap');
            $table->date('tgl_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('nik')->unique()->nullable();
            $table->string('no_hp')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat')->nullable();
            $table->string('kabupaten')->nullable();
            // Mahrom info
            $table->unsignedBigInteger('id_mahrom')->nullable(); // Self-reference could be added later if needed
            $table->string('nama_mahrom')->nullable();
            $table->string('hubungan_mahrom')->nullable();
            // Files
            $table->string('foto_ktp')->nullable();
            $table->string('foto_kk')->nullable();
            $table->string('foto_diri')->nullable();
            $table->string('bukti_transfer')->nullable();
            // Status
            $table->enum('status_keberangkatan', ['Belum Berangkat', 'Sudah Berangkat'])->default('Belum Berangkat');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // 2. passport
        Schema::create('passport', function (Blueprint $table) {
            $table->id('id_passport');
            $table->foreignId('id_jamaah')->unique()->constrained('jamaah', 'id_jamaah')->onDelete('cascade');
            $table->string('no_passport')->unique();
            $table->string('nama_passport');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_city')->nullable();
            $table->date('date_issued')->nullable();
            $table->date('date_expire')->nullable();
            $table->string('issuing_office')->nullable();
            // Mahrom in passport
            $table->string('kategori_mahrom')->nullable();
            $table->string('nama_mahrom')->nullable();
            $table->string('relasi')->nullable();
            $table->integer('umur')->nullable();
            $table->string('mahr')->nullable(); // Assuming text
            $table->string('scan_passport')->nullable();
            $table->enum('status_visa', ['Pending', 'Approved', 'Issued', 'Rejected'])->default('Pending');
            $table->timestamps();
        });

        // 4. embarkasi
        Schema::create('embarkasi', function (Blueprint $table) {
            $table->id('id_embarkasi');
            $table->string('kode_embarkasi')->unique();
            $table->string('paket_haji_umroh')->nullable();
            $table->string('kota_keberangkatan')->nullable();
            $table->dateTime('waktu_keberangkatan')->nullable();
            $table->dateTime('waktu_kepulangan')->nullable();
            $table->string('maskapai')->nullable();
            $table->string('pesawat_pergi')->nullable();
            $table->string('pesawat_pulang')->nullable();
            $table->integer('kapasitas_jamaah')->default(0);
            $table->integer('jumlah_jamaah')->default(0);
            $table->decimal('harga_paket', 15, 2)->default(0);
            $table->unsignedBigInteger('id_tour_leader')->nullable(); // FK to pegawai
            $table->enum('status', ['Belum Berangkat', 'Sudah Berangkat', 'Selesai'])->default('Belum Berangkat');
            $table->string('boarding_pass_file')->nullable();
            $table->string('manifest_file')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        // 5. embarkasi_detail
        Schema::create('embarkasi_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_embarkasi')->constrained('embarkasi', 'id_embarkasi')->onDelete('cascade');
            $table->foreignId('id_jamaah')->constrained('jamaah', 'id_jamaah')->onDelete('cascade');
            $table->string('seat_number')->nullable();
            $table->enum('payment_status', ['Lunas', 'Pending', 'Belum Lunas'])->default('Pending');
            $table->enum('document_status', ['Lengkap', 'Belum Lengkap'])->default('Belum Lengkap');
            $table->timestamp('assigned_at')->useCurrent();
        });

        // 3. manifest
        Schema::create('manifest', function (Blueprint $table) {
            $table->id('id_manifest');
            $table->foreignId('id_passport')->constrained('passport', 'id_passport')->onDelete('cascade');
            $table->foreignId('id_embarkasi')->constrained('embarkasi', 'id_embarkasi')->onDelete('cascade');
            $table->string('no_manifest')->nullable();
            $table->date('tgl_manifest')->nullable();
            $table->enum('status', ['Draft', 'Submitted', 'Approved'])->default('Draft');
            $table->timestamps();
        });

        // 20. supplier
        Schema::create('supplier', function (Blueprint $table) {
            $table->id('id_supplier');
            $table->string('nama_supplier');
            $table->string('kontak')->nullable();
            $table->string('email')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kategori')->nullable();
            $table->text('keterangan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('total_order')->default(0);
            $table->decimal('on_time_delivery_rate', 5, 2)->nullable();
            $table->decimal('quality_score', 5, 2)->nullable();
            $table->timestamps();
        });

        // 18. stok
        Schema::create('stok', function (Blueprint $table) {
            $table->id('id_stok');
            $table->string('nama_barang');
            $table->string('kode_barang')->unique();
            $table->string('inisial_barang')->nullable();
            $table->integer('buffer_stok')->default(0);
            $table->integer('stok_awal')->default(0);
            $table->integer('stok_tersedia')->default(0);
            $table->integer('stok_keluar')->default(0);
            $table->string('barcode')->nullable();
            $table->boolean('is_tersedia')->default(true);
            $table->text('keterangan')->nullable();
            $table->timestamp('waktu_input')->useCurrent();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        // 16. purchase
        Schema::create('purchase', function (Blueprint $table) {
            $table->id('id_purchase');
            $table->string('kode_purchase')->unique();
            $table->foreignId('id_supplier')->nullable()->constrained('supplier', 'id_supplier');
            $table->dateTime('waktu_preorder')->nullable();
            $table->date('tgl_barang_datang')->nullable();
            $table->date('tgl_lunas')->nullable();
            $table->string('payment_terms')->nullable();
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->enum('status', ['Data Masih Kosong', 'Ada Data', 'Lunas'])->default('Data Masih Kosong');
            $table->json('galeri')->nullable();
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // 17. purchase_detail
        Schema::create('purchase_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_purchase')->constrained('purchase', 'id_purchase')->onDelete('cascade');
            $table->foreignId('id_stok')->constrained('stok', 'id_stok');
            $table->timestamp('waktu_input')->useCurrent();
            $table->integer('qty')->default(0);
            $table->decimal('harga_satuan', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('diskon', 15, 2)->default(0);
            $table->decimal('potongan_manual', 15, 2)->default(0);
            $table->decimal('ppn', 5, 2)->default(0); // Percentage
            $table->decimal('hpp', 15, 2)->default(0);
            $table->decimal('modal_satuan', 15, 2)->default(0);
            $table->decimal('total_bayar', 15, 2)->default(0);
            $table->string('k1')->nullable();
        });

        // 9. kode_akuntansi
        Schema::create('kode_akuntansi', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // A1, A2
            $table->string('kategori')->nullable();
            $table->string('keterangan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('color')->nullable(); // Hex
            $table->timestamps();
        });

        // 10. cara_bayar
        Schema::create('cara_bayar', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bank')->unique();
            $table->enum('tipe', ['BANK', 'E-WALLET', 'CASH']);
            $table->string('nomor_rekening')->nullable();
            $table->string('atas_nama')->nullable();
            $table->string('logo_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        // 8. kas
        Schema::create('kas', function (Blueprint $table) {
            $table->id('id_kas');
            $table->string('cek_id')->unique()->nullable();
            $table->string('nama_transaksi')->nullable();
            $table->date('tanggal');
            $table->time('waktu');
            $table->enum('jenis', ['DEBET', 'KREDIT']);
            $table->string('form_type')->nullable(); // B / C / D / PURCHASE
            $table->decimal('jumlah', 15, 2);
            $table->unsignedBigInteger('kode_akuntansi_id')->nullable(); // FK manually managed or constrained
            $table->string('cara_bayar')->nullable();
            $table->unsignedBigInteger('id_jamaah')->nullable(); // FK
            $table->unsignedBigInteger('id_purchase')->nullable(); // FK
            $table->text('keterangan')->nullable();
            $table->string('bukti_file')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->string('deleted_reason')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // 6. transaksi
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->foreignId('id_jamaah')->constrained('jamaah', 'id_jamaah');
            $table->string('id_faktur')->nullable();
            $table->dateTime('waktu_input')->useCurrent();
            $table->string('kategori')->nullable();
            $table->dateTime('waktu_bayar')->nullable();
            $table->string('nama_item')->nullable();
            $table->decimal('total_tagihan', 15, 2)->default(0);
            $table->decimal('total_cashbon', 15, 2)->default(0);
            $table->decimal('jumlah_bayar', 15, 2)->default(0);
            $table->string('marketer')->nullable();
            $table->string('tim_syiar')->nullable();
            $table->string('cara_bayar')->nullable();
            $table->enum('status', ['Lunas', 'Pending', 'Belum Lunas'])->default('Pending');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        // 7. barang_jamaah
        Schema::create('barang_jamaah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_jamaah')->constrained('jamaah', 'id_jamaah');
            $table->string('deskripsi_barang');
            $table->integer('jumlah')->default(1);
            $table->enum('status_penyerahan', ['Belum Diserahkan', 'Sudah Diserahkan'])->default('Belum Diserahkan');
            $table->date('tgl_penyerahan')->nullable();
            $table->unsignedBigInteger('diserahkan_oleh')->nullable();
            $table->timestamps();
        });

        // 19. stock_movement
        Schema::create('stock_movement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_stok')->constrained('stok', 'id_stok');
            $table->enum('tipe', ['IN', 'OUT', 'ADJUSTMENT']);
            $table->integer('qty');
            $table->string('alasan')->nullable();
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('id_purchase')->nullable();
            $table->unsignedBigInteger('id_transaksi')->nullable();
            $table->integer('stok_sebelum')->default(0);
            $table->integer('stok_sesudah')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        // 14. price_list
        Schema::create('price_list', function (Blueprint $table) {
            $table->id('id_pricelist');
            $table->string('nama_item');
            $table->string('kode_item')->nullable();
            $table->decimal('harga', 15, 2);
            $table->boolean('form_a')->default(false);
            $table->boolean('form_b')->default(false);
            $table->boolean('form_c')->default(false);
            $table->boolean('form_d')->default(false);
            $table->boolean('form_d_barang')->default(false);
            $table->boolean('form_d_jasa')->default(false);
            $table->text('keterangan')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_berakhir')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        // 15. price_history
        Schema::create('price_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pricelist')->constrained('price_list', 'id_pricelist');
            $table->decimal('harga_lama', 15, 2);
            $table->decimal('harga_baru', 15, 2);
            $table->decimal('perubahan_persen', 5, 2)->nullable();
            $table->string('alasan_perubahan')->nullable();
            $table->unsignedBigInteger('changed_by')->nullable();
            $table->timestamp('changed_at')->useCurrent();
        });

        // 21. audit_log
        Schema::create('audit_log', function (Blueprint $table) {
            $table->id('id_log');
            $table->unsignedBigInteger('id_pegawai')->nullable();
            $table->string('username')->nullable();
            $table->string('modul')->nullable();
            $table->string('aksi')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('target_table')->nullable();
            $table->string('target_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->json('data_lama')->nullable();
            $table->json('data_baru')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        // 22. settings
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('setting_key')->unique();
            $table->text('setting_value')->nullable();
            $table->string('setting_type')->default('STRING');
            $table->text('deskripsi')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('updated_at')->useCurrent();
        });

        // 23. notifications
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('id_notif');
            $table->unsignedBigInteger('id_pegawai');
            $table->string('judul');
            $table->text('pesan');
            $table->enum('tipe', ['INFO', 'SUCCESS', 'WARNING', 'ERROR'])->default('INFO');
            $table->string('link_url')->nullable();
            $table->string('link_text')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop in reverse order to avoid FK constraint errors
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('audit_log');
        Schema::dropIfExists('price_history');
        Schema::dropIfExists('price_list');
        Schema::dropIfExists('stock_movement');
        Schema::dropIfExists('barang_jamaah');
        Schema::dropIfExists('transaksi');
        Schema::dropIfExists('kas');
        Schema::dropIfExists('cara_bayar');
        Schema::dropIfExists('kode_akuntansi');
        Schema::dropIfExists('purchase_detail');
        Schema::dropIfExists('purchase');
        Schema::dropIfExists('stok');
        Schema::dropIfExists('supplier');
        Schema::dropIfExists('manifest');
        Schema::dropIfExists('embarkasi_detail');
        Schema::dropIfExists('embarkasi');
        Schema::dropIfExists('passport');
        Schema::dropIfExists('jamaah');
        Schema::dropIfExists('pegawai_roles');
        Schema::dropIfExists('pegawai');
        Schema::dropIfExists('roles');
    }
};
