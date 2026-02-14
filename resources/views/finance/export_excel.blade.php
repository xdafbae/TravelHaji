<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
    <table>
        <thead>
            <tr>
                <th colspan="3" style="font-weight: bold; font-size: 14px; text-align: center;">Laporan Keuangan Travel Haji & Umroh</th>
            </tr>
            <tr>
                <th colspan="3" style="text-align: center;">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</th>
            </tr>
            <tr>
                <th colspan="3"></th>
            </tr>
            <tr>
                <th colspan="3" style="font-weight: bold; background-color: #eeeeee;">PEMASUKAN (DEBET)</th>
            </tr>
            <tr>
                <th style="font-weight: bold; border: 1px solid #000000;">Kode Akun</th>
                <th style="font-weight: bold; border: 1px solid #000000;">Nama Akun</th>
                <th style="font-weight: bold; border: 1px solid #000000; text-align: right;">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pemasukan as $item)
            <tr>
                <td style="border: 1px solid #000000;">{{ $item->kode }}</td>
                <td style="border: 1px solid #000000;">{{ $item->nama_akun }}</td>
                <td style="border: 1px solid #000000; text-align: right;">{{ $item->total }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="2" style="font-weight: bold; border: 1px solid #000000; text-align: right;">TOTAL PEMASUKAN</td>
                <td style="font-weight: bold; border: 1px solid #000000; text-align: right;">{{ $totalPemasukan }}</td>
            </tr>
            <tr>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td colspan="3" style="font-weight: bold; background-color: #eeeeee;">PENGELUARAN (KREDIT)</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 1px solid #000000;">Kode Akun</td>
                <td style="font-weight: bold; border: 1px solid #000000;">Nama Akun</td>
                <td style="font-weight: bold; border: 1px solid #000000; text-align: right;">Jumlah</td>
            </tr>
            @foreach($pengeluaran as $item)
            <tr>
                <td style="border: 1px solid #000000;">{{ $item->kode }}</td>
                <td style="border: 1px solid #000000;">{{ $item->nama_akun }}</td>
                <td style="border: 1px solid #000000; text-align: right;">{{ $item->total }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="2" style="font-weight: bold; border: 1px solid #000000; text-align: right;">TOTAL PENGELUARAN</td>
                <td style="font-weight: bold; border: 1px solid #000000; text-align: right;">{{ $totalPengeluaran }}</td>
            </tr>
            <tr>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold; border: 1px solid #000000; text-align: right; background-color: #d1e7dd;">LABA / RUGI BERSIH</td>
                <td style="font-weight: bold; border: 1px solid #000000; text-align: right; background-color: #d1e7dd;">{{ $labaRugi }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>