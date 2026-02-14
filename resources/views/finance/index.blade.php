<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Buku Kas & Transaksi') }}
            </h2>
            <div class="mt-4 md:mt-0 flex items-center space-x-3">
                <a href="{{ route('finance.report') }}" class="text-sm text-gray-600 hover:text-indigo-600 font-medium flex items-center transition">
                    <i class="fas fa-file-alt mr-2"></i> Laporan Detail
                </a>
                <span class="text-gray-300">|</span>
                <div class="text-sm text-gray-500">
                    <i class="fas fa-calendar-alt mr-2"></i> {{ \Carbon\Carbon::now()->format('d M Y') }}
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success Message -->
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg relative shadow-sm flex items-center" role="alert">
                    <i class="fas fa-check-circle mr-3 text-emerald-500 text-xl"></i>
                    <span class="block sm:inline font-medium">{{ session('success') }}</span>
                    <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3 text-emerald-500 hover:text-emerald-800 transition">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <!-- Summary Section & Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Cards Column -->
                <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Pemasukan Card -->
                    <div class="bg-emerald-50 rounded-xl p-6 shadow-sm border border-emerald-100 hover:shadow-md transition-all duration-300 relative overflow-hidden">
                        <div class="flex justify-between items-start relative z-10">
                            <div>
                                <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Pemasukan (Debet)</p>
                                <h3 class="text-2xl font-bold text-emerald-700 mt-2">Rp {{ number_format($totalDebet, 0, ',', '.') }}</h3>
                            </div>
                            <div class="p-2 bg-emerald-100 rounded-lg text-emerald-600 border border-emerald-200">
                                <i class="fas fa-arrow-down text-sm"></i>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-xs text-emerald-600/80 relative z-10">
                            <span class="font-bold mr-1">Total</span>
                            <span>pemasukan periode ini</span>
                        </div>
                        <!-- Decorative Blob -->
                        <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-emerald-100 rounded-full opacity-50 blur-xl"></div>
                    </div>

                    <!-- Pengeluaran Card -->
                    <div class="bg-red-50 rounded-xl p-6 shadow-sm border border-red-100 hover:shadow-md transition-all duration-300 relative overflow-hidden">
                        <div class="flex justify-between items-start relative z-10">
                            <div>
                                <p class="text-xs font-semibold text-red-600 uppercase tracking-wider">Pengeluaran (Kredit)</p>
                                <h3 class="text-2xl font-bold text-red-700 mt-2">Rp {{ number_format($totalKredit, 0, ',', '.') }}</h3>
                            </div>
                            <div class="p-2 bg-red-100 rounded-lg text-red-600 border border-red-200">
                                <i class="fas fa-arrow-up text-sm"></i>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-xs text-red-600/80 relative z-10">
                            <span class="font-bold mr-1">Total</span>
                            <span>pengeluaran periode ini</span>
                        </div>
                         <!-- Decorative Blob -->
                         <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-red-100 rounded-full opacity-50 blur-xl"></div>
                    </div>

                    <!-- Saldo Card (Full Width on Mobile) -->
                    <div class="sm:col-span-2 bg-blue-50 rounded-xl p-6 shadow-sm border border-blue-100 hover:shadow-md transition-all duration-300 relative overflow-hidden">
                        <div class="flex justify-between items-start relative z-10">
                            <div>
                                <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider">Saldo Akhir</p>
                                <h3 class="text-3xl font-bold text-blue-700 mt-2">Rp {{ number_format($openingBalance + $balance, 0, ',', '.') }}</h3>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-xl text-blue-600 border border-blue-200">
                                <i class="fas fa-wallet text-lg"></i>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-xs text-blue-600/80 relative z-10">
                            <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded mr-2 border border-blue-200 font-mono">Awal: Rp {{ number_format($openingBalance, 0, ',', '.') }}</span>
                        </div>
                         <!-- Decorative Blob -->
                         <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-blue-100 rounded-full opacity-50 blur-2xl"></div>
                    </div>
                </div>

                <!-- Chart Column -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col justify-center items-center relative">
                    <h4 class="text-sm font-semibold text-gray-600 mb-4 self-start">Proporsi Keuangan</h4>
                    <div class="relative w-48 h-48">
                        <canvas id="financeChart"></canvas>
                        <!-- Center Text -->
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div class="text-center">
                                <span class="block text-xs text-gray-400">Net</span>
                                <span class="block text-sm font-bold {{ ($totalDebet - $totalKredit) >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                    {{ number_format(($totalDebet - $totalKredit) / 1000000, 1, ',', '.') }}M
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center gap-4 mt-6 text-xs">
                        <div class="flex items-center">
                            <span class="w-3 h-3 rounded-full bg-emerald-500 mr-2"></span>
                            <span class="text-gray-600">Masuk</span>
                        </div>
                        <div class="flex items-center">
                            <span class="w-3 h-3 rounded-full bg-red-500 mr-2"></span>
                            <span class="text-gray-600">Keluar</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Header & Filter -->
                <div class="p-5 border-b border-gray-100 bg-white">
                    <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
                        <div class="flex items-center space-x-3 w-full lg:w-auto">
                            <div class="bg-indigo-50 p-2 rounded-lg text-indigo-600 border border-indigo-100">
                                <i class="fas fa-list-ul"></i>
                            </div>
                            <h2 class="text-lg font-bold text-gray-800">Riwayat Transaksi</h2>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                            <!-- Quick Date Filters -->
                            <div class="flex bg-gray-50 p-1 rounded-lg border border-gray-200">
                                <a href="{{ route('finance.index', ['start_date' => date('Y-m-d'), 'end_date' => date('Y-m-d')]) }}" 
                                   class="px-3 py-1.5 text-xs font-medium rounded-md transition {{ request('start_date') == date('Y-m-d') && request('end_date') == date('Y-m-d') ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                                    Hari Ini
                                </a>
                                <a href="{{ route('finance.index', ['start_date' => date('Y-m-01'), 'end_date' => date('Y-m-t')]) }}" 
                                   class="px-3 py-1.5 text-xs font-medium rounded-md transition {{ request('start_date') == date('Y-m-01') ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                                    Bulan Ini
                                </a>
                            </div>

                            <!-- Filter Form -->
                            <form action="{{ route('finance.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2">
                                <!-- Date Range Group -->
                                <div class="flex items-center space-x-2 bg-gray-50 p-1 rounded-lg border border-gray-200 hover:border-indigo-300 transition-colors focus-within:border-indigo-300 focus-within:ring focus-within:ring-indigo-200 focus-within:ring-opacity-50">
                                    <div class="relative">
                                        <input type="date" name="start_date" value="{{ $startDate }}" class="pl-2 pr-1 py-1.5 border-none rounded-md text-xs text-gray-600 focus:ring-0 bg-transparent w-24 font-medium">
                                    </div>
                                    <span class="text-gray-400 text-xs font-medium">-</span>
                                    <div class="relative">
                                        <input type="date" name="end_date" value="{{ $endDate }}" class="pl-2 pr-1 py-1.5 border-none rounded-md text-xs text-gray-600 focus:ring-0 bg-transparent w-24 font-medium">
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    <div class="relative w-32">
                                        <select name="type" class="w-full appearance-none bg-gray-50 border border-gray-200 text-gray-700 py-2 px-3 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-indigo-500 text-xs font-medium h-[38px] transition-colors">
                                            <option value="">Semua Jenis</option>
                                            <option value="Debet" {{ request('type') == 'Debet' ? 'selected' : '' }}>Pemasukan</option>
                                            <option value="Kredit" {{ request('type') == 'Kredit' ? 'selected' : '' }}>Pengeluaran</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                            <i class="fas fa-chevron-down text-[10px]"></i>
                                        </div>
                                    </div>

                                    <button type="submit" class="h-[38px] w-[38px] bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-200 flex items-center justify-center shadow-sm shadow-indigo-200" title="Terapkan Filter">
                                        <i class="fas fa-filter text-xs"></i>
                                    </button>

                                    <a href="{{ route('finance.create') }}" class="h-[38px] px-4 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition duration-200 text-xs font-bold flex items-center justify-center whitespace-nowrap shadow-sm shadow-emerald-200">
                                        <i class="fas fa-plus mr-1.5"></i> Baru
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase text-[10px] font-bold tracking-wider">
                                <th class="py-3 px-5">Tanggal</th>
                                <th class="py-3 px-5">No. Ref</th>
                                <th class="py-3 px-5">Keterangan</th>
                                <th class="py-3 px-5">Akun</th>
                                <th class="py-3 px-5 text-right">Debet</th>
                                <th class="py-3 px-5 text-right">Kredit</th>
                                <th class="py-3 px-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light divide-y divide-gray-50">
                            @forelse($transactions as $t)
                            <tr class="hover:bg-indigo-50/30 transition duration-150 group">
                                <td class="py-3 px-5 whitespace-nowrap align-middle">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-700 text-sm">{{ $t->tanggal->format('d') }}</span>
                                        <span class="text-[10px] text-gray-400 uppercase font-medium">{{ $t->tanggal->format('M Y') }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-5 align-middle">
                                    <span class="font-mono text-[10px] text-indigo-600 bg-indigo-50 px-2 py-1 rounded border border-indigo-100 font-medium">
                                        #{{ str_pad($t->id_kas, 6, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                <td class="py-3 px-5 align-middle">
                                    <div class="flex flex-col max-w-xs">
                                        <span class="font-medium text-gray-800 text-sm truncate" title="{{ $t->keterangan }}">{{ $t->keterangan }}</span>
                                        @if($t->jamaah)
                                            <div class="flex items-center mt-1 text-[10px] text-blue-600 bg-blue-50 px-2 py-0.5 rounded w-fit border border-blue-100">
                                                <i class="fas fa-user mr-1 opacity-70"></i> {{ $t->jamaah->nama_lengkap }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-5 align-middle">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                        {{ $t->kodeAkuntansi->keterangan ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-3 px-5 text-right align-middle">
                                    @if(in_array($t->jenis, ['Debet', 'DEBET']))
                                        <span class="font-bold text-emerald-600 text-sm bg-emerald-50 px-2 py-1 rounded border border-emerald-100">
                                            + {{ number_format($t->jumlah, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-gray-300 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-5 text-right align-middle">
                                    @if(in_array($t->jenis, ['Kredit', 'KREDIT']))
                                        <span class="font-bold text-red-600 text-sm bg-red-50 px-2 py-1 rounded border border-red-100">
                                            - {{ number_format($t->jumlah, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-gray-300 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-5 text-center align-middle">
                                    <div class="flex item-center justify-center space-x-1">
                                        @if($t->bukti_transaksi)
                                        <a href="{{ asset('storage/' . $t->bukti_transaksi) }}" target="_blank" class="w-7 h-7 rounded-lg bg-white border border-purple-200 text-purple-600 flex items-center justify-center hover:bg-purple-600 hover:text-white transition shadow-sm" title="Lihat Bukti">
                                            <i class="fas fa-file-invoice text-xs"></i>
                                        </a>
                                        @endif
                                        <a href="{{ route('finance.edit', $t->id_kas) }}" class="w-7 h-7 rounded-lg bg-white border border-blue-200 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition shadow-sm" title="Edit">
                                            <i class="fas fa-pencil-alt text-[10px]"></i>
                                        </a>
                                        <form action="{{ route('finance.destroy', $t->id_kas) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-7 h-7 rounded-lg bg-white border border-red-200 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition shadow-sm" title="Hapus">
                                                <i class="fas fa-trash-alt text-[10px]"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="py-12 px-6 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <div class="bg-gray-50 rounded-full p-4 mb-3">
                                            <i class="fas fa-inbox text-3xl text-gray-300"></i>
                                        </div>
                                        <p class="text-sm font-medium">Tidak ada transaksi pada periode ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-gray-50 font-bold text-gray-700 border-t border-gray-200">
                            <tr>
                                <td colspan="4" class="py-3 px-5 text-right text-[10px] uppercase tracking-wider text-gray-500">Total Periode Ini</td>
                                <td class="py-3 px-5 text-right text-emerald-700 font-extrabold text-sm">{{ number_format($totalDebet, 0, ',', '.') }}</td>
                                <td class="py-3 px-5 text-right text-red-700 font-extrabold text-sm">{{ number_format($totalKredit, 0, ',', '.') }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
                    {{ $transactions->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('financeChart').getContext('2d');
            const totalDebet = {{ $totalDebet }};
            const totalKredit = {{ $totalKredit }};
            
            // If both are 0, show a placeholder
            const data = (totalDebet === 0 && totalKredit === 0) 
                ? [1, 0] 
                : [totalDebet, totalKredit];
                
            const colors = (totalDebet === 0 && totalKredit === 0)
                ? ['#E5E7EB', '#E5E7EB']
                : ['#10B981', '#EF4444'];

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pemasukan', 'Pengeluaran'],
                    datasets: [{
                        data: data,
                        backgroundColor: colors,
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    cutout: '75%',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: (totalDebet !== 0 || totalKredit !== 0),
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed);
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>