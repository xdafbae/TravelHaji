<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchasingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Suppliers
        $suppliers = [
            [
                'nama_supplier' => 'PT. Perlengkapan Haji Utama',
                'kontak' => '081234567890',
                'email' => 'sales@phu.com',
                'alamat' => 'Jl. Tanah Abang Blok A',
                'kategori' => 'Perlengkapan',
                'keterangan' => 'Supplier Kain Ihram dan Batik',
            ],
            [
                'nama_supplier' => 'CV. Koper Barokah',
                'kontak' => '08987654321',
                'email' => 'admin@koperbarokah.com',
                'alamat' => 'Jl. Mangga Dua Raya',
                'kategori' => 'Koper & Tas',
                'keterangan' => 'Supplier Koper Kabin dan Bagasi',
            ],
            [
                'nama_supplier' => 'Hotel Makkah Provider',
                'kontak' => '+96655555555',
                'email' => 'booking@makkahhotel.com',
                'alamat' => 'Makkah Al Mukarramah',
                'kategori' => 'Akomodasi',
                'keterangan' => 'Provider Hotel',
            ]
        ];

        foreach ($suppliers as $supplier) {
            DB::table('supplier')->updateOrInsert(
                ['nama_supplier' => $supplier['nama_supplier']],
                $supplier
            );
        }

        // Seed Stok Items
        $items = [
            [
                'nama_barang' => 'Kain Ihram Dewasa',
                'kode_barang' => 'BRG-001',
                'inisial_barang' => 'KI',
                'buffer_stok' => 10,
                'stok_awal' => 0,
                'stok_tersedia' => 0,
                'is_tersedia' => true,
            ],
            [
                'nama_barang' => 'Koper Bagasi 24 Inch',
                'kode_barang' => 'BRG-002',
                'inisial_barang' => 'KP24',
                'buffer_stok' => 5,
                'stok_awal' => 0,
                'stok_tersedia' => 0,
                'is_tersedia' => true,
            ],
            [
                'nama_barang' => 'Batik Seragam Pria',
                'kode_barang' => 'BRG-003',
                'inisial_barang' => 'BP',
                'buffer_stok' => 20,
                'stok_awal' => 0,
                'stok_tersedia' => 0,
                'is_tersedia' => true,
            ],
        ];

        DB::table('stok')->upsert($items, ['kode_barang'], ['nama_barang', 'inisial_barang', 'buffer_stok', 'is_tersedia']);
    }
}
