<?php

namespace App\Exports;

use App\Models\Embarkasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ManifestExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $embarkasiId;

    public function __construct($embarkasiId)
    {
        $this->embarkasiId = $embarkasiId;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $embarkasi = Embarkasi::with(['jamaah.passport'])->findOrFail($this->embarkasiId);
        return $embarkasi->jamaah;
    }

    public function map($jamaah): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        $passport = $jamaah->passport;

        return [
            $rowNumber,
            $jamaah->nama_lengkap,
            $jamaah->jenis_kelamin,
            $passport ? $passport->no_passport : '-',
            $passport ? $passport->birth_city : '-',
            $passport ? $passport->birth_date->format('d-m-Y') : '-',
            $passport ? $passport->date_issued->format('d-m-Y') : '-',
            $passport ? $passport->date_expire->format('d-m-Y') : '-',
            $passport ? $passport->issuing_office : '-',
            $jamaah->pivot->document_status,
            $passport ? $passport->status_visa : 'Pending',
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Lengkap',
            'Gender',
            'No Paspor',
            'Tempat Lahir',
            'Tgl Lahir',
            'Tgl Terbit',
            'Tgl Expire',
            'Kantor Penerbit',
            'Status Dokumen',
            'Status Visa',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
