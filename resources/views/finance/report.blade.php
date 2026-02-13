<x-app-layout>
    <x-slot name="header">
        Laporan Keuangan
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Filter Section -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('finance.report') }}" method="GET" class="flex flex-col md:flex-row items-end space-y-4 md:space-y-0 md:space-x-4">
                    <div>
                        <x-input-label for="start_date" :value="__('Dari Tanggal')" />
                        <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="$startDate" />
                    </div>
                    <div>
                        <x-input-label for="end_date" :value="__('Sampai Tanggal')" />
                        <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="$endDate" />
                    </div>
                    <div class="flex-1"></div>
                    <div>
                        <x-primary-button class="bg-gray-800 hover:bg-gray-700">
                            <i class="fas fa-filter mr-2"></i> {{ __('Tampilkan Laporan') }}
                        </x-primary-button>
                        <button type="button" onclick="window.print()" class="ml-2 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            <i class="fas fa-print mr-2"></i> Print
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-emerald-500">
                <p class="text-sm text-gray-500 uppercase font-semibold">Total Pemasukan</p>
                <h3 class="text-2xl font-bold text-emerald-600 mt-1">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
                <p class="text-sm text-gray-500 uppercase font-semibold">Total Pengeluaran</p>
                <h3 class="text-2xl font-bold text-red-600 mt-1">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 {{ $labaRugi >= 0 ? 'border-blue-500' : 'border-orange-500' }}">
                <p class="text-sm text-gray-500 uppercase font-semibold">Laba / Rugi Bersih</p>
                <h3 class="text-2xl font-bold {{ $labaRugi >= 0 ? 'text-blue-600' : 'text-orange-600' }} mt-1">
                    Rp {{ number_format($labaRugi, 0, ',', '.') }}
                </h3>
            </div>
        </div>

        <!-- Detailed Report -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Pemasukan -->
            <div class="bg-white shadow sm:rounded-lg overflow-hidden h-fit">
                <div class="px-6 py-4 border-b border-gray-200 bg-emerald-50">
                    <h3 class="text-lg font-semibold text-emerald-800">Rincian Pemasukan</h3>
                </div>
                <div class="p-6">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-2">Kode</th>
                                <th class="px-4 py-2">Akun</th>
                                <th class="px-4 py-2 text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pemasukan as $item)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3 font-mono">{{ $item->kode }}</td>
                                <td class="px-4 py-3">{{ $item->nama_akun }}</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-900">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-gray-500 italic">Belum ada data pemasukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="font-bold bg-gray-50 text-emerald-700">
                            <tr>
                                <td colspan="2" class="px-4 py-3 text-right">Total Pemasukan</td>
                                <td class="px-4 py-3 text-right">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Pengeluaran -->
            <div class="bg-white shadow sm:rounded-lg overflow-hidden h-fit">
                <div class="px-6 py-4 border-b border-gray-200 bg-red-50">
                    <h3 class="text-lg font-semibold text-red-800">Rincian Pengeluaran</h3>
                </div>
                <div class="p-6">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-2">Kode</th>
                                <th class="px-4 py-2">Akun</th>
                                <th class="px-4 py-2 text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengeluaran as $item)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3 font-mono">{{ $item->kode }}</td>
                                <td class="px-4 py-3">{{ $item->nama_akun }}</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-900">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-gray-500 italic">Belum ada data pengeluaran.</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="font-bold bg-gray-50 text-red-700">
                            <tr>
                                <td colspan="2" class="px-4 py-3 text-right">Total Pengeluaran</td>
                                <td class="px-4 py-3 text-right">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
