<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - Cetak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-white p-8" onload="window.print()">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8 border-b-2 border-gray-800 pb-4">
            <h1 class="text-2xl font-bold text-gray-900 uppercase">Travel Haji & Umroh</h1>
            <h2 class="text-xl font-semibold text-gray-700">Laporan Keuangan</h2>
            <p class="text-sm text-gray-500 mt-1">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
        </div>

        <!-- Summary -->
        <div class="grid grid-cols-3 gap-4 mb-8">
            <div class="p-4 border rounded-lg bg-emerald-50 border-emerald-100">
                <p class="text-xs font-bold text-emerald-700 uppercase">Total Pemasukan</p>
                <p class="text-lg font-bold text-gray-800">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
            </div>
            <div class="p-4 border rounded-lg bg-red-50 border-red-100">
                <p class="text-xs font-bold text-red-700 uppercase">Total Pengeluaran</p>
                <p class="text-lg font-bold text-gray-800">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
            </div>
            <div class="p-4 border rounded-lg {{ $labaRugi >= 0 ? 'bg-blue-50 border-blue-100' : 'bg-orange-50 border-orange-100' }}">
                <p class="text-xs font-bold {{ $labaRugi >= 0 ? 'text-blue-700' : 'text-orange-700' }} uppercase">Laba / Rugi</p>
                <p class="text-lg font-bold text-gray-800">Rp {{ number_format($labaRugi, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Details -->
        <div class="grid grid-cols-2 gap-8">
            <!-- Pemasukan -->
            <div>
                <h3 class="text-sm font-bold text-emerald-800 uppercase mb-3 border-b border-emerald-200 pb-1">Rincian Pemasukan</h3>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b border-gray-200">
                            <th class="py-2">Akun</th>
                            <th class="py-2 text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pemasukan as $item)
                        <tr>
                            <td class="py-2">
                                <span class="block text-gray-800 font-medium">{{ $item->nama_akun }}</span>
                                <span class="text-xs text-gray-400">{{ $item->kode }}</span>
                            </td>
                            <td class="py-2 text-right text-gray-700">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="py-4 text-center text-gray-400 italic">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot class="border-t-2 border-gray-200">
                        <tr>
                            <td class="py-3 font-bold text-gray-800">Total</td>
                            <td class="py-3 text-right font-bold text-emerald-600">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Pengeluaran -->
            <div>
                <h3 class="text-sm font-bold text-red-800 uppercase mb-3 border-b border-red-200 pb-1">Rincian Pengeluaran</h3>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b border-gray-200">
                            <th class="py-2">Akun</th>
                            <th class="py-2 text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pengeluaran as $item)
                        <tr>
                            <td class="py-2">
                                <span class="block text-gray-800 font-medium">{{ $item->nama_akun }}</span>
                                <span class="text-xs text-gray-400">{{ $item->kode }}</span>
                            </td>
                            <td class="py-2 text-right text-gray-700">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="py-4 text-center text-gray-400 italic">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot class="border-t-2 border-gray-200">
                        <tr>
                            <td class="py-3 font-bold text-gray-800">Total</td>
                            <td class="py-3 text-right font-bold text-red-600">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="mt-12 text-center text-xs text-gray-400">
            <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
        </div>
    </div>
</body>
</html>