<x-app-layout>
    <x-slot name="header">
        <!-- Not used in this theme -->
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-8">
        
        <!-- Header & Actions -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
            <div class="space-y-1">
                <nav class="flex text-sm font-medium text-secondary-500 mb-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
                    <span class="mx-2">/</span>
                    <span class="text-secondary-800">Jadwal Keberangkatan</span>
                </nav>
                <h2 class="text-3xl font-extrabold text-secondary-900 tracking-tight leading-tight">
                    Jadwal Keberangkatan
                </h2>
                <p class="text-sm text-secondary-500 font-medium max-w-2xl">
                    Kelola jadwal penerbangan, manifest jamaah, dan status keberangkatan dalam satu tampilan terpadu.
                </p>
            </div>
            
            <a href="{{ route('embarkasi.create') }}" class="inline-flex items-center px-5 py-3 bg-primary-600 border border-transparent rounded-xl font-bold text-sm text-white hover:bg-primary-700 active:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 group">
                <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center mr-2.5 group-hover:bg-white/30 transition-colors">
                    <i class="fas fa-plus text-xs"></i>
                </div>
                Tambah Jadwal Baru
            </a>
        </div>

        <!-- Stats Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card 1: Keberangkatan Bulan Ini -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-secondary-100 relative overflow-hidden group hover:shadow-md transition-all duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <i class="fas fa-plane-departure text-8xl text-primary-600"></i>
                </div>
                <div class="relative z-10 flex flex-col h-full justify-between">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-primary-50 text-primary-600 flex items-center justify-center text-xl shadow-sm border border-primary-100">
                            <i class="fas fa-plane-departure"></i>
                        </div>
                        <h3 class="text-sm font-bold text-secondary-500 uppercase tracking-wider">Keberangkatan<br>Bulan Ini</h3>
                    </div>
                    <div>
                        <span class="text-4xl font-black text-secondary-900 tracking-tight">{{ $jadwalBulanIni }}</span>
                        <span class="text-sm font-medium text-secondary-500 ml-1">Jadwal</span>
                    </div>
                </div>
            </div>
            
            <!-- Card 2: Total Jamaah -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-secondary-100 relative overflow-hidden group hover:shadow-md transition-all duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <i class="fas fa-users text-8xl text-success-600"></i>
                </div>
                <div class="relative z-10 flex flex-col h-full justify-between">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-success-50 text-success-600 flex items-center justify-center text-xl shadow-sm border border-success-100">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="text-sm font-bold text-secondary-500 uppercase tracking-wider">Total Jamaah<br>Terdaftar</h3>
                    </div>
                    <div>
                        <span class="text-4xl font-black text-secondary-900 tracking-tight">{{ number_format($totalJamaahTerdaftar) }}</span>
                        <span class="text-sm font-medium text-secondary-500 ml-1">Orang</span>
                    </div>
                </div>
            </div>

            <!-- Card 3: Total Jadwal Aktif -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-secondary-100 relative overflow-hidden group hover:shadow-md transition-all duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <i class="fas fa-calendar-check text-8xl text-info-600"></i>
                </div>
                <div class="relative z-10 flex flex-col h-full justify-between">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-info-50 text-info-600 flex items-center justify-center text-xl shadow-sm border border-info-100">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h3 class="text-sm font-bold text-secondary-500 uppercase tracking-wider">Total Jadwal<br>Aktif</h3>
                    </div>
                    <div>
                        <span class="text-4xl font-black text-secondary-900 tracking-tight">{{ $totalJadwal }}</span>
                        <span class="text-sm font-medium text-secondary-500 ml-1">Jadwal</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="bg-white rounded-3xl shadow-sm border border-secondary-100 overflow-hidden flex flex-col" x-data="{ 
            view: 'table', 
            selected: [], 
            allSelected: false,
            toggleAll() {
                this.allSelected = !this.allSelected;
                if (this.allSelected) {
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
            
            <!-- Toolbar -->
            <div class="p-5 border-b border-secondary-100 bg-secondary-50/30 flex flex-col lg:flex-row justify-between items-center gap-4">
                <!-- Search Box -->
                <div class="relative w-full lg:w-96 group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-secondary-400 group-focus-within:text-primary-500 transition-colors"></i>
                    </div>
                    <form action="{{ route('embarkasi.index') }}" method="GET">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="block w-full pl-11 pr-4 py-3 border-secondary-200 rounded-xl leading-5 bg-white placeholder-secondary-400 focus:outline-none focus:placeholder-secondary-300 focus:border-primary-500 focus:ring-primary-500 sm:text-sm transition-all shadow-sm hover:border-secondary-300" 
                               placeholder="Cari kode, paket, atau kota...">
                    </form>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-3 w-full lg:w-auto justify-end overflow-x-auto pb-1 lg:pb-0">
                    <!-- Status Filter Pills -->
                    <div class="flex bg-secondary-100/50 p-1 rounded-xl border border-secondary-200">
                        @foreach(['' => 'Semua', 'Belum Berangkat' => 'Belum', 'Sudah Berangkat' => 'Sudah', 'Selesai' => 'Selesai'] as $key => $label)
                            <button type="button" onclick="window.location.href='{{ route('embarkasi.index', ['status' => $key]) }}'" 
                                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all whitespace-nowrap {{ request('status') == $key ? 'bg-white text-secondary-900 shadow-sm ring-1 ring-secondary-200' : 'text-secondary-500 hover:text-secondary-700 hover:bg-secondary-200/50' }}">
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>

                    <div class="h-6 w-px bg-secondary-200 hidden lg:block"></div>

                    <!-- View Toggle -->
                    <div class="bg-secondary-100/50 p-1 rounded-xl border border-secondary-200 flex">
                        <button @click="view = 'table'" :class="{ 'bg-white text-primary-600 shadow-sm ring-1 ring-secondary-200': view === 'table', 'text-secondary-400 hover:text-secondary-600': view !== 'table' }" class="p-2 rounded-lg text-sm transition-all w-9 h-9 flex items-center justify-center">
                            <i class="fas fa-list"></i>
                        </button>
                        <button @click="view = 'grid'" :class="{ 'bg-white text-primary-600 shadow-sm ring-1 ring-secondary-200': view === 'grid', 'text-secondary-400 hover:text-secondary-600': view !== 'grid' }" class="p-2 rounded-lg text-sm transition-all w-9 h-9 flex items-center justify-center">
                            <i class="fas fa-th-large"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Success Notification -->
            @if(session('success'))
                <div class="mx-6 mt-6 bg-success-50 border border-success-100 text-success-700 px-4 py-3 rounded-xl flex items-center shadow-sm" role="alert">
                    <div class="w-8 h-8 bg-success-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                        <i class="fas fa-check text-success-600 text-sm"></i>
                    </div>
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Table View -->
            <div x-show="view === 'table'" class="overflow-x-auto">
                <table class="min-w-full divide-y divide-secondary-100">
                    <thead class="bg-secondary-50/50">
                        <tr>
                            <th class="py-4 px-6 w-16 text-center">
                                <input type="checkbox" @click="toggleAll()" x-model="allSelected" class="rounded-md border-secondary-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 w-4 h-4 cursor-pointer transition-all">
                            </th>
                            <th class="py-4 px-6 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">Jadwal & Paket</th>
                            <th class="py-4 px-6 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">Rute & Maskapai</th>
                            <th class="py-4 px-6 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">Kapasitas</th>
                            <th class="py-4 px-6 text-center text-xs font-bold text-secondary-500 uppercase tracking-wider">Status</th>
                            <th class="py-4 px-6 text-right text-xs font-bold text-secondary-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-secondary-100">
                        @forelse ($embarkasi as $item)
                            <tr onclick="window.location='{{ route('embarkasi.show', $item->id_embarkasi) }}'" class="hover:bg-secondary-50/50 transition-colors duration-200 group cursor-pointer">
                                <td class="py-4 px-6 text-center" onclick="event.stopPropagation()">
                                    <input type="checkbox" :value="{{ $item->id_embarkasi }}" x-model="selected" @click="toggleSelect({{ $item->id_embarkasi }})" class="rounded-md border-secondary-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 w-4 h-4 cursor-pointer transition-all">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-2 mb-1.5">
                                            <span class="text-[10px] font-mono font-bold bg-secondary-100 text-secondary-600 px-1.5 py-0.5 rounded border border-secondary-200">{{ $item->kode_embarkasi }}</span>
                                            <span class="text-xs font-bold text-secondary-500 flex items-center bg-secondary-50 px-2 py-0.5 rounded-md border border-secondary-100">
                                                <i class="far fa-calendar-alt mr-1.5 text-secondary-400"></i> {{ $item->waktu_keberangkatan->format('d M Y') }}
                                            </span>
                                        </div>
                                        <span class="font-bold text-secondary-900 text-base group-hover:text-primary-600 transition-colors line-clamp-1">{{ $item->paket_haji_umroh }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center text-secondary-700 font-medium text-sm">
                                            <i class="fas fa-map-marker-alt text-xs text-secondary-400 w-4 text-center mr-2"></i>
                                            {{ $item->kota_keberangkatan }}
                                        </div>
                                        <div class="flex items-center text-secondary-500 text-sm">
                                            <i class="fas fa-plane text-xs text-secondary-400 w-4 text-center mr-2"></i>
                                            {{ $item->maskapai ?? 'Belum set' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="w-40">
                                        <div class="flex justify-between text-xs mb-2 font-medium">
                                            <span class="text-secondary-900 font-bold">{{ $item->jumlah_jamaah }} <span class="text-secondary-500 font-normal">Pax</span></span>
                                            <span class="text-secondary-400 text-[10px] uppercase tracking-wide">{{ $item->kapasitas_jamaah }} Seat</span>
                                        </div>
                                        <div class="w-full bg-secondary-100 rounded-full h-1.5 overflow-hidden">
                                            @php
                                                $percentage = $item->kapasitas_jamaah > 0 ? ($item->jumlah_jamaah / $item->kapasitas_jamaah) * 100 : 0;
                                                $barColor = $percentage > 90 ? 'bg-danger-500' : ($percentage > 70 ? 'bg-warning-500' : 'bg-success-500');
                                            @endphp
                                            <div class="{{ $barColor }} h-1.5 rounded-full transition-all duration-700 ease-out" style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusConfig = match($item->status) {
                                            'Belum Berangkat' => ['bg' => 'bg-warning-50', 'text' => 'text-warning-700', 'border' => 'border-warning-200', 'icon' => 'fa-clock'],
                                            'Sudah Berangkat' => ['bg' => 'bg-info-50', 'text' => 'text-info-700', 'border' => 'border-info-200', 'icon' => 'fa-plane'],
                                            'Selesai' => ['bg' => 'bg-success-50', 'text' => 'text-success-700', 'border' => 'border-success-200', 'icon' => 'fa-check-circle'],
                                            default => ['bg' => 'bg-secondary-50', 'text' => 'text-secondary-700', 'border' => 'border-secondary-200', 'icon' => 'fa-circle'],
                                        };
                                    @endphp
                                    <div class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wide border {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }}">
                                        <i class="fas {{ $statusConfig['icon'] }} mr-1.5"></i>
                                        {{ $item->status }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right" onclick="event.stopPropagation()">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('embarkasi.edit', $item->id_embarkasi) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-secondary-400 hover:text-warning-600 hover:bg-warning-50 transition-all border border-transparent hover:border-warning-100" title="Edit">
                                            <i class="fas fa-pencil-alt text-xs"></i>
                                        </a>
                                        <button onclick="confirmDelete('{{ $item->id_embarkasi }}')" class="w-8 h-8 flex items-center justify-center rounded-lg text-secondary-400 hover:text-danger-600 hover:bg-danger-50 transition-all border border-transparent hover:border-danger-100" title="Hapus">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </button>
                                        <form id="delete-form-{{ $item->id_embarkasi }}" action="{{ route('embarkasi.destroy', $item->id_embarkasi) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-20 h-20 bg-secondary-50 rounded-full flex items-center justify-center mb-4 border border-secondary-100">
                                            <i class="fas fa-plane-slash text-3xl text-secondary-300"></i>
                                        </div>
                                        <h3 class="text-lg font-bold text-secondary-900">Belum ada jadwal</h3>
                                        <p class="text-sm text-secondary-500 mt-1 max-w-xs mx-auto">Silakan tambahkan jadwal keberangkatan baru untuk memulai manajemen.</p>
                                        <a href="{{ route('embarkasi.create') }}" class="mt-4 text-primary-600 font-bold hover:text-primary-700 text-sm flex items-center">
                                            <i class="fas fa-plus mr-2"></i> Buat Jadwal Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Grid View -->
            <div x-show="view === 'grid'" class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" style="display: none;">
                @forelse($embarkasi as $item)
                    <div class="bg-white border border-secondary-200 rounded-3xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col h-full group relative hover:border-primary-200">
                        <!-- Top Decor -->
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-mono font-bold text-secondary-400 uppercase tracking-wider mb-1">Kode Jadwal</span>
                                <span class="text-xs font-bold bg-secondary-100 text-secondary-700 px-2 py-1 rounded-lg border border-secondary-200 self-start">{{ $item->kode_embarkasi }}</span>
                            </div>
                            @php
                                $statusConfig = match($item->status) {
                                    'Belum Berangkat' => ['bg' => 'bg-warning-50', 'text' => 'text-warning-700', 'border' => 'border-warning-200'],
                                    'Sudah Berangkat' => ['bg' => 'bg-info-50', 'text' => 'text-info-700', 'border' => 'border-info-200'],
                                    'Selesai' => ['bg' => 'bg-success-50', 'text' => 'text-success-700', 'border' => 'border-success-200'],
                                    default => ['bg' => 'bg-secondary-50', 'text' => 'text-secondary-700', 'border' => 'border-secondary-200'],
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wide border {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }}">
                                {{ $item->status }}
                            </span>
                        </div>

                        <!-- Content -->
                        <div class="mb-6 flex-1">
                            <h3 class="font-bold text-secondary-900 text-lg mb-2 group-hover:text-primary-600 transition-colors line-clamp-2">{{ $item->paket_haji_umroh }}</h3>
                            
                            <div class="space-y-3 mt-4">
                                <div class="flex items-center text-sm">
                                    <div class="w-8 h-8 rounded-full bg-secondary-50 flex items-center justify-center mr-3 text-secondary-400 border border-secondary-100">
                                        <i class="fas fa-map-marker-alt text-xs"></i>
                                    </div>
                                    <span class="font-medium text-secondary-700">{{ $item->kota_keberangkatan }}</span>
                                </div>
                                <div class="flex items-center text-sm">
                                    <div class="w-8 h-8 rounded-full bg-secondary-50 flex items-center justify-center mr-3 text-secondary-400 border border-secondary-100">
                                        <i class="fas fa-calendar-alt text-xs"></i>
                                    </div>
                                    <div>
                                        <span class="font-bold text-secondary-900">{{ $item->waktu_keberangkatan->format('d M Y') }}</span>
                                        <span class="text-xs text-secondary-500 ml-1">{{ $item->waktu_keberangkatan->format('H:i') }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center text-sm">
                                    <div class="w-8 h-8 rounded-full bg-secondary-50 flex items-center justify-center mr-3 text-secondary-400 border border-secondary-100">
                                        <i class="fas fa-plane text-xs"></i>
                                    </div>
                                    <span class="font-medium text-secondary-700">{{ $item->maskapai ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="pt-4 border-t border-secondary-100 flex items-center justify-between mt-auto">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-secondary-400 uppercase tracking-wide mb-1">Kapasitas</span>
                                <div class="flex items-center gap-2">
                                    <div class="w-24 bg-secondary-100 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-primary-500 h-1.5 rounded-full" style="width: {{ $item->kapasitas_jamaah > 0 ? ($item->jumlah_jamaah / $item->kapasitas_jamaah) * 100 : 0 }}%"></div>
                                    </div>
                                    <span class="text-xs font-bold text-secondary-700">{{ $item->jumlah_jamaah }}</span>
                                </div>
                            </div>
                            
                            <div class="flex gap-2">
                                <a href="{{ route('embarkasi.show', $item->id_embarkasi) }}" class="w-9 h-9 rounded-xl bg-primary-600 text-white flex items-center justify-center shadow-lg shadow-primary-500/30 hover:bg-primary-700 hover:-translate-y-0.5 transition-all">
                                    <i class="fas fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-secondary-500">
                        <p>Tidak ada data.</p>
                    </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-secondary-100 bg-secondary-50/50">
                {{ $embarkasi->links() }}
            </div>
        </div>

        <!-- Floating Selection Bar -->
        <div x-show="selected.length > 0" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-y-0 opacity-100"
             x-transition:leave-end="translate-y-full opacity-0"
             class="fixed bottom-8 left-1/2 transform -translate-x-1/2 bg-white border border-secondary-200 shadow-2xl rounded-2xl px-6 py-3.5 z-50 flex items-center gap-8 min-w-[340px] justify-between ring-1 ring-black/5"
             style="display: none;">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-primary-600 text-white font-bold text-sm shadow-sm">
                    <span x-text="selected.length"></span>
                </div>
                <span class="text-sm font-bold text-secondary-700">Item Dipilih</span>
            </div>
            <div class="flex items-center gap-4">
                <button type="button" class="text-secondary-500 hover:text-secondary-800 text-sm font-bold transition-colors" @click="selected = []; allSelected = false;">Batal</button>
                <div class="h-5 w-px bg-secondary-200"></div>
                <button type="button" onclick="alert('Fitur Hapus Massal belum diimplementasikan')" class="text-danger-600 hover:text-danger-700 text-sm font-bold flex items-center gap-2 transition-colors">
                    <i class="fas fa-trash-alt"></i> Hapus
                </button>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Jadwal?',
                text: "Data jadwal dan manifest jamaah akan dihapus permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#f3f4f6',
                cancelButtonText: '<span class="text-secondary-700 font-bold">Batal</span>',
                confirmButtonText: 'Ya, Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>