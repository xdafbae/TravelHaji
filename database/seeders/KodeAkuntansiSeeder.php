<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KodeAkuntansiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Pemasukan (Revenue) - Kode 4xxx
            ['kode' => '4001', 'kategori' => 'Pemasukan', 'keterangan' => 'Pemasukan Paket Umroh'],
            ['kode' => '4002', 'kategori' => 'Pemasukan', 'keterangan' => 'Pemasukan Paket Haji'],
            ['kode' => '4003', 'kategori' => 'Pemasukan', 'keterangan' => 'Penjualan Tiket Pesawat'],
            ['kode' => '4004', 'kategori' => 'Pemasukan', 'keterangan' => 'Jasa Pembuatan Visa'],
            ['kode' => '4005', 'kategori' => 'Pemasukan', 'keterangan' => 'Jasa Handling Perlengkapan'],
            ['kode' => '4999', 'kategori' => 'Pemasukan', 'keterangan' => 'Pemasukan Lain-lain'],

            // Pengeluaran Operasional (Expenses) - Kode 5xxx
            ['kode' => '5001', 'kategori' => 'Pengeluaran', 'keterangan' => 'Biaya Gaji Pegawai'],
            ['kode' => '5002', 'kategori' => 'Pengeluaran', 'keterangan' => 'Biaya Listrik, Air & Internet'],
            ['kode' => '5003', 'kategori' => 'Pengeluaran', 'keterangan' => 'Biaya Sewa Kantor'],
            ['kode' => '5004', 'kategori' => 'Pengeluaran', 'keterangan' => 'Biaya Pemasaran & Iklan'],
            ['kode' => '5005', 'kategori' => 'Pengeluaran', 'keterangan' => 'Biaya ATK & Perlengkapan Kantor'],
            ['kode' => '5006', 'kategori' => 'Pengeluaran', 'keterangan' => 'Biaya Transportasi & Perjalanan Dinas'],
            
            // Pengeluaran HPP (Cost of Goods Sold) - Kode 6xxx
            ['kode' => '6001', 'kategori' => 'Pengeluaran', 'keterangan' => 'Pembayaran Hotel Mekkah/Madinah'],
            ['kode' => '6002', 'kategori' => 'Pengeluaran', 'keterangan' => 'Pembayaran Tiket Pesawat Group'],
            ['kode' => '6003', 'kategori' => 'Pengeluaran', 'keterangan' => 'Pembayaran Visa & Mutawif'],
            ['kode' => '6004', 'kategori' => 'Pengeluaran', 'keterangan' => 'Pembelian Perlengkapan Jamaah (Koper, Batik, dll)'],
            
            // Aset & Modal - Kode 1xxx & 3xxx
            ['kode' => '1001', 'kategori' => 'Aset', 'keterangan' => 'Kas Besar (Tunai)'],
            ['kode' => '1002', 'kategori' => 'Aset', 'keterangan' => 'Bank Transfer'],
            ['kode' => '3001', 'kategori' => 'Modal', 'keterangan' => 'Setoran Modal Awal'],
        ];

        DB::table('kode_akuntansi')->insert($data);
    }
}
