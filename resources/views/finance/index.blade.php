<x-app-layout>
    <x-slot name="header">
        Buku Kas & Transaksi
    </x-slot>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-emerald-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500 uppercase font-semibold">Total Pemasukan (Debet)</p>
                    <h3 class="text-2xl font-bold text-emerald-600 mt-1">Rp {{ number_format($totalDebet, 0, ',', '.') }}</h3>
                </div>
                <div class="p-3 bg-emerald-100 rounded-full text-emerald-600">
                    <i class="fas fa-arrow-down"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500 uppercase font-semibold">Total Pengeluaran (Kredit)</p>
                    <h3 class="text-2xl font-bold text-red-600 mt-1">Rp {{ number_format($totalKredit, 0, ',', '.') }}</h3>
                </div>
                <div class="p-3 bg-red-100 rounded-full text-red-600">
                    <i class="fas fa-arrow-up"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500 uppercase font-semibold">Saldo Akhir</p>
                    <h3 class="text-2xl font-bold text-blue-600 mt-1">Rp {{ number_format($openingBalance + $balance, 0, ',', '.') }}</h3>
                    <p class="text-xs text-gray-400 mt-1">Saldo Awal: Rp {{ number_format($openingBalance, 0, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <h2 class="text-lg font-semibold text-gray-800">Riwayat Transaksi</h2>
                
                <!-- Filter Form -->
                <form action="{{ route('finance.index') }}" method="GET" class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-2">
                    <div class="flex items-center space-x-2">
                        <input type="date" name="start_date" value="{{ $startDate }}" class="rounded-md border-gray-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <span class="text-gray-500">-</span>
                        <input type="date" name="end_date" value="{{ $endDate }}" class="rounded-md border-gray-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    
                    <select name="type" class="rounded-md border-gray-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">Semua Jenis</option>
                        <option value="Debet" {{ request('type') == 'Debet' ? 'selected' : '' }}>Pemasukan (Debet)</option>
                        <option value="Kredit" {{ request('type') == 'Kredit' ? 'selected' : '' }}>Pengeluaran (Kredit)</option>
                    </select>

                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 text-sm">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>

                    <a href="{{ route('finance.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 text-sm flex items-center">
                        <i class="fas fa-plus mr-2"></i> Transaksi Baru
                    </a>
                </form>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 uppercase text-xs leading-normal">
                        <th class="py-3 px-6">Tanggal</th>
                        <th class="py-3 px-6">No. Ref</th>
                        <th class="py-3 px-6">Keterangan</th>
                        <th class="py-3 px-6">Akun</th>
                        <th class="py-3 px-6 text-right">Debet (Masuk)</th>
                        <th class="py-3 px-6 text-right">Kredit (Keluar)</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse($transactions as $t)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 whitespace-nowrap">{{ $t->tanggal->format('d M Y') }}</td>
                        <td class="py-3 px-6 font-mono text-xs text-gray-500">TRX-{{ str_pad($t->id_kas, 6, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-3 px-6">
                            <div class="flex flex-col">
                                <span class="font-medium">{{ $t->keterangan }}</span>
                                @if($t->jamaah)
                                    <span class="text-xs text-blue-600"><i class="fas fa-user mr-1"></i> {{ $t->jamaah->nama_lengkap }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="py-3 px-6">
                            <span class="bg-gray-100 text-gray-600 py-1 px-2 rounded text-xs">
                                {{ $t->kodeAkuntansi->keterangan ?? '-' }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-right font-medium text-emerald-600">
                            {{ in_array($t->jenis, ['Debet', 'DEBET']) ? number_format($t->jumlah, 0, ',', '.') : '-' }}
                        </td>
                        <td class="py-3 px-6 text-right font-medium text-red-600">
                            {{ in_array($t->jenis, ['Kredit', 'KREDIT']) ? number_format($t->jumlah, 0, ',', '.') : '-' }}
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center">
                                @if($t->bukti_transaksi)
                                <a href="{{ asset('storage/' . $t->bukti_transaksi) }}" target="_blank" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" title="Lihat Bukti">
                                    <i class="fas fa-file-invoice"></i>
                                </a>
                                @endif
                                <a href="{{ route('finance.edit', $t->id_kas) }}" class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('finance.destroy', $t->id_kas) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-4 mr-2 transform hover:text-red-500 hover:scale-110" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-6 px-6 text-center text-gray-500">
                            Tidak ada transaksi pada periode ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-gray-50 font-bold text-gray-700">
                    <tr>
                        <td colspan="4" class="py-3 px-6 text-right">Total Periode Ini:</td>
                        <td class="py-3 px-6 text-right text-emerald-700">{{ number_format($totalDebet, 0, ',', '.') }}</td>
                        <td class="py-3 px-6 text-right text-red-700">{{ number_format($totalKredit, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="p-4 border-t border-gray-200">
            {{ $transactions->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
