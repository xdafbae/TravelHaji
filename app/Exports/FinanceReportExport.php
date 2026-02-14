<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FinanceReportExport implements FromArray, ShouldAutoSize, WithStyles
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $rows = [];

        // Header
        $rows[] = ['Laporan Keuangan Travel Haji & Umroh'];
        $rows[] = ['Periode: ' . \Carbon\Carbon::parse($this->data['startDate'])->format('d M Y') . ' - ' . \Carbon\Carbon::parse($this->data['endDate'])->format('d M Y')];
        $rows[] = ['']; // Empty row

        // PEMASUKAN
        $rows[] = ['PEMASUKAN (DEBET)'];
        $rows[] = ['Kode Akun', 'Nama Akun', 'Jumlah'];
        
        foreach ($this->data['pemasukan'] as $item) {
            $rows[] = [
                $item->kode,
                $item->nama_akun,
                $item->total
            ];
        }
        $rows[] = ['TOTAL PEMASUKAN', '', $this->data['totalPemasukan']];
        $rows[] = ['']; // Empty row

        // PENGELUARAN
        $rows[] = ['PENGELUARAN (KREDIT)'];
        $rows[] = ['Kode Akun', 'Nama Akun', 'Jumlah'];

        foreach ($this->data['pengeluaran'] as $item) {
            $rows[] = [
                $item->kode,
                $item->nama_akun,
                $item->total
            ];
        }
        $rows[] = ['TOTAL PENGELUARAN', '', $this->data['totalPengeluaran']];
        $rows[] = ['']; // Empty row

        // LABA RUGI
        $rows[] = ['LABA / RUGI BERSIH', '', $this->data['labaRugi']];

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            4 => ['font' => ['bold' => true]], // Header Pemasukan
            5 => ['font' => ['bold' => true]], // Column Headers Pemasukan
            
            // Note: We can't predict exact row numbers easily for dynamic data in simple styles array
            // But this is a good start. For strict styling, we would need to calculate row indices.
        ];
    }
}