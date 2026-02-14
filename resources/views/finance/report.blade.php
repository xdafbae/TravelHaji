<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Laporan Keuangan') }}
            </h2>
            <div class="mt-4 md:mt-0 flex items-center space-x-3">
                <a href="{{ route('finance.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Transaksi
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Filter Section -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 mb-8">
                <div class="p-6">
                    <div class="flex items-center space-x-2 border-b border-gray-100 pb-4 mb-6">
                        <span class="bg-indigo-100 text-indigo-600 p-2 rounded-lg"><i class="fas fa-filter"></i></span>
                        <h3 class="text-lg font-bold text-gray-800">Filter Laporan</h3>
                    </div>

                    <form action="{{ route('finance.report') }}" method="GET">
                        <div class="flex flex-col lg:flex-row items-end gap-6">
                            <div class="w-full lg:w-1/3">
                                <x-input-label for="start_date" :value="__('Dari Tanggal')" class="mb-2" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar text-gray-400"></i>
                                    </div>
                                    <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="pl-10 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-colors">
                                </div>
                            </div>
                            
                            <div class="w-full lg:w-1/3">
                                <x-input-label for="end_date" :value="__('Sampai Tanggal')" class="mb-2" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar text-gray-400"></i>
                                    </div>
                                    <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" class="pl-10 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-colors">
                                </div>
                            </div>

                            <div class="w-full lg:w-1/3 flex gap-3">
                                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-4 rounded-lg shadow-lg shadow-indigo-200 transition duration-200 flex items-center justify-center transform hover:-translate-y-0.5">
                                    <i class="fas fa-search mr-2"></i> Tampilkan
                                </button>
                                
                                <!-- Export Dropdown -->
                                <div class="relative" x-data="{ open: false }">
                                    <button type="button" @click="open = !open" @click.away="open = false" class="bg-white border border-gray-300 text-gray-700 font-semibold py-2.5 px-4 rounded-lg hover:bg-gray-50 transition duration-200 flex items-center justify-center shadow-sm">
                                        <i class="fas fa-download mr-2"></i> Export
                                        <i class="fas fa-chevron-down ml-2 text-xs"></i>
                                    </button>
                                    <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-100" style="display: none;">
                                        <a href="{{ route('finance.export.excel', request()->all()) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-indigo-600">
                                            <i class="fas fa-file-excel mr-2 text-green-600"></i> Export Excel
                                        </a>
                                        <a href="{{ route('finance.export.pdf', request()->all()) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-indigo-600">
                                            <i class="fas fa-file-pdf mr-2 text-red-600"></i> Export PDF
                                        </a>
                                        <button type="button" onclick="window.print()" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-indigo-600">
                                            <i class="fas fa-print mr-2 text-gray-500"></i> Print View
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quick Filters -->
                        <div class="mt-6 flex flex-wrap gap-2">
                            <span class="text-sm text-gray-500 self-center mr-2">Filter Cepat:</span>
                            <a href="{{ route('finance.report', ['start_date' => date('Y-m-01'), 'end_date' => date('Y-m-t')]) }}" class="px-3 py-1 text-xs font-medium rounded-full border {{ request('start_date') == date('Y-m-01') ? 'bg-indigo-50 border-indigo-200 text-indigo-700' : 'border-gray-200 text-gray-600 hover:bg-gray-50' }} transition">Bulan Ini</a>
                            <a href="{{ route('finance.report', ['start_date' => date('Y-01-01'), 'end_date' => date('Y-12-31')]) }}" class="px-3 py-1 text-xs font-medium rounded-full border {{ request('start_date') == date('Y-01-01') ? 'bg-indigo-50 border-indigo-200 text-indigo-700' : 'border-gray-200 text-gray-600 hover:bg-gray-50' }} transition">Tahun Ini</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Pemasukan -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-emerald-100 relative overflow-hidden group">
                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Total Pemasukan</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ \App\Helpers\CurrencyHelper::formatRupiah($totalPemasukan) }}</h3>
                        </div>
                        <div class="p-2 bg-emerald-100 rounded-lg text-emerald-600">
                            <i class="fas fa-arrow-down"></i>
                        </div>
                    </div>
                    <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-emerald-50 rounded-full opacity-50 blur-xl group-hover:scale-110 transition-transform duration-500"></div>
                </div>

                <!-- Pengeluaran -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-red-100 relative overflow-hidden group">
                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <p class="text-xs font-bold text-red-600 uppercase tracking-wider">Total Pengeluaran</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ \App\Helpers\CurrencyHelper::formatRupiah($totalPengeluaran) }}</h3>
                        </div>
                        <div class="p-2 bg-red-100 rounded-lg text-red-600">
                            <i class="fas fa-arrow-up"></i>
                        </div>
                    </div>
                    <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-red-50 rounded-full opacity-50 blur-xl group-hover:scale-110 transition-transform duration-500"></div>
                </div>

                <!-- Laba Rugi -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border {{ $labaRugi >= 0 ? 'border-blue-100' : 'border-orange-100' }} relative overflow-hidden group">
                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <p class="text-xs font-bold {{ $labaRugi >= 0 ? 'text-blue-600' : 'text-orange-600' }} uppercase tracking-wider">Laba / Rugi Bersih</p>
                            <h3 class="text-2xl font-bold {{ $labaRugi >= 0 ? 'text-blue-600' : 'text-orange-600' }} mt-2">
                                {{ \App\Helpers\CurrencyHelper::formatRupiah($labaRugi) }}
                            </h3>
                        </div>
                        <div class="p-2 {{ $labaRugi >= 0 ? 'bg-blue-100 text-blue-600' : 'bg-orange-100 text-orange-600' }} rounded-lg">
                            <i class="fas {{ $labaRugi >= 0 ? 'fa-wallet' : 'fa-exclamation-circle' }}"></i>
                        </div>
                    </div>
                    <div class="absolute -bottom-6 -right-6 w-24 h-24 {{ $labaRugi >= 0 ? 'bg-blue-50' : 'bg-orange-50' }} rounded-full opacity-50 blur-xl group-hover:scale-110 transition-transform duration-500"></div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Bar Chart -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h4 class="text-base font-bold text-gray-800 mb-4">Grafik Arus Kas</h4>
                    <div class="h-64">
                        <canvas id="cashflowChart"></canvas>
                    </div>
                </div>
                
                <!-- Pie Chart -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h4 class="text-base font-bold text-gray-800 mb-4">Komposisi Pengeluaran</h4>
                    <div class="h-64 relative flex justify-center">
                        <canvas id="expenseChart"></canvas>
                        @if($totalPengeluaran == 0)
                            <div class="absolute inset-0 flex items-center justify-center text-gray-400 text-sm">
                                Belum ada data
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Detailed Report Tables -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Pemasukan -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full">
                    <div class="px-6 py-4 border-b border-gray-100 bg-emerald-50/50 flex justify-between items-center">
                        <div class="flex items-center space-x-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <h3 class="text-base font-bold text-gray-800">Rincian Pemasukan</h3>
                        </div>
                        <span class="text-xs font-semibold text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full">{{ count($pemasukan) }} Kategori</span>
                    </div>
                    <div class="flex-grow">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-500 uppercase bg-gray-50/50 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-3 font-medium">Akun</th>
                                    <th class="px-6 py-3 text-right font-medium">Jumlah</th>
                                    <th class="px-6 py-3 text-right font-medium text-xs">%</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($pemasukan as $item)
                                <tr class="hover:bg-gray-50/80 transition-colors">
                                    <td class="px-6 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-gray-700">{{ $item->nama_akun }}</span>
                                            <span class="text-xs text-gray-400 font-mono">{{ $item->kode }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-right font-semibold text-gray-700">{{ \App\Helpers\CurrencyHelper::formatRupiah($item->total) }}</td>
                                    <td class="px-6 py-3 text-right text-xs text-gray-400">
                                        {{ $totalPemasukan > 0 ? number_format(($item->total / $totalPemasukan) * 100, 1) : 0 }}%
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-gray-400 italic">Belum ada data pemasukan periode ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-gray-600 uppercase text-xs tracking-wider">Total</span>
                            <span class="font-bold text-emerald-600 text-lg">{{ \App\Helpers\CurrencyHelper::formatRupiah($totalPemasukan) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Pengeluaran -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full">
                    <div class="px-6 py-4 border-b border-gray-100 bg-red-50/50 flex justify-between items-center">
                        <div class="flex items-center space-x-2">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span>
                            <h3 class="text-base font-bold text-gray-800">Rincian Pengeluaran</h3>
                        </div>
                        <span class="text-xs font-semibold text-red-600 bg-red-100 px-2 py-1 rounded-full">{{ count($pengeluaran) }} Kategori</span>
                    </div>
                    <div class="flex-grow">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-500 uppercase bg-gray-50/50 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-3 font-medium">Akun</th>
                                    <th class="px-6 py-3 text-right font-medium">Jumlah</th>
                                    <th class="px-6 py-3 text-right font-medium text-xs">%</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($pengeluaran as $item)
                                <tr class="hover:bg-gray-50/80 transition-colors">
                                    <td class="px-6 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-gray-700">{{ $item->nama_akun }}</span>
                                            <span class="text-xs text-gray-400 font-mono">{{ $item->kode }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-right font-semibold text-gray-700">{{ \App\Helpers\CurrencyHelper::formatRupiah($item->total) }}</td>
                                    <td class="px-6 py-3 text-right text-xs text-gray-400">
                                        {{ $totalPengeluaran > 0 ? number_format(($item->total / $totalPengeluaran) * 100, 1) : 0 }}%
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-gray-400 italic">Belum ada data pengeluaran periode ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-gray-600 uppercase text-xs tracking-wider">Total</span>
                            <span class="font-bold text-red-600 text-lg">{{ \App\Helpers\CurrencyHelper::formatRupiah($totalPengeluaran) }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Bar Chart: Cashflow
            const ctxCashflow = document.getElementById('cashflowChart').getContext('2d');
            new Chart(ctxCashflow, {
                type: 'bar',
                data: {
                    labels: ['Pemasukan', 'Pengeluaran'],
                    datasets: [{
                        label: 'Total (Rp)',
                        data: [{{ $totalPemasukan }}, {{ $totalPengeluaran }}],
                        backgroundColor: ['#10B981', '#EF4444'],
                        borderRadius: 8,
                        barThickness: 60
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#F3F4F6' },
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });

            // Pie Chart: Expense Breakdown
            const ctxExpense = document.getElementById('expenseChart').getContext('2d');
            const expenseLabels = {!! json_encode($pengeluaran->pluck('nama_akun')) !!};
            const expenseData = {!! json_encode($pengeluaran->pluck('total')) !!};
            
            // Generate soft colors
            const backgroundColors = [
                '#EF4444', '#F87171', '#FCA5A5', '#FECACA', '#FEE2E2',
                '#F59E0B', '#FBBF24', '#FCD34D', '#FDE68A', '#FEF3C7'
            ];

            if (expenseData.length > 0) {
                new Chart(ctxExpense, {
                    type: 'doughnut',
                    data: {
                        labels: expenseLabels,
                        datasets: [{
                            data: expenseData,
                            backgroundColor: backgroundColors.slice(0, expenseData.length),
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: { boxWidth: 12, font: { size: 11 } }
                            }
                        },
                        cutout: '60%'
                    }
                });
            }
        });
    </script>
</x-app-layout>