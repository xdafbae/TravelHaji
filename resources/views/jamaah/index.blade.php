<x-app-layout>
    <x-slot name="header">
        <!-- Not used in this theme -->
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Page Header & Actions -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-secondary-900 tracking-tight">Daftar Jamaah</h2>
                <p class="text-sm text-secondary-500 mt-1 font-medium">Kelola data jamaah travel umrah & haji</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('jamaah.export', request()->all()) }}" class="inline-flex items-center px-4 py-2 bg-white border border-secondary-300 rounded-lg font-semibold text-xs text-secondary-700 uppercase tracking-widest shadow-sm hover:bg-secondary-50 hover:text-primary-600 focus:outline-none transition ease-in-out duration-150">
                    <i class="fas fa-file-export mr-2"></i> Export
                </a>
                <a href="{{ route('jamaah.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 active:bg-primary-800 focus:outline-none shadow-md hover:shadow-lg transition ease-in-out duration-150">
                    <i class="fas fa-plus mr-2"></i> Tambah Jamaah
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card 1 -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-secondary-100 flex items-center justify-between hover:shadow-md transition-shadow duration-300">
                <div>
                    <p class="text-sm font-semibold text-secondary-500 uppercase tracking-wider mb-1">Total Jamaah</p>
                    <h3 class="text-3xl font-bold text-secondary-900">{{ number_format($stats['total']) }}</h3>
                </div>
                <div class="p-3 bg-primary-50 rounded-xl text-primary-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-secondary-100 flex items-center justify-between hover:shadow-md transition-shadow duration-300">
                <div>
                    <p class="text-sm font-semibold text-secondary-500 uppercase tracking-wider mb-1">Sudah Berangkat</p>
                    <h3 class="text-3xl font-bold text-secondary-900">{{ number_format($stats['sudah_berangkat']) }}</h3>
                </div>
                <div class="p-3 bg-success-50 rounded-xl text-success-600">
                    <i class="fas fa-plane-departure text-xl"></i>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-secondary-100 flex items-center justify-between hover:shadow-md transition-shadow duration-300">
                <div>
                    <p class="text-sm font-semibold text-secondary-500 uppercase tracking-wider mb-1">Belum Berangkat</p>
                    <h3 class="text-3xl font-bold text-secondary-900">{{ number_format($stats['belum_berangkat']) }}</h3>
                </div>
                <div class="p-3 bg-warning-50 rounded-xl text-warning-600">
                    <i class="fas fa-user-clock text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="bg-white rounded-2xl shadow-sm p-5 border border-secondary-100">
            <form action="{{ route('jamaah.index') }}" method="GET" class="flex flex-col gap-4">
                
                <!-- Quick Filter Tabs -->
                <div class="flex space-x-1 bg-secondary-100 p-1 rounded-lg w-full md:w-auto self-start overflow-x-auto">
                    <button type="submit" name="status" value="all" 
                        class="px-4 py-2 rounded-md text-sm font-bold transition-all whitespace-nowrap {{ request('status') == 'all' || !request('status') ? 'bg-white text-primary-600 shadow-sm' : 'text-secondary-500 hover:text-secondary-700' }}">
                        Semua
                    </button>
                    <button type="submit" name="status" value="Belum Berangkat" 
                        class="px-4 py-2 rounded-md text-sm font-bold transition-all whitespace-nowrap {{ request('status') == 'Belum Berangkat' ? 'bg-white text-primary-600 shadow-sm' : 'text-secondary-500 hover:text-secondary-700' }}">
                        Belum Berangkat
                    </button>
                    <button type="submit" name="status" value="Sudah Berangkat" 
                        class="px-4 py-2 rounded-md text-sm font-bold transition-all whitespace-nowrap {{ request('status') == 'Sudah Berangkat' ? 'bg-white text-primary-600 shadow-sm' : 'text-secondary-500 hover:text-secondary-700' }}">
                        Sudah Berangkat
                    </button>
                </div>

                <div class="flex flex-col md:flex-row gap-4 justify-between items-center w-full">
                    <div class="relative w-full md:w-1/2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-secondary-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, ID, atau No HP..." 
                            class="pl-10 w-full rounded-xl border-secondary-300 focus:border-primary-500 focus:ring focus:ring-primary-200 transition duration-200 text-sm py-2.5 text-secondary-700 font-medium placeholder-secondary-400">
                        
                        @if(request('search'))
                            <a href="{{ route('jamaah.index', ['status' => request('status')]) }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-secondary-400 hover:text-danger-500 transition-colors">
                                <i class="fas fa-times-circle"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition class="bg-success-50 border border-success-200 text-success-700 px-4 py-3 rounded-xl flex justify-between items-center shadow-sm">
                <div class="flex items-center font-medium">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-success-500 hover:text-success-700 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Content Table -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-secondary-100">
            
            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-secondary-50 text-secondary-500 uppercase text-xs font-bold tracking-wider border-b border-secondary-200">
                            <th class="py-4 px-6">Jamaah</th>
                            <th class="py-4 px-6">Kontak</th>
                            <th class="py-4 px-6">Status Keberangkatan</th>
                            <th class="py-4 px-6 text-center">Pembayaran</th>
                            <th class="py-4 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-secondary-100">
                        @forelse($jamaah as $j)
                        <tr class="hover:bg-secondary-50 transition-colors duration-200 group">
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        @if($j->foto_diri)
                                            <img class="h-10 w-10 rounded-full object-cover border-2 border-white shadow-sm" src="{{ Storage::url($j->foto_diri) }}" alt="{{ $j->nama_lengkap }}">
                                        @else
                                            <img class="h-10 w-10 rounded-full object-cover border-2 border-white shadow-sm" src="https://ui-avatars.com/api/?name={{ urlencode($j->nama_lengkap) }}&color=7F9CF5&background=EBF4FF" alt="{{ $j->nama_lengkap }}">
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-secondary-900">{{ $j->nama_lengkap }}</div>
                                        <div class="text-xs text-secondary-500 font-mono bg-secondary-100 px-1.5 py-0.5 rounded inline-block mt-0.5 border border-secondary-200">{{ $j->kode_jamaah }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-sm text-secondary-700 flex items-center font-medium">
                                    <i class="fas fa-phone text-secondary-400 text-xs mr-2 w-4"></i> {{ $j->no_hp ?? '-' }}
                                </div>
                                <div class="text-xs text-secondary-500 flex items-center mt-1">
                                    <i class="fas fa-venus-mars text-secondary-400 text-xs mr-2 w-4"></i> {{ $j->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                @php
                                    $statusColor = $j->status_keberangkatan == 'Sudah Berangkat' ? 'success' : 'warning';
                                    $statusIcon = $j->status_keberangkatan == 'Sudah Berangkat' ? 'check-circle' : 'clock';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-{{ $statusColor }}-50 text-{{ $statusColor }}-600 border border-{{ $statusColor }}-100">
                                    <i class="fas fa-{{ $statusIcon }} mr-1.5"></i>
                                    {{ $j->status_keberangkatan }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                @php
                                    $latestEmbarkasi = $j->embarkasi->first();
                                    $hargaPaket = $latestEmbarkasi ? $latestEmbarkasi->harga_paket : 0;
                                    $totalBayar = $j->total_bayar ?? 0;
                                    $persenBayar = $hargaPaket > 0 ? min(100, round(($totalBayar / $hargaPaket) * 100)) : 0;
                                    $paymentStatus = $latestEmbarkasi ? $latestEmbarkasi->pivot->payment_status : 'Belum Terdaftar';
                                    
                                    $barColor = 'bg-primary-500';
                                    if($persenBayar >= 100) $barColor = 'bg-success-500';
                                    elseif($persenBayar < 50) $barColor = 'bg-danger-500';
                                    elseif($persenBayar < 100) $barColor = 'bg-warning-500';
                                @endphp
                                
                                @if($latestEmbarkasi)
                                    <div class="w-full max-w-[180px] mx-auto">
                                        <div class="flex justify-between text-xs mb-1">
                                            <span class="font-bold {{ $persenBayar >= 100 ? 'text-success-600' : 'text-secondary-600' }}">
                                                {{ $paymentStatus }}
                                            </span>
                                            <span class="text-secondary-500 font-mono font-semibold">{{ $persenBayar }}%</span>
                                        </div>
                                        <div class="w-full bg-secondary-200 rounded-full h-1.5 mb-1 overflow-hidden">
                                            <div class="{{ $barColor }} h-1.5 rounded-full transition-all duration-1000 ease-out" style="width: {{ $persenBayar }}%"></div>
                                        </div>
                                        <div class="flex justify-between items-center text-[10px] text-secondary-500 font-medium">
                                            <span class="truncate max-w-[90px]" title="{{ $latestEmbarkasi->nama_paket ?? 'Paket' }}">
                                                {{ Str::limit($latestEmbarkasi->nama_paket ?? '-', 12) }}
                                            </span>
                                            <span class="font-mono text-right">
                                                {{ number_format($totalBayar, 0, ',', '.') }}{{ $hargaPaket > 0 ? ' / ' . number_format($hargaPaket, 0, ',', '.') : '' }}
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <span class="bg-secondary-100 text-secondary-500 py-1 px-3 rounded-full text-xs font-bold">
                                            Belum Terdaftar
                                        </span>
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('jamaah.show', $j->id_jamaah) }}" class="p-2 bg-white border border-secondary-200 rounded-lg text-secondary-500 hover:text-primary-600 hover:bg-secondary-50 hover:border-primary-200 transition-all shadow-sm" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('jamaah.edit', $j->id_jamaah) }}" class="p-2 bg-white border border-secondary-200 rounded-lg text-secondary-500 hover:text-warning-600 hover:bg-warning-50 hover:border-warning-200 transition-all shadow-sm" title="Edit Data">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('jamaah.destroy', $j->id_jamaah) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data {{ $j->nama_lengkap }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-white border border-secondary-200 rounded-lg text-secondary-500 hover:text-danger-600 hover:bg-danger-50 hover:border-danger-200 transition-all shadow-sm" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-secondary-50 rounded-full p-4 mb-3 border border-secondary-100">
                                        <i class="fas fa-users-slash text-secondary-300 text-4xl"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-secondary-900">Tidak ada data jamaah</h3>
                                    <p class="text-secondary-500 text-sm mt-1 max-w-sm">
                                        Data jamaah yang Anda cari tidak ditemukan. Coba ubah kata kunci pencarian atau filter status.
                                    </p>
                                    @if(request('search') || request('status'))
                                        <a href="{{ route('jamaah.index') }}" class="mt-4 text-primary-600 hover:text-primary-700 font-bold text-sm hover:underline">
                                            Bersihkan Filter
                                        </a>
                                    @else
                                        <a href="{{ route('jamaah.create') }}" class="mt-4 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm font-bold shadow-md transition-all">
                                            Tambah Jamaah Baru
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile List View (Stacked) -->
            <div class="md:hidden">
                <div class="divide-y divide-secondary-100">
                    @forelse($jamaah as $j)
                    <div class="p-4 bg-white space-y-3">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center space-x-3">
                                <div class="h-10 w-10 flex-shrink-0">
                                    @if($j->foto_diri)
                                        <img class="h-10 w-10 rounded-full object-cover border border-secondary-200" src="{{ Storage::url($j->foto_diri) }}" alt="{{ $j->nama_lengkap }}">
                                    @else
                                        <img class="h-10 w-10 rounded-full object-cover border border-secondary-200" src="https://ui-avatars.com/api/?name={{ urlencode($j->nama_lengkap) }}&color=7F9CF5&background=EBF4FF" alt="{{ $j->nama_lengkap }}">
                                    @endif
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-secondary-900">{{ $j->nama_lengkap }}</div>
                                    <div class="text-xs text-secondary-500 font-mono">{{ $j->kode_jamaah }}</div>
                                </div>
                            </div>
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="text-secondary-400 p-1 hover:text-secondary-600">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white rounded-xl shadow-lg border border-secondary-100 z-10 py-1" style="display: none;">
                                    <a href="{{ route('jamaah.show', $j->id_jamaah) }}" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-50 font-medium">Detail</a>
                                    <a href="{{ route('jamaah.edit', $j->id_jamaah) }}" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-50 font-medium">Edit</a>
                                    <form action="{{ route('jamaah.destroy', $j->id_jamaah) }}" method="POST" onsubmit="return confirm('Hapus data?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-danger-600 hover:bg-danger-50 font-medium">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-2 text-xs border-t border-secondary-50 pt-2">
                            <div class="text-secondary-500 font-medium">No HP:</div>
                            <div class="text-secondary-900 font-bold text-right">{{ $j->no_hp ?? '-' }}</div>
                            
                            <div class="text-secondary-500 font-medium">Status:</div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold {{ $j->status_keberangkatan == 'Sudah Berangkat' ? 'bg-success-50 text-success-700' : 'bg-warning-50 text-warning-700' }}">
                                    {{ $j->status_keberangkatan }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-secondary-500 text-sm font-medium">
                        Tidak ada data ditemukan.
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if($jamaah->hasPages())
            <div class="bg-white px-4 py-3 border-t border-secondary-200 sm:px-6">
                {{ $jamaah->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
