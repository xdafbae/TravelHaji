<x-app-layout>
    <x-slot name="header">
        {{ __('Data Jamaah') }}
    </x-slot>

    <!-- Page Header & Actions -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Daftar Jamaah</h2>
            <p class="text-sm text-gray-500">Kelola data jamaah travel umrah & haji</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('jamaah.export', request()->all()) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                <i class="fas fa-file-export mr-2"></i> Export
            </a>
            <a href="{{ route('jamaah.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 active:bg-emerald-800 focus:outline-none focus:border-emerald-800 focus:ring ring-emerald-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-md">
                <i class="fas fa-plus mr-2"></i> Tambah Jamaah
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Card 1 -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Jamaah</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ number_format($stats['total']) }}</h3>
            </div>
            <div class="p-3 bg-blue-50 rounded-full text-blue-600">
                <i class="fas fa-users text-xl"></i>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-emerald-500 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Sudah Berangkat</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ number_format($stats['sudah_berangkat']) }}</h3>
            </div>
            <div class="p-3 bg-emerald-50 rounded-full text-emerald-600">
                <i class="fas fa-plane-departure text-xl"></i>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Belum Berangkat</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ number_format($stats['belum_berangkat']) }}</h3>
            </div>
            <div class="p-3 bg-yellow-50 rounded-full text-yellow-600">
                <i class="fas fa-user-clock text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <form action="{{ route('jamaah.index') }}" method="GET" class="flex flex-col gap-4">
            
            <!-- Quick Filter Tabs -->
            <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg w-full md:w-auto self-start overflow-x-auto">
                <button type="submit" name="status" value="all" 
                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors whitespace-nowrap {{ request('status') == 'all' || !request('status') ? 'bg-white text-emerald-700 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Semua
                </button>
                <button type="submit" name="status" value="Belum Berangkat" 
                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors whitespace-nowrap {{ request('status') == 'Belum Berangkat' ? 'bg-white text-emerald-700 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Belum Berangkat
                </button>
                <button type="submit" name="status" value="Sudah Berangkat" 
                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors whitespace-nowrap {{ request('status') == 'Sudah Berangkat' ? 'bg-white text-emerald-700 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Sudah Berangkat
                </button>
            </div>

            <div class="flex flex-col md:flex-row gap-4 justify-between items-center w-full">
                <div class="relative w-full md:w-1/2">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, ID, atau No HP..." 
                        class="pl-10 w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition duration-200 text-sm py-2.5">
                    
                    @if(request('search'))
                        <a href="{{ route('jamaah.index', ['status' => request('status')]) }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times-circle"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg flex justify-between items-center shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Content Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider border-b border-gray-200">
                        <th class="py-4 px-6 font-semibold">Jamaah</th>
                        <th class="py-4 px-6 font-semibold">Kontak</th>
                        <th class="py-4 px-6 font-semibold">Status Keberangkatan</th>
                        <th class="py-4 px-6 font-semibold text-center">Pembayaran</th>
                        <th class="py-4 px-6 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($jamaah as $j)
                    <tr class="hover:bg-gray-50 transition-colors duration-200 group">
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0">
                                    @if($j->foto_diri)
                                        <img class="h-10 w-10 rounded-full object-cover border border-gray-200" src="{{ Storage::url($j->foto_diri) }}" alt="{{ $j->nama_lengkap }}">
                                    @else
                                        <img class="h-10 w-10 rounded-full object-cover border border-gray-200" src="https://ui-avatars.com/api/?name={{ urlencode($j->nama_lengkap) }}&color=7F9CF5&background=EBF4FF" alt="{{ $j->nama_lengkap }}">
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $j->nama_lengkap }}</div>
                                    <div class="text-xs text-gray-500 font-mono bg-gray-100 px-1.5 py-0.5 rounded inline-block mt-0.5">{{ $j->kode_jamaah }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="text-sm text-gray-900 flex items-center">
                                <i class="fas fa-phone text-gray-400 text-xs mr-2 w-4"></i> {{ $j->no_hp ?? '-' }}
                            </div>
                            <div class="text-xs text-gray-500 flex items-center mt-1">
                                <i class="fas fa-venus-mars text-gray-400 text-xs mr-2 w-4"></i> {{ $j->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            @php
                                $statusColor = $j->status_keberangkatan == 'Sudah Berangkat' ? 'emerald' : 'amber';
                                $statusIcon = $j->status_keberangkatan == 'Sudah Berangkat' ? 'check-circle' : 'clock';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800">
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
                                
                                $barColor = 'bg-blue-500';
                                if($persenBayar >= 100) $barColor = 'bg-emerald-500';
                                elseif($persenBayar < 50) $barColor = 'bg-rose-500';
                                elseif($persenBayar < 100) $barColor = 'bg-amber-500';
                            @endphp
                            
                            @if($latestEmbarkasi)
                                <div class="w-full max-w-[180px] mx-auto">
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="font-medium {{ $persenBayar >= 100 ? 'text-emerald-600' : 'text-gray-600' }}">
                                            {{ $paymentStatus }}
                                        </span>
                                        <span class="text-gray-500 font-mono">{{ $persenBayar }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-1.5 mb-1 overflow-hidden">
                                        <div class="{{ $barColor }} h-1.5 rounded-full transition-all duration-1000 ease-out" style="width: {{ $persenBayar }}%"></div>
                                    </div>
                                    <div class="flex justify-between items-center text-[10px] text-gray-500">
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
                                    <span class="bg-gray-100 text-gray-500 py-1 px-3 rounded-full text-xs font-medium">
                                        Belum Terdaftar
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex items-center justify-center space-x-3">
                                <a href="{{ route('jamaah.show', $j->id_jamaah) }}" class="text-gray-500 hover:text-blue-600 transition-colors" title="Lihat Detail">
                                    <i class="fas fa-eye text-lg"></i>
                                </a>
                                <a href="{{ route('jamaah.edit', $j->id_jamaah) }}" class="text-gray-500 hover:text-amber-500 transition-colors" title="Edit Data">
                                    <i class="fas fa-edit text-lg"></i>
                                </a>
                                <form action="{{ route('jamaah.destroy', $j->id_jamaah) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data {{ $j->nama_lengkap }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-500 hover:text-red-600 transition-colors" title="Hapus">
                                        <i class="fas fa-trash-alt text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="bg-gray-50 rounded-full p-4 mb-3">
                                    <i class="fas fa-users-slash text-gray-300 text-4xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900">Tidak ada data jamaah</h3>
                                <p class="text-gray-500 text-sm mt-1 max-w-sm">
                                    Data jamaah yang Anda cari tidak ditemukan. Coba ubah kata kunci pencarian atau filter status.
                                </p>
                                @if(request('search') || request('status'))
                                    <a href="{{ route('jamaah.index') }}" class="mt-4 text-emerald-600 hover:text-emerald-700 font-medium text-sm">
                                        Bersihkan Filter
                                    </a>
                                @else
                                    <a href="{{ route('jamaah.create') }}" class="mt-4 px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 text-sm font-medium">
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
            <div class="divide-y divide-gray-100">
                @forelse($jamaah as $j)
                <div class="p-4 bg-white space-y-3">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 flex-shrink-0">
                                @if($j->foto_diri)
                                    <img class="h-10 w-10 rounded-full object-cover border border-gray-200" src="{{ Storage::url($j->foto_diri) }}" alt="{{ $j->nama_lengkap }}">
                                @else
                                    <img class="h-10 w-10 rounded-full object-cover border border-gray-200" src="https://ui-avatars.com/api/?name={{ urlencode($j->nama_lengkap) }}&color=7F9CF5&background=EBF4FF" alt="{{ $j->nama_lengkap }}">
                                @endif
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-900">{{ $j->nama_lengkap }}</div>
                                <div class="text-xs text-gray-500 font-mono">{{ $j->kode_jamaah }}</div>
                            </div>
                        </div>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="text-gray-400 p-1">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg border border-gray-100 z-10 py-1">
                                <a href="{{ route('jamaah.edit', $j->id_jamaah) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Edit</a>
                                <form action="{{ route('jamaah.destroy', $j->id_jamaah) }}" method="POST" onsubmit="return confirm('Hapus data?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div class="text-gray-500">No HP:</div>
                        <div class="text-gray-900 font-medium text-right">{{ $j->no_hp ?? '-' }}</div>
                        
                        <div class="text-gray-500">Status:</div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $j->status_keberangkatan == 'Sudah Berangkat' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $j->status_keberangkatan }}
                            </span>
                        </div>
                    </div>
                    
                    @php
                        $latestEmbarkasi = $j->embarkasi->first();
                        $hargaPaket = $latestEmbarkasi ? $latestEmbarkasi->harga_paket : 0;
                        $totalBayar = $j->total_bayar ?? 0;
                        $persenBayar = $hargaPaket > 0 ? min(100, round(($totalBayar / $hargaPaket) * 100)) : 0;
                        $paymentStatus = $latestEmbarkasi ? $latestEmbarkasi->pivot->payment_status : 'Belum Terdaftar';
                    @endphp
                    
                    @if($latestEmbarkasi)
                    <div class="pt-2 border-t border-gray-50">
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-gray-500">Pembayaran</span>
                            <span class="font-medium {{ $persenBayar >= 100 ? 'text-emerald-600' : 'text-gray-600' }}">{{ $paymentStatus }} ({{ $persenBayar }}%)</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-1.5">
                            <div class="{{ $persenBayar >= 100 ? 'bg-emerald-500' : ($persenBayar < 50 ? 'bg-rose-500' : 'bg-amber-500') }} h-1.5 rounded-full" style="width: {{ $persenBayar }}%"></div>
                        </div>
                        <div class="mt-1 flex justify-between items-center text-[11px] text-gray-500">
                            <span class="truncate max-w-[120px]" title="{{ $latestEmbarkasi->nama_paket ?? 'Paket' }}">
                                {{ Str::limit($latestEmbarkasi->nama_paket ?? '-', 16) }}
                            </span>
                            <span class="font-mono text-right">
                                {{ number_format($totalBayar, 0, ',', '.') }}{{ $hargaPaket > 0 ? ' / ' . number_format($hargaPaket, 0, ',', '.') : '' }}
                            </span>
                        </div>
                    </div>
                    @endif
                </div>
                @empty
                <div class="p-8 text-center text-gray-500 text-sm">
                    Tidak ada data ditemukan.
                </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        @if($jamaah->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $jamaah->withQueryString()->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
