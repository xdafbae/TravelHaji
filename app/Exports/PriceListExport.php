<?php

namespace App\Exports;

use App\Models\PriceList;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PriceListExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PriceList::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Kode Item',
            'Nama Item',
            'Harga',
            'Keterangan',
            'Form A (Paket)',
            'Form B (Alat)',
            'Form C (Dok)',
            'Form D (Lain)',
            'Barang',
            'Jasa',
            'Tanggal Mulai',
            'Tanggal Berakhir',
            'Status Aktif',
            'Dibuat Pada',
        ];
    }

    public function map($item): array
    {
        return [
            $item->id_pricelist,
            $item->kode_item,
            $item->nama_item,
            $item->harga,
            $item->keterangan,
            $item->form_a ? 'Ya' : 'Tidak',
            $item->form_b ? 'Ya' : 'Tidak',
            $item->form_c ? 'Ya' : 'Tidak',
            $item->form_d ? 'Ya' : 'Tidak',
            $item->form_d_barang ? 'Ya' : 'Tidak',
            $item->form_d_jasa ? 'Ya' : 'Tidak',
            $item->tanggal_mulai ? $item->tanggal_mulai->format('Y-m-d') : '-',
            $item->tanggal_berakhir ? $item->tanggal_berakhir->format('Y-m-d') : '-',
            $item->is_active ? 'Aktif' : 'Non-Aktif',
            $item->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
