<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-800 flex items-center">
                <span class="w-2 h-8 bg-gradient-to-b from-emerald-500 to-teal-600 rounded-r-md mr-3 shadow-sm"></span>
                {{ __('Jadwal Keberangkatan') }}
            </h2>
        </div>
    </x-slot>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Card 1: Blue Theme -->
        <div class="bg-gradient-to-br from-blue-50 to-white overflow-hidden shadow-sm hover:shadow-lg hover:shadow-blue-100/50 transition-all duration-300 rounded-2xl border border-blue-100 p-6 group relative">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-100 rounded-full opacity-20 group-hover:scale-125 transition-transform duration-500"></div>
            <div class="flex items-center relative z-10">
                <div class="p-3.5 rounded-xl bg-white text-blue-600 shadow-sm mr-4 group-hover:scale-110 transition-transform duration-300 ring-1 ring-blue-100">
                    <i class="fas fa-plane-departure text-xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-blue-500 uppercase tracking-wider">Keberangkatan Bulan Ini</p>
                    <p class="text-2xl font-black text-gray-800 mt-1 group-hover:text-blue-600 transition-colors">{{ $jadwalBulanIni }}</p>
                </div>
            </div>
        </div>

        <!-- Card 2: Emerald Theme -->
        <div class="bg-gradient-to-br from-emerald-50 to-white overflow-hidden shadow-sm hover:shadow-lg hover:shadow-emerald-100/50 transition-all duration-300 rounded-2xl border border-emerald-100 p-6 group relative">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-emerald-100 rounded-full opacity-20 group-hover:scale-125 transition-transform duration-500"></div>
            <div class="flex items-center relative z-10">
                <div class="p-3.5 rounded-xl bg-white text-emerald-600 shadow-sm mr-4 group-hover:scale-110 transition-transform duration-300 ring-1 ring-emerald-100">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-emerald-500 uppercase tracking-wider">Total Jamaah Terdaftar</p>
                    <p class="text-2xl font-black text-gray-800 mt-1 group-hover:text-emerald-600 transition-colors">{{ number_format($totalJamaahTerdaftar) }}</p>
                </div>
            </div>
        </div>

        <!-- Card 3: Purple Theme -->
        <div class="bg-gradient-to-br from-purple-50 to-white overflow-hidden shadow-sm hover:shadow-lg hover:shadow-purple-100/50 transition-all duration-300 rounded-2xl border border-purple-100 p-6 group relative">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-purple-100 rounded-full opacity-20 group-hover:scale-125 transition-transform duration-500"></div>
            <div class="flex items-center relative z-10">
                <div class="p-3.5 rounded-xl bg-white text-purple-600 shadow-sm mr-4 group-hover:scale-110 transition-transform duration-300 ring-1 ring-purple-100">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-purple-500 uppercase tracking-wider">Total Jadwal Aktif</p>
                    <p class="text-2xl font-black text-gray-800 mt-1 group-hover:text-purple-600 transition-colors">{{ $totalJadwal }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white overflow-hidden shadow-md rounded-2xl border border-gray-100" x-data="{ 
        view: 'table', 
        selected: [], 
        allSelected: false,
        toggleAll() {
            this.allSelected = !this.allSelected;
            if (this.allSelected) {
                // Select all IDs on current page
                this.selected = [{{ $embarkasi->map(fn($e) => $e->id_embarkasi)->implode(',') }}];
            } else {
                this.selected = [];
            }
        },
        toggleSelect(id) {
            if (this.selected.includes(id)) {
                this.selected = this.selected.filter(item => item !== id);
            } else {
                this.selected.push(id);
            }
            this.allSelected = this.selected.length === {{ $embarkasi->count() }};
        }
    }">
        
        <!-- Toolbar & Filter -->
        <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex flex-col md:flex-row justify-between items-center gap-4">
            <!-- View Toggler & Add Button Group -->
            <div class="flex items-center space-x-4 w-full md:w-auto">
                <a href="{{ route('embarkasi.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-wider hover:from-emerald-600 hover:to-teal-700 active:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    <i class="fas fa-plus mr-2"></i> Buat Jadwal Baru
                </a>
                
                <div class="h-8 w-px bg-gray-300 mx-2 hidden md:block"></div>

                <div class="bg-white p-1 rounded-xl border border-gray-200 flex shadow-sm">
                    <button @click="view = 'table'" :class="{ 'bg-emerald-50 text-emerald-600 font-bold shadow-sm ring-1 ring-emerald-100': view === 'table', 'text-gray-400 hover:text-gray-600': view !== 'table' }" class="px-3 py-1.5 rounded-lg text-sm transition-all flex items-center">
                        <i class="fas fa-list mr-2"></i> List
                    </button>
                    <button @click="view = 'grid'" :class="{ 'bg-emerald-50 text-emerald-600 font-bold shadow-sm ring-1 ring-emerald-100': view === 'grid', 'text-gray-400 hover:text-gray-600': view !== 'grid' }" class="px-3 py-1.5 rounded-lg text-sm transition-all flex items-center">
                        <i class="fas fa-th-large mr-2"></i> Grid
                    </button>
                </div>
            </div>

            <!-- Search & Filter Form -->
            <form method="GET" action="{{ route('embarkasi.index') }}" class="flex flex-col sm:flex-row w-full md:w-auto justify-end gap-3">
                <!-- Status Filter (Tabs Style) -->
                <div class="flex bg-gray-100 p-1 rounded-xl border border-gray-200">
                    <button type="button" onclick="window.location.href='{{ route('embarkasi.index') }}'" class="px-4 py-2 rounded-lg text-xs font-bold transition-all {{ !request('status') ? 'bg-white text-emerald-600 shadow-sm ring-1 ring-gray-200' : 'text-gray-500 hover:text-emerald-600 hover:bg-emerald-50' }}">
                        Semua
                    </button>
                    <button type="button" onclick="window.location.href='{{ route('embarkasi.index', ['status' => 'Belum Berangkat']) }}'" class="px-4 py-2 rounded-lg text-xs font-bold transition-all {{ request('status') == 'Belum Berangkat' ? 'bg-amber-100 text-amber-700 shadow-sm ring-1 ring-amber-200' : 'text-gray-500 hover:text-amber-600 hover:bg-amber-50' }}">
                        Belum
                    </button>
                    <button type="button" onclick="window.location.href='{{ route('embarkasi.index', ['status' => 'Sudah Berangkat']) }}'" class="px-4 py-2 rounded-lg text-xs font-bold transition-all {{ request('status') == 'Sudah Berangkat' ? 'bg-blue-100 text-blue-700 shadow-sm ring-1 ring-blue-200' : 'text-gray-500 hover:text-blue-600 hover:bg-blue-50' }}">
                        Sudah
                    </button>
                    <button type="button" onclick="window.location.href='{{ route('embarkasi.index', ['status' => 'Selesai']) }}'" class="px-4 py-2 rounded-lg text-xs font-bold transition-all {{ request('status') == 'Selesai' ? 'bg-emerald-100 text-emerald-700 shadow-sm ring-1 ring-emerald-200' : 'text-gray-500 hover:text-emerald-600 hover:bg-emerald-50' }}">
                        Selesai
                    </button>
                </div>

                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2.5 border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm transition-all" placeholder="Cari kode, paket, kota...">
                </div>
            </form>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mx-6 mt-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 px-4 py-3 rounded-r-lg flex items-center shadow-sm" role="alert">
                <i class="fas fa-check-circle mr-3 text-lg"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Table View -->
        <div x-show="view === 'table'" class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gradient-to-r from-emerald-50/80 to-teal-50/80 text-emerald-700 uppercase text-xs tracking-wider border-b border-emerald-100">
                        <th class="py-4 px-6 w-16 text-center">
                            <input type="checkbox" @click="toggleAll()" x-model="allSelected" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 w-4 h-4 cursor-pointer">
                        </th>
                        <th class="py-4 px-6 font-bold cursor-pointer hover:text-emerald-800 transition-colors group">
                            Jadwal & Paket <i class="fas fa-sort ml-1 text-emerald-300 group-hover:text-emerald-600"></i>
                        </th>
                        <th class="py-4 px-6 font-bold cursor-pointer hover:text-emerald-800 transition-colors group">
                            Kota Asal <i class="fas fa-sort ml-1 text-emerald-300 group-hover:text-emerald-600"></i>
                        </th>
                        <th class="py-4 px-6 font-bold cursor-pointer hover:text-emerald-800 transition-colors group">
                            Kapasitas <i class="fas fa-sort ml-1 text-emerald-300 group-hover:text-emerald-600"></i>
                        </th>
                        <th class="py-4 px-6 font-bold">Status</th>
                        <th class="py-4 px-6 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($embarkasi as $e)
                    <tr onclick="window.location='{{ route('embarkasi.show', $e->id_embarkasi) }}'" class="hover:bg-gradient-to-r hover:from-emerald-50/40 hover:to-teal-50/40 transition-colors group cursor-pointer relative">
                        <td class="py-4 px-6 text-center" onclick="event.stopPropagation()">
                            <input type="checkbox" :value="{{ $e->id_embarkasi }}" x-model="selected" @click="toggleSelect({{ $e->id_embarkasi }})" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 w-4 h-4 cursor-pointer">
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex flex-col">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs font-mono font-bold bg-gray-100 text-gray-600 px-2 py-0.5 rounded border border-gray-200">{{ $e->kode_embarkasi }}</span>
                                    <span class="text-xs text-gray-300">•</span>
                                    <span class="text-sm font-medium text-gray-500 flex items-center">
                                        <i class="far fa-calendar mr-1"></i> {{ $e->waktu_keberangkatan->format('d M Y') }}
                                    </span>
                                </div>
                                <span class="font-bold text-gray-800 text-base group-hover:text-emerald-600 transition-colors">{{ $e->paket_haji_umroh }}</span>
                                <span class="text-sm text-gray-500 mt-0.5 flex items-center">
                                    <i class="fas fa-plane text-xs mr-1.5 text-gray-400"></i> {{ $e->maskapai ?? 'Maskapai belum set' }}
                                </span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center text-gray-700 font-medium text-sm">
                                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 mr-3">
                                    <i class="fas fa-map-marker-alt text-xs"></i>
                                </div>
                                {{ $e->kota_keberangkatan }}
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="w-48 group/tooltip relative">
                                <div class="flex justify-between text-xs mb-1.5 font-semibold">
                                    <span class="text-gray-700 text-sm">{{ $e->jumlah_jamaah }} Terdaftar</span>
                                    <span class="text-gray-400 text-xs">dari {{ $e->kapasitas_jamaah }}</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden shadow-inner relative" title="{{ $e->jumlah_jamaah }} jamaah dari {{ $e->kapasitas_jamaah }} kursi ({{ $e->kapasitas_jamaah > 0 ? round(($e->jumlah_jamaah / $e->kapasitas_jamaah) * 100) : 0 }}%)">
                                    @php
                                        $percentage = $e->kapasitas_jamaah > 0 ? ($e->jumlah_jamaah / $e->kapasitas_jamaah) * 100 : 0;
                                        $color = $percentage > 90 ? 'bg-gradient-to-r from-red-400 to-red-500' : ($percentage > 70 ? 'bg-gradient-to-r from-amber-400 to-amber-500' : 'bg-gradient-to-r from-emerald-400 to-emerald-500');
                                    @endphp
                                    <div class="{{ $color }} h-2 rounded-full transition-all duration-700 ease-out" style="width: {{ $percentage }}%"></div>
                                </div>
                                <!-- Custom Tooltip -->
                                <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover/tooltip:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-10 shadow-lg">
                                    {{ $e->jumlah_jamaah }} / {{ $e->kapasitas_jamaah }} ({{ round($percentage) }}%)
                                    <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-800 rotate-45"></div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            @php
                                $statusConfig = match($e->status) {
                                    'Belum Berangkat' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'dot' => 'bg-amber-500'],
                                    'Sudah Berangkat' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'dot' => 'bg-blue-500'],
                                    'Selesai' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-800', 'dot' => 'bg-emerald-500'],
                                    default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'dot' => 'bg-gray-500'],
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wide {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }} mr-2"></span>
                                {{ $e->status }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right" onclick="event.stopPropagation()">
                            <div class="flex items-center justify-end space-x-1 transition-all">
                                <a href="{{ route('embarkasi.show', $e->id_embarkasi) }}" class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Detail">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                <a href="{{ route('embarkasi.edit', $e->id_embarkasi) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <button type="button" onclick="confirmDelete('{{ $e->id_embarkasi }}')" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                                <form id="delete-form-{{ $e->id_embarkasi }}" action="{{ route('embarkasi.destroy', $e->id_embarkasi) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 border-2 border-dashed border-gray-200">
                                    <i class="fas fa-plane-slash text-gray-300 text-3xl"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-800">Tidak ada jadwal ditemukan</h3>
                                <p class="text-gray-500 mt-2 max-w-sm text-sm">Coba ubah filter pencarian atau buat jadwal keberangkatan baru untuk memulai.</p>
                                <a href="{{ route('embarkasi.create') }}" class="mt-6 px-6 py-2.5 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                    <i class="fas fa-plus mr-2"></i> Buat Jadwal Baru
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Floating Action Bar -->
        <div x-show="selected.length > 0" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-y-0 opacity-100"
             x-transition:leave-end="translate-y-full opacity-0"
             class="fixed bottom-6 left-1/2 transform -translate-x-1/2 bg-white border border-gray-200 shadow-2xl rounded-2xl px-6 py-4 z-50 flex items-center gap-6 min-w-[320px] justify-between"
             style="display: none;">
            <div class="flex items-center gap-3">
                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 font-bold text-sm" x-text="selected.length"></span>
                <span class="text-sm font-medium text-gray-700">Item Dipilih</span>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" class="text-gray-500 hover:text-gray-700 text-sm font-medium transition-colors" @click="selected = []; allSelected = false;">Batal</button>
                <div class="h-4 w-px bg-gray-300"></div>
                <button type="button" onclick="alert('Fitur Hapus Massal belum diimplementasikan di Backend')" class="text-red-600 hover:text-red-700 text-sm font-bold flex items-center transition-colors">
                    <i class="fas fa-trash-alt mr-2"></i> Hapus
                </button>
            </div>
        </div>


        <!-- Grid View -->
        <div x-show="view === 'grid'" class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" style="display: none;">
            @forelse($embarkasi as $e)
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col h-full group hover:-translate-y-1">
                <div class="p-6 flex-1">
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-xs font-mono font-bold bg-gray-100 text-gray-600 px-2.5 py-1 rounded-lg border border-gray-200">{{ $e->kode_embarkasi }}</span>
                        @php
                            $statusConfig = match($e->status) {
                                'Belum Berangkat' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'dot' => 'bg-amber-500'],
                                'Sudah Berangkat' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'dot' => 'bg-blue-500'],
                                'Selesai' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-800', 'dot' => 'bg-emerald-500'],
                                default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'dot' => 'bg-gray-500'],
                            };
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wide {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }} mr-1.5"></span>
                            {{ $e->status }}
                        </span>
                    </div>

                    <h3 class="font-bold text-gray-800 text-lg mb-1 group-hover:text-emerald-600 transition-colors line-clamp-2 h-14">{{ $e->paket_haji_umroh }}</h3>
                    
                    <div class="flex items-center text-sm text-gray-500 mb-5">
                        <i class="fas fa-map-marker-alt mr-2 text-red-400"></i> {{ $e->kota_keberangkatan }}
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center p-3.5 bg-gray-50 rounded-xl border border-gray-100">
                            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm text-emerald-600 mr-3 border border-gray-100">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">Waktu Keberangkatan</p>
                                <p class="text-sm font-bold text-gray-800">{{ $e->waktu_keberangkatan->format('d M Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $e->waktu_keberangkatan->format('H:i') }} WIB</p>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-end mb-1.5">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Kapasitas Seat</span>
                                <span class="text-xs font-bold text-gray-800">{{ $e->jumlah_jamaah }} <span class="text-gray-400 font-normal">/ {{ $e->kapasitas_jamaah }}</span></span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden shadow-inner">
                                @php
                                    $percentage = $e->kapasitas_jamaah > 0 ? ($e->jumlah_jamaah / $e->kapasitas_jamaah) * 100 : 0;
                                    $color = $percentage > 90 ? 'bg-gradient-to-r from-red-400 to-red-500' : ($percentage > 70 ? 'bg-gradient-to-r from-amber-400 to-amber-500' : 'bg-gradient-to-r from-emerald-400 to-emerald-500');
                                @endphp
                                <div class="{{ $color }} h-2 rounded-full transition-all duration-700 ease-out" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-gray-50 border-t border-gray-100 rounded-b-2xl flex justify-between items-center">
                    <a href="{{ route('embarkasi.show', $e->id_embarkasi) }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-bold flex items-center group-link">
                        Lihat Detail <i class="fas fa-arrow-right ml-2 transform group-link-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <div class="flex space-x-1">
                        <a href="{{ route('embarkasi.edit', $e->id_embarkasi) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-all" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button onclick="confirmDelete('{{ $e->id_embarkasi }}')" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all" title="Hapus">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-center">
                 ... (Sama dengan tabel) ...
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30 rounded-b-2xl">
            {{ $embarkasi->links() }}
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data jadwal keberangkatan ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>