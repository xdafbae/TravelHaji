<?php

namespace App\Exports;

use App\Models\Jamaah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JamaahExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Jamaah::with(['embarkasi']);

        // Search
        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('kode_jamaah', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        // Filter Status
        if ($this->request->filled('status') && $this->request->status !== 'all') {
            $query->where('status_keberangkatan', $this->request->status);
        }

        return $query->latest()->get();
    }

    public function map($jamaah): array
    {
        $latestEmbarkasi = $jamaah->embarkasi->first();
        $paket = $latestEmbarkasi ? $latestEmbarkasi->nama_paket : '-';
        $waktuKeberangkatan = $latestEmbarkasi ? $latestEmbarkasi->waktu_keberangkatan : '-';
        
        return [
            $jamaah->kode_jamaah,
            $jamaah->nama_lengkap,
            $jamaah->nik,
            $jamaah->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
            $jamaah->no_hp,
            $jamaah->alamat . ', ' . $jamaah->kabupaten,
            $jamaah->status_keberangkatan,
            $paket,
            $waktuKeberangkatan,
        ];
    }

    public function headings(): array
    {
        return [
            'ID Jamaah',
            'Nama Lengkap',
            'NIK',
            'Jenis Kelamin',
            'No HP',
            'Alamat',
            'Status Keberangkatan',
            'Paket Terakhir',
            'Waktu Keberangkatan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
