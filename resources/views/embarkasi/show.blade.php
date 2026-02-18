<x-app-layout>
    <x-slot name="header">
        <!-- Not used in this theme -->
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
            <div class="space-y-1">
                <nav class="flex text-sm font-medium text-secondary-500 mb-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('embarkasi.index') }}" class="hover:text-primary-600 transition-colors">Jadwal Keberangkatan</a>
                    <span class="mx-2">/</span>
                    <span class="text-secondary-800">Detail</span>
                </nav>
                <h2 class="text-3xl font-extrabold text-secondary-900 tracking-tight leading-tight">
                    {{ $embarkasi->paket_haji_umroh }}
                </h2>
                <div class="flex items-center gap-3 text-sm text-secondary-500 font-medium">
                    <span class="flex items-center"><i class="fas fa-map-marker-alt mr-1.5 text-secondary-400"></i> {{ $embarkasi->kota_keberangkatan }}</span>
                    <span class="w-1 h-1 rounded-full bg-secondary-300"></span>
                    <span class="flex items-center"><i class="fas fa-barcode mr-1.5 text-secondary-400"></i> {{ $embarkasi->kode_embarkasi }}</span>
                </div>
            </div>
            
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('embarkasi.index') }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-secondary-300 rounded-xl font-bold text-sm text-secondary-700 shadow-sm hover:bg-secondary-50 hover:text-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-200 transition-all">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                <a href="{{ route('embarkasi.edit', $embarkasi->id_embarkasi) }}" class="inline-flex items-center px-4 py-2.5 bg-warning-500 border border-transparent rounded-xl font-bold text-sm text-white hover:bg-warning-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-warning-500 shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                    <i class="fas fa-edit mr-2"></i> Edit Jadwal
                </a>

                @if($embarkasi->status == 'Belum Berangkat')
                <form action="{{ route('embarkasi.update-status', $embarkasi->id_embarkasi) }}" method="POST" id="form-berangkat" class="inline-flex">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Sudah Berangkat">
                    <button type="button" onclick="confirmBerangkat()" class="inline-flex items-center px-4 py-2.5 bg-info-500 border border-transparent rounded-xl font-bold text-sm text-white hover:bg-info-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-info-500 shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                        <i class="fas fa-plane-departure mr-2"></i> Berangkatkan
                    </button>
                </form>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 items-start">
            <!-- Left Column: Main Content -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Flight Ticket Card -->
                <div class="bg-white rounded-3xl shadow-lg border border-secondary-100 overflow-hidden relative group hover:shadow-xl transition-shadow duration-300">
                    <!-- Top Accent -->
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-primary-500 via-primary-400 to-info-500"></div>
                    
                    <div class="p-6 md:p-8">
                        <!-- Card Header -->
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-primary-50 text-primary-600 flex items-center justify-center text-2xl shadow-inner border border-primary-100">
                                    <i class="fas fa-plane-departure transform -rotate-45"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-secondary-400 uppercase tracking-wider mb-0.5">Maskapai Penerbangan</p>
                                    <h3 class="text-xl font-extrabold text-secondary-900">{{ $embarkasi->maskapai ?? 'Belum Ditentukan' }}</h3>
                                </div>
                            </div>
                            
                            @php
                                $statusConfig = match($embarkasi->status) {
                                    'Belum Berangkat' => ['bg' => 'bg-warning-50', 'text' => 'text-warning-700', 'border' => 'border-warning-200', 'icon' => 'fa-clock'],
                                    'Sudah Berangkat' => ['bg' => 'bg-info-50', 'text' => 'text-info-700', 'border' => 'border-info-200', 'icon' => 'fa-plane'],
                                    'Selesai' => ['bg' => 'bg-success-50', 'text' => 'text-success-700', 'border' => 'border-success-200', 'icon' => 'fa-check-circle'],
                                    default => ['bg' => 'bg-secondary-50', 'text' => 'text-secondary-700', 'border' => 'border-secondary-200', 'icon' => 'fa-circle'],
                                };
                            @endphp
                            <div class="flex items-center px-4 py-2 rounded-full border {{ $statusConfig['bg'] }} {{ $statusConfig['border'] }}">
                                <i class="fas {{ $statusConfig['icon'] }} {{ $statusConfig['text'] }} mr-2.5 text-sm"></i>
                                <span class="text-sm font-bold {{ $statusConfig['text'] }} uppercase tracking-wide">{{ $embarkasi->status }}</span>
                            </div>
                        </div>

                        <!-- Flight Route Visual -->
                        <div class="relative py-4">
                            <div class="flex flex-col md:flex-row justify-between items-center gap-8 relative z-10">
                                <!-- Departure -->
                                <div class="text-center md:text-left flex-1 min-w-[140px]">
                                    <p class="text-xs font-bold text-secondary-400 uppercase tracking-wider mb-1">Keberangkatan</p>
                                    <div class="text-2xl font-black text-secondary-900">{{ $embarkasi->waktu_keberangkatan->format('H:i') }}</div>
                                    <div class="text-sm font-bold text-secondary-600 mt-1">{{ $embarkasi->waktu_keberangkatan->format('d M Y') }}</div>
                                    <div class="inline-flex items-center mt-2 px-2.5 py-1 bg-secondary-50 rounded-lg border border-secondary-100">
                                        <i class="fas fa-plane-departure text-xs text-secondary-400 mr-2"></i>
                                        <span class="text-xs font-mono font-bold text-secondary-700">{{ $embarkasi->pesawat_pergi ?? '---' }}</span>
                                    </div>
                                </div>

                                <!-- Duration / Connector -->
                                <div class="flex-1 flex flex-col items-center justify-center w-full md:w-auto px-4">
                                    <div class="text-xs font-bold text-secondary-400 mb-2 tracking-widest uppercase">Direct Flight</div>
                                    <div class="w-full h-px bg-secondary-200 relative flex items-center justify-center">
                                        <div class="absolute w-2 h-2 bg-secondary-300 rounded-full left-0"></div>
                                        <div class="bg-white p-2 border border-secondary-200 rounded-full shadow-sm z-10">
                                            <i class="fas fa-plane text-primary-500 transform rotate-90 md:rotate-0"></i>
                                        </div>
                                        <div class="absolute w-2 h-2 bg-secondary-300 rounded-full right-0"></div>
                                    </div>
                                </div>

                                <!-- Arrival/Return -->
                                <div class="text-center md:text-right flex-1 min-w-[140px]">
                                    <p class="text-xs font-bold text-secondary-400 uppercase tracking-wider mb-1">Kepulangan</p>
                                    @if($embarkasi->waktu_kepulangan)
                                        <div class="text-2xl font-black text-secondary-900">{{ $embarkasi->waktu_kepulangan->format('H:i') }}</div>
                                        <div class="text-sm font-bold text-secondary-600 mt-1">{{ $embarkasi->waktu_kepulangan->format('d M Y') }}</div>
                                        <div class="inline-flex items-center mt-2 px-2.5 py-1 bg-secondary-50 rounded-lg border border-secondary-100">
                                            <span class="text-xs font-mono font-bold text-secondary-700">{{ $embarkasi->pesawat_pulang ?? '---' }}</span>
                                            <i class="fas fa-plane-arrival text-xs text-secondary-400 ml-2"></i>
                                        </div>
                                    @else
                                        <span class="text-sm font-bold text-secondary-400 italic">Jadwal belum dikonfirmasi</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Ticket Cutout Effect -->
                    <div class="relative h-8 bg-secondary-50 border-t border-secondary-100 flex items-center justify-between px-6">
                         <!-- Left Notch -->
                        <div class="absolute -left-3 top-1/2 transform -translate-y-1/2 w-6 h-6 bg-gray-100 rounded-full border border-secondary-200 shadow-inner"></div>
                        <!-- Dashed Line -->
                        <div class="w-full border-t-2 border-dashed border-secondary-300 mx-2"></div>
                        <!-- Right Notch -->
                        <div class="absolute -right-3 top-1/2 transform -translate-y-1/2 w-6 h-6 bg-gray-100 rounded-full border border-secondary-200 shadow-inner"></div>
                    </div>

                    <!-- Footer Stats -->
                    <div class="bg-secondary-50 px-8 py-5 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="flex items-center gap-4">
                            <div class="text-left">
                                <p class="text-xs text-secondary-500 font-bold uppercase tracking-wider">Harga Paket</p>
                                <p class="text-lg font-black text-primary-600">Rp {{ number_format($embarkasi->harga_paket, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-xl border border-secondary-200 shadow-sm">
                            <div class="flex -space-x-3">
                                @foreach($embarkasi->jamaah->take(4) as $jamaah)
                                    <div class="w-8 h-8 rounded-full border-2 border-white bg-secondary-200 flex items-center justify-center text-[10px] font-bold text-secondary-600 shadow-sm relative z-0 hover:z-10 hover:scale-110 transition-all" title="{{ $jamaah->nama_lengkap }}">
                                        {{ substr($jamaah->nama_lengkap, 0, 1) }}
                                    </div>
                                @endforeach
                                @if($embarkasi->jumlah_jamaah > 4)
                                    <div class="w-8 h-8 rounded-full border-2 border-white bg-secondary-800 text-white flex items-center justify-center text-[10px] font-bold shadow-sm relative z-0">
                                        +{{ $embarkasi->jumlah_jamaah - 4 }}
                                    </div>
                                @endif
                            </div>
                            <span class="text-sm font-bold text-secondary-700">{{ $embarkasi->jumlah_jamaah }} <span class="text-secondary-500 font-normal">Jamaah</span></span>
                        </div>
                    </div>
                </div>

                <!-- Manifest Section -->
                <div class="bg-white rounded-3xl shadow-sm border border-secondary-100 overflow-hidden" x-data="{ 
                    view: 'table', 
                    showAddModal: false,
                    searchJamaah: '',
                    selectedJamaah: [],
                    editVisa: null,
                    distributeItems: null
                }">
                    <!-- Toolbar -->
                    <div class="px-6 py-5 border-b border-secondary-100 bg-secondary-50/30 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white shadow-lg shadow-primary-500/20">
                                <i class="fas fa-users text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-secondary-900">Manifest Penumpang</h3>
                                <p class="text-sm text-secondary-500 font-medium">Kelola data jamaah dan dokumen perjalanan</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            @if($embarkasi->status == 'Belum Berangkat')
                            <button @click="showAddModal = true" class="px-5 py-2.5 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-all shadow-md hover:shadow-lg shadow-primary-600/20 text-sm font-bold flex items-center gap-2 transform active:scale-95">
                                <i class="fas fa-plus"></i> <span class="hidden sm:inline">Tambah Jamaah</span>
                            </button>
                            @endif
                            
                            <div class="bg-secondary-100 p-1 rounded-xl flex border border-secondary-200">
                                <button @click="view = 'table'" :class="{ 'bg-white text-primary-600 shadow-sm': view === 'table', 'text-secondary-500 hover:text-secondary-700': view !== 'table' }" class="px-3 py-1.5 rounded-lg text-sm transition-all" title="List View">
                                    <i class="fas fa-list"></i>
                                </button>
                                <button @click="view = 'grid'" :class="{ 'bg-white text-primary-600 shadow-sm': view === 'grid', 'text-secondary-500 hover:text-secondary-700': view !== 'grid' }" class="px-3 py-1.5 rounded-lg text-sm transition-all" title="Grid View">
                                    <i class="fas fa-th-large"></i>
                                </button>
                            </div>

                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="w-10 h-10 flex items-center justify-center bg-white border border-secondary-200 text-secondary-600 rounded-xl hover:bg-secondary-50 hover:text-primary-600 transition-colors shadow-sm">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl py-2 z-10 border border-secondary-100 ring-1 ring-black ring-opacity-5" style="display: none;">
                                    <div class="px-4 py-2 border-b border-secondary-100 mb-1">
                                        <span class="text-xs font-bold text-secondary-400 uppercase tracking-wider">Export & Print</span>
                                    </div>
                                    <a href="{{ route('embarkasi.export-manifest', $embarkasi->id_embarkasi) }}" class="flex items-center px-4 py-3 text-sm font-medium text-secondary-700 hover:bg-primary-50 hover:text-primary-700 transition-colors">
                                        <div class="w-8 h-8 rounded-lg bg-success-50 text-success-600 flex items-center justify-center mr-3"><i class="fas fa-file-excel"></i></div>
                                        Export Excel
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm font-medium text-secondary-700 hover:bg-primary-50 hover:text-primary-700 transition-colors">
                                        <div class="w-8 h-8 rounded-lg bg-secondary-100 text-secondary-600 flex items-center justify-center mr-3"><i class="fas fa-print"></i></div>
                                        Cetak Manifest
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Table View -->
                    <div x-show="view === 'table'" class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-secondary-100">
                            <thead class="bg-secondary-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">Jamaah</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">Paspor & Visa</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">Dokumen</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-secondary-500 uppercase tracking-wider">Logistik</th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-secondary-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-secondary-100">
                                @forelse ($embarkasi->jamaah as $jamaah)
                                    <tr class="hover:bg-secondary-50/50 transition-colors group">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 relative">
                                                    @if($jamaah->foto_diri)
                                                        <img class="h-10 w-10 rounded-full object-cover border-2 border-white shadow-sm" src="{{ asset('storage/' . $jamaah->foto_diri) }}" />
                                                    @else
                                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-primary-100 to-info-200 flex items-center justify-center text-primary-700 text-sm font-bold border-2 border-white shadow-sm">
                                                            {{ substr($jamaah->nama_lengkap, 0, 1) }}
                                                        </div>
                                                    @endif
                                                    <div class="absolute -bottom-1 -right-1 rounded-full p-0.5 border border-white {{ $jamaah->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-600' }}">
                                                        <i class="fas {{ $jamaah->jenis_kelamin == 'L' ? 'fa-mars' : 'fa-venus' }} text-[10px] w-4 h-4 flex items-center justify-center"></i>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-secondary-900 group-hover:text-primary-700 transition-colors">{{ $jamaah->nama_lengkap }}</div>
                                                    <div class="text-xs text-secondary-500 font-mono bg-secondary-100 px-1.5 py-0.5 rounded inline-block mt-0.5">{{ $jamaah->kode_jamaah }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($jamaah->passport)
                                                <div class="text-xs font-mono font-bold text-secondary-700 mb-1">{{ $jamaah->passport->no_passport }}</div>
                                                @php
                                                    $visaStatus = $jamaah->passport->status_visa;
                                                    $visaColors = match($visaStatus) {
                                                        'Approved' => 'bg-success-100 text-success-700 border-success-200',
                                                        'Issued' => 'bg-info-100 text-info-700 border-info-200',
                                                        'Rejected' => 'bg-danger-100 text-danger-700 border-danger-200',
                                                        default => 'bg-warning-100 text-warning-700 border-warning-200',
                                                    };
                                                @endphp
                                                <button @click="editVisa = { id: {{ $jamaah->passport->id_passport }}, name: '{{ $jamaah->nama_lengkap }}', current: '{{ $visaStatus }}' }" class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $visaColors }} border hover:shadow-sm transition-all transform hover:scale-105">
                                                    {{ $visaStatus }} <i class="fas fa-pencil-alt ml-1.5 opacity-60"></i>
                                                </button>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-secondary-100 text-secondary-500 border border-secondary-200">
                                                    <i class="fas fa-times-circle mr-1.5"></i> No Passport
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $jamaah->pivot->document_status == 'Lengkap' ? 'bg-success-50 text-success-700 border border-success-100' : 'bg-danger-50 text-danger-700 border border-danger-100' }}">
                                                <i class="fas {{ $jamaah->pivot->document_status == 'Lengkap' ? 'fa-check-circle' : 'fa-exclamation-circle' }} mr-1.5"></i>
                                                {{ $jamaah->pivot->document_status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <button @click="distributeItems = { id: {{ $jamaah->id_jamaah }}, name: '{{ $jamaah->nama_lengkap }}' }" class="inline-flex items-center px-3 py-1.5 border border-secondary-200 shadow-sm text-xs font-bold rounded-full text-secondary-700 bg-white hover:bg-primary-50 hover:text-primary-700 hover:border-primary-200 transition-all">
                                                <i class="fas fa-box-open mr-2 text-secondary-400"></i>
                                                {{ $jamaah->barang->count() }} Item
                                            </button>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if($embarkasi->status == 'Belum Berangkat')
                                            <button type="button" onclick="confirmRemoveJamaah('{{ $embarkasi->id_embarkasi }}', '{{ $jamaah->id_jamaah }}')" class="text-secondary-400 hover:text-danger-600 hover:bg-danger-50 p-2 rounded-lg transition-all" title="Hapus dari Manifest">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <form id="remove-jamaah-{{ $jamaah->id_jamaah }}" action="{{ route('embarkasi.remove-jamaah', ['id' => $embarkasi->id_embarkasi, 'jamaahId' => $jamaah->id_jamaah]) }}" method="POST" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-16 text-center text-secondary-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <div class="w-16 h-16 bg-secondary-100 rounded-full flex items-center justify-center mb-4">
                                                    <i class="fas fa-user-slash text-2xl text-secondary-400"></i>
                                                </div>
                                                <p class="text-lg font-bold text-secondary-900">Manifest Kosong</p>
                                                <p class="text-sm text-secondary-500 max-w-xs mx-auto mt-1 mb-4">Belum ada jamaah yang terdaftar di jadwal keberangkatan ini.</p>
                                                <button @click.prevent="showAddModal = true" class="text-primary-600 font-bold hover:text-primary-800 flex items-center transition-colors">
                                                    <i class="fas fa-plus-circle mr-2"></i> Daftarkan Jamaah Sekarang
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Grid View -->
                    <div x-show="view === 'grid'" class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4" style="display: none;">
                        @forelse($embarkasi->jamaah as $jamaah)
                        <div class="bg-white border border-secondary-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-all flex items-start space-x-4 relative group hover:border-primary-200 ring-1 ring-transparent hover:ring-primary-100">
                            <div class="flex-shrink-0">
                                 @if($jamaah->foto_diri)
                                    <img class="h-14 w-14 rounded-full object-cover border-4 border-secondary-50 group-hover:border-white shadow-sm transition-all" src="{{ asset('storage/' . $jamaah->foto_diri) }}" />
                                @else
                                    <div class="h-14 w-14 rounded-full bg-gradient-to-br from-primary-100 to-info-200 flex items-center justify-center text-primary-700 text-xl font-bold border-4 border-secondary-50 group-hover:border-white shadow-sm transition-all">
                                        {{ substr($jamaah->nama_lengkap, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-bold text-secondary-900 truncate group-hover:text-primary-700 transition-colors">{{ $jamaah->nama_lengkap }}</h4>
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-xs text-secondary-500 font-mono bg-secondary-50 px-1.5 rounded border border-secondary-100">{{ $jamaah->kode_jamaah }}</span>
                                </div>
                                
                                <div class="flex flex-wrap gap-2">
                                    @if($jamaah->passport)
                                        @php
                                            $visaStatus = $jamaah->passport->status_visa;
                                            $visaClass = match($visaStatus) {
                                                'Approved' => 'bg-success-50 text-success-700 border-success-100',
                                                'Issued' => 'bg-info-50 text-info-700 border-info-100',
                                                'Rejected' => 'bg-danger-50 text-danger-700 border-danger-100',
                                                default => 'bg-warning-50 text-warning-700 border-warning-100',
                                            };
                                        @endphp
                                        <button @click="editVisa = { id: {{ $jamaah->passport->id_passport }}, name: '{{ $jamaah->nama_lengkap }}', current: '{{ $visaStatus }}' }" class="px-2 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wide {{ $visaClass }} border hover:opacity-80 transition-opacity">
                                            {{ $visaStatus }}
                                        </button>
                                    @else
                                        <span class="px-2 py-1 rounded-lg text-[10px] font-bold bg-secondary-100 text-secondary-500 border border-secondary-200">NO PASSPORT</span>
                                    @endif
                                    <span class="px-2 py-1 rounded-lg text-[10px] font-bold {{ $jamaah->pivot->document_status == 'Lengkap' ? 'bg-primary-50 text-primary-700 border border-primary-100' : 'bg-danger-50 text-danger-700 border border-danger-100' }}">
                                        DOC {{ strtoupper($jamaah->pivot->document_status) }}
                                    </span>
                                </div>
                            </div>
                            @if($embarkasi->status == 'Belum Berangkat')
                            <button onclick="confirmRemoveJamaah('{{ $embarkasi->id_embarkasi }}', '{{ $jamaah->id_jamaah }}')" class="absolute top-2 right-2 text-secondary-300 hover:text-danger-500 opacity-0 group-hover:opacity-100 transition-all w-8 h-8 flex items-center justify-center rounded-full hover:bg-danger-50">
                                <i class="fas fa-times"></i>
                            </button>
                            @endif
                        </div>
                        @empty
                        <div class="col-span-full py-12 text-center text-secondary-500 bg-secondary-50 rounded-2xl border border-dashed border-secondary-200">
                            <i class="fas fa-users mb-2 text-secondary-300 text-2xl"></i>
                            <p>Belum ada jamaah.</p>
                        </div>
                        @endforelse
                    </div>

                    <!-- Add Jamaah Modal (Keeping existing logic but ensuring styling matches) -->
                    <div x-show="showAddModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                            <div x-show="showAddModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity" aria-hidden="true">
                                <div class="absolute inset-0 bg-secondary-900 opacity-60 backdrop-blur-sm"></div>
                            </div>

                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                            <div x-show="showAddModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-secondary-100">
                                <form action="{{ route('embarkasi.add-jamaah', $embarkasi->id_embarkasi) }}" method="POST">
                                    @csrf
                                    <div class="bg-white px-6 pt-6 pb-4">
                                        <div class="sm:flex sm:items-start">
                                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                                <div class="flex justify-between items-center mb-6">
                                                    <h3 class="text-xl leading-6 font-bold text-secondary-900" id="modal-title">
                                                        Tambah Jamaah
                                                    </h3>
                                                    <button @click="showAddModal = false" type="button" class="text-secondary-400 hover:text-secondary-600 w-8 h-8 flex items-center justify-center rounded-full hover:bg-secondary-100 transition-colors">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                
                                                <!-- Search Box -->
                                                <div class="relative mb-4">
                                                    <input type="text" x-model="searchJamaah" class="w-full pl-11 pr-4 py-3 border-secondary-200 bg-secondary-50 rounded-xl focus:ring-primary-500 focus:border-primary-500 text-sm transition-all focus:bg-white focus:shadow-sm" placeholder="Cari nama atau kode jamaah...">
                                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                        <i class="fas fa-search text-secondary-400"></i>
                                                    </div>
                                                </div>

                                                <!-- List Jamaah -->
                                                <div class="mt-2 max-h-[300px] overflow-y-auto border border-secondary-100 rounded-xl divide-y divide-secondary-50 custom-scrollbar">
                                                    @forelse($availableJamaah as $j)
                                                        <label class="flex items-center p-3.5 hover:bg-primary-50 cursor-pointer transition-colors group" x-show="'{{ strtolower($j->nama_lengkap) }}'.includes(searchJamaah.toLowerCase()) || '{{ strtolower($j->kode_jamaah) }}'.includes(searchJamaah.toLowerCase())">
                                                            <div class="relative flex items-center">
                                                                <input type="checkbox" name="jamaah_ids[]" value="{{ $j->id_jamaah }}" class="h-5 w-5 text-primary-600 focus:ring-primary-500 border-secondary-300 rounded transition-all">
                                                            </div>
                                                            <div class="ml-3.5 flex-1">
                                                                <span class="block text-sm font-bold text-secondary-800 group-hover:text-primary-700">{{ $j->nama_lengkap }}</span>
                                                                <span class="block text-xs text-secondary-500 group-hover:text-primary-600/70">{{ $j->kode_jamaah }} • {{ $j->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                                            </div>
                                                        </label>
                                                    @empty
                                                        <div class="p-8 text-center">
                                                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-secondary-100 mb-3">
                                                                <i class="fas fa-user-slash text-secondary-400"></i>
                                                            </div>
                                                            <p class="text-sm text-secondary-500">Tidak ada jamaah tersedia.</p>
                                                        </div>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-secondary-50 px-6 py-4 sm:flex sm:flex-row-reverse border-t border-secondary-100 gap-3">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-5 py-2.5 bg-primary-600 text-base font-bold text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:w-auto sm:text-sm transition-all">
                                            Simpan Pilihan
                                        </button>
                                        <button @click="showAddModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-secondary-300 shadow-sm px-5 py-2.5 bg-white text-base font-bold text-secondary-700 hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-200 sm:mt-0 sm:w-auto sm:text-sm transition-all">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Visa Modal & Distribute Items Modal (Same Structure) -->
                    <div x-show="editVisa" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="editVisa = null">
                                <div class="absolute inset-0 bg-secondary-900 opacity-60 backdrop-blur-sm"></div>
                            </div>

                            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full border border-secondary-100">
                                <form x-bind:action="'/passport/' + (editVisa ? editVisa.id : '') + '/update-status'" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="bg-white px-6 pt-6 pb-4">
                                        <div class="flex justify-between items-center mb-4">
                                            <h3 class="text-lg font-bold text-secondary-900">
                                                Update Status Visa
                                            </h3>
                                            <button type="button" @click="editVisa = null" class="text-secondary-400 hover:text-secondary-600">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="bg-info-50 p-4 rounded-xl border border-info-100 mb-5">
                                            <p class="text-xs text-info-600 font-bold uppercase tracking-wide mb-1">JAMAAH</p>
                                            <p class="text-base font-bold text-info-900" x-text="editVisa ? editVisa.name : ''"></p>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <label for="status_visa" class="block text-sm font-bold text-secondary-700 mb-2">Pilih Status Baru</label>
                                            <select name="status_visa" id="status_visa" class="block w-full pl-3 pr-10 py-2.5 text-base border-secondary-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-xl transition-shadow">
                                                <option value="Pending" x-bind:selected="editVisa && editVisa.current == 'Pending'">Pending</option>
                                                <option value="Approved" x-bind:selected="editVisa && editVisa.current == 'Approved'">Approved</option>
                                                <option value="Issued" x-bind:selected="editVisa && editVisa.current == 'Issued'">Issued</option>
                                                <option value="Rejected" x-bind:selected="editVisa && editVisa.current == 'Rejected'">Rejected</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="bg-secondary-50 px-6 py-4 sm:flex sm:flex-row-reverse border-t border-secondary-100 gap-3">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-5 py-2.5 bg-primary-600 text-base font-bold text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:w-auto sm:text-sm transition-all">
                                            Simpan Perubahan
                                        </button>
                                        <button type="button" @click="editVisa = null" class="mt-3 w-full inline-flex justify-center rounded-xl border border-secondary-300 shadow-sm px-5 py-2.5 bg-white text-base font-bold text-secondary-700 hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-200 sm:mt-0 sm:w-auto sm:text-sm transition-all">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div x-show="distributeItems" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="distributeItems = null">
                                <div class="absolute inset-0 bg-secondary-900 opacity-60 backdrop-blur-sm"></div>
                            </div>

                            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full border border-secondary-100">
                                <form x-bind:action="'/embarkasi/{{ $embarkasi->id_embarkasi }}/distribute-items/' + (distributeItems ? distributeItems.id : '')" method="POST">
                                    @csrf
                                    <div class="bg-white px-6 pt-6 pb-4">
                                        <div class="flex justify-between items-start mb-6">
                                            <div>
                                                <h3 class="text-lg font-bold text-secondary-900">
                                                    Distribusi Perlengkapan
                                                </h3>
                                                <p class="text-sm text-secondary-500 mt-1">
                                                    Pilih barang untuk diserahkan ke: <span x-text="distributeItems ? distributeItems.name : ''" class="font-bold text-secondary-800"></span>
                                                </p>
                                            </div>
                                            <button type="button" @click="distributeItems = null" class="text-secondary-400 hover:text-secondary-600">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        
                                        <div class="mt-4 max-h-[400px] overflow-y-auto border border-secondary-200 rounded-xl custom-scrollbar">
                                            <table class="min-w-full divide-y divide-secondary-200">
                                                <thead class="bg-secondary-50 sticky top-0 z-10">
                                                    <tr>
                                                        <th scope="col" class="px-5 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">Barang</th>
                                                        <th scope="col" class="px-5 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">Stok</th>
                                                        <th scope="col" class="px-5 py-3 text-center text-xs font-bold text-secondary-500 uppercase tracking-wider">Pilih</th>
                                                        <th scope="col" class="px-5 py-3 text-left text-xs font-bold text-secondary-500 uppercase tracking-wider">Qty</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-secondary-100">
                                                    @foreach($stokItems as $item)
                                                    <tr class="hover:bg-secondary-50 transition-colors">
                                                        <td class="px-5 py-3.5 text-sm text-secondary-900">
                                                            <div class="font-bold">{{ $item->nama_barang }}</div>
                                                            <span class="text-xs text-secondary-400 font-mono">{{ $item->kode_barang }}</span>
                                                        </td>
                                                        <td class="px-5 py-3.5 text-sm">
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-secondary-100 text-secondary-800">
                                                                {{ $item->stok_tersedia }} {{ $item->satuan }}
                                                            </span>
                                                        </td>
                                                        <td class="px-5 py-3.5 text-center">
                                                            <input type="checkbox" name="items[{{ $item->id_stok }}][selected]" value="1" class="h-5 w-5 text-primary-600 focus:ring-primary-500 border-secondary-300 rounded cursor-pointer transition-all">
                                                        </td>
                                                        <td class="px-5 py-3.5">
                                                            <input type="number" name="items[{{ $item->id_stok }}][qty]" value="1" min="1" max="{{ $item->stok_tersedia }}" class="w-20 px-3 py-1.5 text-sm border-secondary-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 text-center">
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="bg-secondary-50 px-6 py-4 sm:flex sm:flex-row-reverse border-t border-secondary-100 gap-3">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-5 py-2.5 bg-primary-600 text-base font-bold text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:w-auto sm:text-sm transition-all">
                                            Serahkan Barang
                                        </button>
                                        <button type="button" @click="distributeItems = null" class="mt-3 w-full inline-flex justify-center rounded-xl border border-secondary-300 shadow-sm px-5 py-2.5 bg-white text-base font-bold text-secondary-700 hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-200 sm:mt-0 sm:w-auto sm:text-sm transition-all">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar Info -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Capacity Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-secondary-100 p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-5">
                        <i class="fas fa-chart-pie text-9xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-secondary-900 mb-6 flex items-center relative z-10">
                        <span class="w-8 h-8 rounded-lg bg-info-50 text-info-600 flex items-center justify-center mr-3 border border-info-100">
                            <i class="fas fa-chart-pie"></i>
                        </span>
                        Kapasitas Seat
                    </h3>
                    
                    <div class="flex items-center justify-center py-6 relative z-10">
                        <div class="relative w-40 h-40">
                            <svg class="w-full h-full transform -rotate-90 drop-shadow-sm">
                                <circle cx="80" cy="80" r="70" stroke="currentColor" stroke-width="14" fill="transparent" class="text-secondary-100" />
                                @php
                                    $percentage = $embarkasi->kapasitas_jamaah > 0 ? ($embarkasi->jumlah_jamaah / $embarkasi->kapasitas_jamaah) * 100 : 0;
                                    $dashArray = 2 * pi() * 70;
                                    $dashOffset = $dashArray - ($dashArray * $percentage / 100);
                                    $colorClass = $percentage > 90 ? 'text-danger-500' : ($percentage > 70 ? 'text-warning-500' : 'text-success-500');
                                @endphp
                                <circle cx="80" cy="80" r="70" stroke="currentColor" stroke-width="14" fill="transparent" :stroke-dasharray="{{ $dashArray }}" :stroke-dashoffset="{{ $dashOffset }}" class="{{ $colorClass }} transition-all duration-1000 ease-out" stroke-linecap="round" />
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-4xl font-black text-secondary-900">{{ $embarkasi->jumlah_jamaah }}</span>
                                <span class="text-xs text-secondary-500 font-bold uppercase tracking-wider mt-1">Terisi</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 space-y-3 relative z-10">
                        <div class="flex justify-between text-sm p-3 bg-secondary-50 rounded-xl border border-secondary-100">
                            <span class="text-secondary-500 font-medium">Total Kapasitas</span>
                            <span class="font-black text-secondary-900">{{ $embarkasi->kapasitas_jamaah }} Seat</span>
                        </div>
                        <div class="flex justify-between text-sm p-3 bg-secondary-50 rounded-xl border border-secondary-100">
                            <span class="text-secondary-500 font-medium">Sisa Seat</span>
                            <span class="font-black text-secondary-900">{{ max(0, $embarkasi->kapasitas_jamaah - $embarkasi->jumlah_jamaah) }} Seat</span>
                        </div>
                    </div>
                </div>

                <!-- Tour Leader Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-secondary-100 p-6">
                    <h3 class="text-lg font-bold text-secondary-900 mb-6 flex items-center">
                        <span class="w-8 h-8 rounded-lg bg-warning-50 text-warning-600 flex items-center justify-center mr-3 border border-warning-100">
                            <i class="fas fa-user-tie"></i>
                        </span>
                        Tour Leader
                    </h3>
                    
                    @if($embarkasi->tourLeader)
                        <div class="flex items-center p-4 bg-secondary-50 rounded-2xl border border-secondary-100 mb-4">
                            <div class="w-14 h-14 rounded-full bg-warning-100 text-warning-600 flex items-center justify-center text-2xl font-bold mr-4 border-2 border-white shadow-sm">
                                {{ substr($embarkasi->tourLeader->nama_pegawai, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-secondary-900 text-lg">{{ $embarkasi->tourLeader->nama_pegawai }}</p>
                                <p class="text-xs text-secondary-500 font-bold uppercase tracking-wide">{{ $embarkasi->tourLeader->jabatan ?? 'Tour Leader' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="#" class="flex items-center justify-center py-2.5 px-4 rounded-xl bg-success-50 text-success-700 font-bold text-sm hover:bg-success-100 transition-colors">
                                <i class="fab fa-whatsapp mr-2 text-lg"></i> Chat
                            </a>
                            <a href="#" class="flex items-center justify-center py-2.5 px-4 rounded-xl bg-primary-50 text-primary-700 font-bold text-sm hover:bg-primary-100 transition-colors">
                                <i class="fas fa-phone mr-2"></i> Call
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8 bg-secondary-50 rounded-2xl border border-dashed border-secondary-300">
                            <div class="w-12 h-12 bg-secondary-200 rounded-full flex items-center justify-center mx-auto mb-3 text-secondary-400">
                                <i class="fas fa-user-slash"></i>
                            </div>
                            <p class="text-secondary-500 text-sm mb-4 font-medium">Belum ada Tour Leader</p>
                            <a href="{{ route('embarkasi.edit', $embarkasi->id_embarkasi) }}" class="inline-flex items-center px-4 py-2 bg-white border border-secondary-300 rounded-lg text-xs font-bold text-secondary-700 shadow-sm hover:bg-secondary-50 hover:text-primary-600 transition-all">
                                <i class="fas fa-plus-circle mr-2"></i> Assign TL
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Documents Card -->
                <div class="bg-white shadow-sm rounded-3xl overflow-hidden border border-secondary-100 hover:shadow-md transition-shadow duration-300 group">
                    <div class="relative h-1.5 bg-gradient-to-r from-purple-400 to-fuchsia-500"></div>
                    <div class="p-6">
                         <h3 class="text-lg font-bold text-secondary-900 mb-6 flex items-center">
                            <span class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center mr-3 border border-purple-100">
                                <i class="fas fa-folder-open"></i>
                            </span>
                            Dokumen Perjalanan
                         </h3>
                         <form action="{{ route('embarkasi.upload-documents', $embarkasi->id_embarkasi) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div class="bg-purple-50 p-4 rounded-2xl border border-purple-100 transition-colors hover:bg-purple-100/50 group-hover:border-purple-200">
                                <label class="block text-xs font-bold text-purple-800 uppercase tracking-wider mb-2">Manifest Final</label>
                                <div class="flex items-center space-x-2">
                                    <input type="file" name="manifest_file" class="block w-full text-xs text-secondary-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-white file:text-purple-700 hover:file:bg-purple-100 transition-colors"/>
                                    @if($embarkasi->manifest_file)
                                        <a href="{{ asset('storage/'.$embarkasi->manifest_file) }}" target="_blank" class="w-8 h-8 flex items-center justify-center bg-white rounded-full text-purple-600 hover:text-purple-800 shadow-sm hover:shadow transition-all" title="Download"><i class="fas fa-download"></i></a>
                                    @endif
                                </div>
                            </div>
                            <div class="bg-info-50 p-4 rounded-2xl border border-info-100 transition-colors hover:bg-info-100/50 group-hover:border-info-200">
                                <label class="block text-xs font-bold text-info-800 uppercase tracking-wider mb-2">Boarding Pass (ZIP/PDF)</label>
                                <div class="flex items-center space-x-2">
                                    <input type="file" name="boarding_pass_file" class="block w-full text-xs text-secondary-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-white file:text-info-700 hover:file:bg-info-100 transition-colors"/>
                                    @if($embarkasi->boarding_pass_file)
                                        <a href="{{ asset('storage/'.$embarkasi->boarding_pass_file) }}" target="_blank" class="w-8 h-8 flex items-center justify-center bg-white rounded-full text-info-600 hover:text-info-800 shadow-sm hover:shadow transition-all" title="Download"><i class="fas fa-download"></i></a>
                                    @endif
                                </div>
                            </div>
                            <button type="submit" class="w-full py-3 bg-secondary-800 text-white rounded-xl text-sm font-bold hover:bg-secondary-900 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                                <i class="fas fa-cloud-upload-alt mr-2"></i> Upload Dokumen
                            </button>
                         </form>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-3xl shadow-sm border border-secondary-100 p-6">
                    <h3 class="text-lg font-bold text-secondary-900 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <button class="w-full flex items-center justify-between p-3.5 rounded-xl bg-secondary-50 hover:bg-primary-50 text-secondary-700 hover:text-primary-700 transition-colors group border border-secondary-100 hover:border-primary-100">
                            <span class="text-sm font-bold"><i class="fas fa-envelope mr-3 text-secondary-400 group-hover:text-primary-500 w-5 text-center"></i> Broadcast Pesan</span>
                            <i class="fas fa-chevron-right text-xs text-secondary-300 group-hover:text-primary-300"></i>
                        </button>
                        <button class="w-full flex items-center justify-between p-3.5 rounded-xl bg-secondary-50 hover:bg-primary-50 text-secondary-700 hover:text-primary-700 transition-colors group border border-secondary-100 hover:border-primary-100">
                            <span class="text-sm font-bold"><i class="fas fa-file-alt mr-3 text-secondary-400 group-hover:text-primary-500 w-5 text-center"></i> Cetak Manifest</span>
                            <i class="fas fa-chevron-right text-xs text-secondary-300 group-hover:text-primary-300"></i>
                        </button>
                        <button class="w-full flex items-center justify-between p-3.5 rounded-xl bg-secondary-50 hover:bg-primary-50 text-secondary-700 hover:text-primary-700 transition-colors group border border-secondary-100 hover:border-primary-100">
                            <span class="text-sm font-bold"><i class="fas fa-tags mr-3 text-secondary-400 group-hover:text-primary-500 w-5 text-center"></i> Cetak Label Koper</span>
                            <i class="fas fa-chevron-right text-xs text-secondary-300 group-hover:text-primary-300"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmBerangkat() {
            Swal.fire({
                title: 'Konfirmasi Keberangkatan',
                text: "Status akan diubah menjadi 'Sudah Berangkat'. Data status jamaah juga akan diperbarui otomatis.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Berangkatkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-berangkat').submit();
                }
            })
        }

        function confirmRemoveJamaah(embarkasiId, jamaahId) {
            Swal.fire({
                title: 'Hapus Jamaah?',
                text: "Jamaah akan dihapus dari manifest keberangkatan ini.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('remove-jamaah-' + jamaahId).submit();
                }
            })
        }
    </script>
</x-app-layout>