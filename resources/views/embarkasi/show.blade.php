<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-800 flex items-center">
                <span class="w-2 h-8 bg-emerald-500 rounded-r-md mr-3"></span>
                Detail Keberangkatan
                <span class="ml-3 px-3 py-1 bg-emerald-100 text-emerald-700 text-sm rounded-full font-medium tracking-wide border border-emerald-200">
                    {{ $embarkasi->kode_embarkasi }}
                </span>
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('embarkasi.index') }}" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:text-emerald-600 transition-all duration-200 text-sm font-medium shadow-sm flex items-center group">
                    <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i> Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Messages -->
    @if(session('success'))
        <div class="mb-6 bg-gradient-to-r from-emerald-50 to-white border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm flex items-start" role="alert">
            <div class="flex-shrink-0 text-emerald-500">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-gradient-to-r from-red-50 to-white border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm flex items-start" role="alert">
            <div class="flex-shrink-0 text-red-500">
                <i class="fas fa-exclamation-circle text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Embarkasi Details -->
        <div class="lg:col-span-1 space-y-8">
            <!-- Info Card -->
            <div class="bg-white shadow-md rounded-2xl overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                <div class="relative h-2 bg-gradient-to-r from-emerald-400 to-teal-500"></div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-info-circle text-emerald-500 mr-2"></i> Info Keberangkatan
                        </h3>
                        @php
                            $statusConfig = match($embarkasi->status) {
                                'Belum Berangkat' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'border' => 'border-amber-200', 'icon' => 'fa-clock'],
                                'Sudah Berangkat' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'border' => 'border-blue-200', 'icon' => 'fa-plane-departure'],
                                'Selesai' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-800', 'border' => 'border-emerald-200', 'icon' => 'fa-check-circle'],
                                default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'border' => 'border-gray-200', 'icon' => 'fa-question'],
                            };
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} border {{ $statusConfig['border'] }}">
                            <i class="fas {{ $statusConfig['icon'] }} mr-1.5"></i>
                            {{ $embarkasi->status }}
                        </span>
                    </div>
                    
                    <div class="space-y-5">
                        <div class="flex group">
                            <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-100 to-teal-100 flex items-center justify-center text-emerald-600 shadow-sm group-hover:scale-110 transition-transform duration-200">
                                <i class="fas fa-kaaba text-lg"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Paket</p>
                                <p class="font-bold text-gray-800 text-base">{{ $embarkasi->paket_haji_umroh }}</p>
                            </div>
                        </div>
                        
                        <div class="flex group">
                            <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center text-blue-600 shadow-sm group-hover:scale-110 transition-transform duration-200">
                                <i class="fas fa-map-marker-alt text-lg"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Kota Keberangkatan</p>
                                <p class="font-medium text-gray-800">{{ $embarkasi->kota_keberangkatan }}</p>
                            </div>
                        </div>

                        <div class="flex group">
                            <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-gradient-to-br from-purple-100 to-fuchsia-100 flex items-center justify-center text-purple-600 shadow-sm group-hover:scale-110 transition-transform duration-200">
                                <i class="fas fa-calendar-alt text-lg"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Waktu Keberangkatan</p>
                                <p class="font-medium text-gray-800">{{ $embarkasi->waktu_keberangkatan->format('d M Y') }} <span class="text-gray-400">•</span> {{ $embarkasi->waktu_keberangkatan->format('H:i') }} WIB</p>
                            </div>
                        </div>

                        <div class="flex group">
                            <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-gradient-to-br from-orange-100 to-amber-100 flex items-center justify-center text-orange-600 shadow-sm group-hover:scale-110 transition-transform duration-200">
                                <i class="fas fa-plane text-lg"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Maskapai & Penerbangan</p>
                                <p class="font-medium text-gray-800">{{ $embarkasi->maskapai ?? '-' }}</p>
                                @if($embarkasi->pesawat_pergi)
                                    <div class="mt-1 flex items-center text-xs text-gray-600 bg-gray-50 px-2 py-1 rounded w-fit">
                                        <i class="fas fa-plane-departure mr-2 text-gray-400"></i> {{ $embarkasi->pesawat_pergi }}
                                    </div>
                                @endif
                                @if($embarkasi->pesawat_pulang)
                                    <div class="mt-1 flex items-center text-xs text-gray-600 bg-gray-50 px-2 py-1 rounded w-fit">
                                        <i class="fas fa-plane-arrival mr-2 text-gray-400"></i> {{ $embarkasi->pesawat_pulang }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex group">
                            <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-gradient-to-br from-pink-100 to-rose-100 flex items-center justify-center text-pink-600 shadow-sm group-hover:scale-110 transition-transform duration-200">
                                <i class="fas fa-user-tie text-lg"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Tour Leader</p>
                                <p class="font-medium text-gray-800">{{ $embarkasi->tourLeader->nama_pegawai ?? 'Belum Ditentukan' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-semibold text-gray-600">Kapasitas Jamaah</span>
                            <span class="text-sm font-bold text-gray-900">{{ $embarkasi->jumlah_jamaah }} <span class="text-gray-400 font-normal">/ {{ $embarkasi->kapasitas_jamaah }}</span></span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden shadow-inner">
                            @php
                                $percentage = $embarkasi->kapasitas_jamaah > 0 ? ($embarkasi->jumlah_jamaah / $embarkasi->kapasitas_jamaah) * 100 : 0;
                                $color = $percentage > 90 ? 'bg-gradient-to-r from-red-400 to-red-500' : ($percentage > 70 ? 'bg-gradient-to-r from-amber-400 to-amber-500' : 'bg-gradient-to-r from-emerald-400 to-emerald-500');
                            @endphp
                            <div class="{{ $color }} h-3 rounded-full transition-all duration-700 ease-out" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex flex-col gap-3">
                    @if($embarkasi->status == 'Belum Berangkat')
                    <form action="{{ route('embarkasi.update-status', $embarkasi->id_embarkasi) }}" method="POST" id="form-berangkat">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Sudah Berangkat">
                        <button type="button" onclick="confirmBerangkat()" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:-translate-y-0.5">
                            <i class="fas fa-plane-departure mr-2"></i> Berangkatkan Sekarang
                        </button>
                    </form>
                    @endif

                    <a href="{{ route('embarkasi.edit', $embarkasi->id_embarkasi) }}" class="w-full flex justify-center items-center py-2.5 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 hover:text-emerald-600 transition-all">
                        <i class="fas fa-edit mr-2"></i> Edit Jadwal
                    </a>
                </div>
            </div>

            <!-- Documents Card -->
            <div class="bg-white shadow-md rounded-2xl overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                <div class="relative h-2 bg-gradient-to-r from-purple-400 to-fuchsia-500"></div>
                <div class="p-6">
                     <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-folder-open text-purple-500 mr-2"></i> Dokumen Perjalanan
                     </h3>
                     <form action="{{ route('embarkasi.upload-documents', $embarkasi->id_embarkasi) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        <div class="bg-purple-50 p-4 rounded-xl border border-purple-100">
                            <label class="block text-sm font-bold text-purple-900 mb-2">Manifest Final</label>
                            <div class="flex items-center space-x-2">
                                <input type="file" name="manifest_file" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-white file:text-purple-700 hover:file:bg-purple-100 transition-colors"/>
                                @if($embarkasi->manifest_file)
                                    <a href="{{ asset('storage/'.$embarkasi->manifest_file) }}" target="_blank" class="p-2 bg-white rounded-full text-purple-600 hover:text-purple-800 shadow-sm hover:shadow" title="Download"><i class="fas fa-download"></i></a>
                                @endif
                            </div>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                            <label class="block text-sm font-bold text-blue-900 mb-2">Boarding Pass (ZIP/PDF)</label>
                            <div class="flex items-center space-x-2">
                                <input type="file" name="boarding_pass_file" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-white file:text-blue-700 hover:file:bg-blue-100 transition-colors"/>
                                @if($embarkasi->boarding_pass_file)
                                    <a href="{{ asset('storage/'.$embarkasi->boarding_pass_file) }}" target="_blank" class="p-2 bg-white rounded-full text-blue-600 hover:text-blue-800 shadow-sm hover:shadow" title="Download"><i class="fas fa-download"></i></a>
                                @endif
                            </div>
                        </div>
                        <button type="submit" class="w-full py-2.5 bg-gray-800 text-white rounded-lg text-sm font-semibold hover:bg-gray-900 shadow-md transition-all">
                            <i class="fas fa-cloud-upload-alt mr-2"></i> Upload Dokumen
                        </button>
                     </form>
                </div>
            </div>
        </div>

        <!-- Right Column: Manifest List -->
        <div class="lg:col-span-2" x-data="{ 
            view: 'table', 
            showAddModal: false,
            searchJamaah: '',
            selectedJamaah: [],
            editVisa: null,
            distributeItems: null
        }">
            <div class="bg-white shadow-md rounded-2xl border border-gray-100 overflow-hidden min-h-[600px] flex flex-col">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 mr-3 shadow-sm">
                            <i class="fas fa-users text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Manifest Penumpang</h3>
                            <p class="text-xs text-gray-500">Kelola data jamaah dan dokumen</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        @if($embarkasi->status == 'Belum Berangkat')
                        <button @click="showAddModal = true" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-all shadow-md hover:shadow-lg text-sm font-semibold flex items-center transform hover:-translate-y-0.5">
                            <i class="fas fa-user-plus mr-2"></i> Tambah Jamaah
                        </button>
                        @endif
                        
                        <div class="bg-gray-100 p-1 rounded-lg flex border border-gray-200">
                            <button @click="view = 'table'" :class="{ 'bg-white shadow-sm text-emerald-600': view === 'table', 'text-gray-500 hover:text-gray-700': view !== 'table' }" class="px-3 py-1.5 rounded-md text-xs font-medium transition-all" title="List View">
                                <i class="fas fa-list"></i>
                            </button>
                            <button @click="view = 'grid'" :class="{ 'bg-white shadow-sm text-emerald-600': view === 'grid', 'text-gray-500 hover:text-gray-700': view !== 'grid' }" class="px-3 py-1.5 rounded-md text-xs font-medium transition-all" title="Grid View">
                                <i class="fas fa-th-large"></i>
                            </button>
                        </div>

                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="w-9 h-9 flex items-center justify-center bg-white border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50 hover:text-emerald-600 transition-colors shadow-sm">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl py-2 z-10 border border-gray-100">
                                <a href="{{ route('embarkasi.export-manifest', $embarkasi->id_embarkasi) }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                                    <i class="fas fa-file-excel mr-3 text-emerald-500"></i> Export Excel
                                </a>
                                <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                                    <i class="fas fa-print mr-3 text-gray-400"></i> Print Manifest
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Table View -->
                <div x-show="view === 'table'" class="overflow-x-auto flex-1">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider border-b border-gray-200">
                                <th class="py-4 px-6 font-semibold">No</th>
                                <th class="py-4 px-6 font-semibold">Nama Jamaah</th>
                                <th class="py-4 px-6 font-semibold">Paspor & Visa</th>
                                <th class="py-4 px-6 font-semibold">Dokumen</th>
                                <th class="py-4 px-6 font-semibold text-center">Perlengkapan</th>
                                <th class="py-4 px-6 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($embarkasi->jamaah as $index => $jamaah)
                            <tr class="hover:bg-emerald-50/30 transition-colors group">
                                <td class="py-4 px-6 text-gray-400 font-medium">{{ $index + 1 }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 mr-4 relative">
                                            @if($jamaah->foto_diri)
                                                <img class="h-10 w-10 rounded-full object-cover border-2 border-white shadow-sm" src="{{ asset('storage/' . $jamaah->foto_diri) }}" />
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-emerald-100 to-teal-200 flex items-center justify-center text-emerald-700 text-sm font-bold border-2 border-white shadow-sm">
                                                    {{ substr($jamaah->nama_lengkap, 0, 1) }}
                                                </div>
                                            @endif
                                            @if($jamaah->jenis_kelamin == 'L')
                                                <div class="absolute -bottom-1 -right-1 bg-blue-100 text-blue-600 rounded-full p-0.5 border border-white" title="Laki-laki"><i class="fas fa-mars text-[10px]"></i></div>
                                            @else
                                                <div class="absolute -bottom-1 -right-1 bg-pink-100 text-pink-600 rounded-full p-0.5 border border-white" title="Perempuan"><i class="fas fa-venus text-[10px]"></i></div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-800 group-hover:text-emerald-700 transition-colors">{{ $jamaah->nama_lengkap }}</div>
                                            <div class="text-xs text-gray-500 font-mono mt-0.5 bg-gray-100 inline-block px-1.5 rounded">{{ $jamaah->kode_jamaah }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="text-gray-900 font-mono text-xs font-medium tracking-wide">{{ $jamaah->passport->no_passport ?? '-' }}</div>
                                    @if($jamaah->passport)
                                        @php
                                            $visaStatus = $jamaah->passport->status_visa;
                                            $visaClass = match($visaStatus) {
                                                'Approved' => 'bg-green-100 text-green-700 border-green-200',
                                                'Issued' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                'Rejected' => 'bg-red-100 text-red-700 border-red-200',
                                                default => 'bg-amber-100 text-amber-700 border-amber-200',
                                            };
                                        @endphp
                                        <button @click="editVisa = { id: {{ $jamaah->passport->id_passport }}, name: '{{ $jamaah->nama_lengkap }}', current: '{{ $visaStatus }}' }" class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $visaClass }} border mt-1.5 hover:shadow-sm transition-all transform hover:scale-105">
                                            {{ $visaStatus }} <i class="fas fa-pencil-alt ml-1.5 opacity-60"></i>
                                        </button>
                                    @else
                                        <span class="text-red-500 text-[10px] font-medium flex items-center mt-1 bg-red-50 px-2 py-0.5 rounded-full w-fit"><i class="fas fa-exclamation-circle mr-1"></i> No Passport</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $jamaah->pivot->document_status == 'Lengkap' ? 'bg-green-50 text-green-700 border border-green-100' : 'bg-red-50 text-red-700 border border-red-100' }}">
                                        @if($jamaah->pivot->document_status == 'Lengkap') <i class="fas fa-check mr-1.5"></i> @else <i class="fas fa-times mr-1.5"></i> @endif
                                        {{ $jamaah->pivot->document_status }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <button @click="distributeItems = { id: {{ $jamaah->id_jamaah }}, name: '{{ $jamaah->nama_lengkap }}' }" class="text-xs bg-white text-emerald-600 py-1.5 px-3 rounded-full hover:bg-emerald-500 hover:text-white transition-all border border-emerald-200 shadow-sm font-medium group-button">
                                        <i class="fas fa-box-open mr-1.5"></i>
                                        {{ $jamaah->barang->count() }} Item
                                    </button>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    @if($embarkasi->status == 'Belum Berangkat')
                                    <button type="button" onclick="confirmRemoveJamaah('{{ $embarkasi->id_embarkasi }}', '{{ $jamaah->id_jamaah }}')" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all ml-auto" title="Hapus dari Manifest">
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
                                <td colspan="6" class="py-16 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 border-2 border-dashed border-gray-200">
                                            <i class="fas fa-users-slash text-gray-300 text-3xl"></i>
                                        </div>
                                        <p class="font-medium text-gray-600">Belum ada jamaah dalam manifest ini.</p>
                                        <p class="text-sm text-gray-400 mt-1">Silakan tambahkan jamaah melalui tombol "Tambah Jamaah".</p>
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
                    <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm hover:shadow-md transition-all flex items-start space-x-4 relative group ring-1 ring-transparent hover:ring-emerald-100">
                        <div class="flex-shrink-0">
                             @if($jamaah->foto_diri)
                                <img class="h-14 w-14 rounded-full object-cover border-4 border-emerald-50" src="{{ asset('storage/' . $jamaah->foto_diri) }}" />
                            @else
                                <div class="h-14 w-14 rounded-full bg-gradient-to-br from-emerald-100 to-teal-200 flex items-center justify-center text-emerald-700 text-xl font-bold border-4 border-white shadow-sm">
                                    {{ substr($jamaah->nama_lengkap, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-bold text-gray-900 truncate group-hover:text-emerald-700 transition-colors">{{ $jamaah->nama_lengkap }}</h4>
                            <p class="text-xs text-gray-500 mb-3 font-mono">{{ $jamaah->kode_jamaah }}</p>
                            
                            <div class="flex flex-wrap gap-2">
                                @if($jamaah->passport)
                                    @php
                                        $visaStatus = $jamaah->passport->status_visa;
                                        $visaClass = match($visaStatus) {
                                            'Approved' => 'bg-green-50 text-green-700 border-green-100',
                                            'Issued' => 'bg-blue-50 text-blue-700 border-blue-100',
                                            'Rejected' => 'bg-red-50 text-red-700 border-red-100',
                                            default => 'bg-amber-50 text-amber-700 border-amber-100',
                                        };
                                    @endphp
                                    <button @click="editVisa = { id: {{ $jamaah->passport->id_passport }}, name: '{{ $jamaah->nama_lengkap }}', current: '{{ $visaStatus }}' }" class="px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wide {{ $visaClass }} border hover:opacity-80 transition-opacity">
                                        {{ $visaStatus }}
                                    </button>
                                @else
                                    <span class="px-2 py-1 rounded-md text-[10px] font-bold bg-gray-100 text-gray-500 border border-gray-200">NO PASSPORT</span>
                                @endif
                                <span class="px-2 py-1 rounded-md text-[10px] font-bold {{ $jamaah->pivot->document_status == 'Lengkap' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-rose-50 text-rose-700 border border-rose-100' }}">
                                    DOC {{ strtoupper($jamaah->pivot->document_status) }}
                                </span>
                            </div>
                        </div>
                        @if($embarkasi->status == 'Belum Berangkat')
                        <button onclick="confirmRemoveJamaah('{{ $embarkasi->id_embarkasi }}', '{{ $jamaah->id_jamaah }}')" class="absolute top-2 right-2 text-gray-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-all w-6 h-6 flex items-center justify-center rounded-full hover:bg-red-50">
                            <i class="fas fa-times"></i>
                        </button>
                        @endif
                    </div>
                    @empty
                    <div class="col-span-full py-12 text-center text-gray-500 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                        <i class="fas fa-users mb-2 text-gray-300 text-2xl"></i>
                        <p>Belum ada jamaah.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Add Jamaah Modal -->
            <div x-show="showAddModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="showAddModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-900 opacity-60 backdrop-blur-sm"></div>
                    </div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div x-show="showAddModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-gray-100">
                        <form action="{{ route('embarkasi.add-jamaah', $embarkasi->id_embarkasi) }}" method="POST">
                            @csrf
                            <div class="bg-white px-6 pt-6 pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                        <div class="flex justify-between items-center mb-6">
                                            <h3 class="text-xl leading-6 font-bold text-gray-800" id="modal-title">
                                                Tambah Jamaah
                                            </h3>
                                            <button @click="showAddModal = false" type="button" class="text-gray-400 hover:text-gray-600">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        
                                        <!-- Search Box -->
                                        <div class="relative mb-4">
                                            <input type="text" x-model="searchJamaah" class="w-full pl-11 pr-4 py-3 border-gray-200 bg-gray-50 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 text-sm transition-all focus:bg-white focus:shadow-sm" placeholder="Cari nama atau kode jamaah...">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <i class="fas fa-search text-gray-400"></i>
                                            </div>
                                        </div>

                                        <!-- List Jamaah -->
                                        <div class="mt-2 max-h-[300px] overflow-y-auto border border-gray-100 rounded-xl divide-y divide-gray-50 custom-scrollbar">
                                            @forelse($availableJamaah as $j)
                                                <label class="flex items-center p-3.5 hover:bg-emerald-50 cursor-pointer transition-colors group" x-show="'{{ strtolower($j->nama_lengkap) }}'.includes(searchJamaah.toLowerCase()) || '{{ strtolower($j->kode_jamaah) }}'.includes(searchJamaah.toLowerCase())">
                                                    <div class="relative flex items-center">
                                                        <input type="checkbox" name="jamaah_ids[]" value="{{ $j->id_jamaah }}" class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded transition-all">
                                                    </div>
                                                    <div class="ml-3.5 flex-1">
                                                        <span class="block text-sm font-semibold text-gray-800 group-hover:text-emerald-700">{{ $j->nama_lengkap }}</span>
                                                        <span class="block text-xs text-gray-500 group-hover:text-emerald-600/70">{{ $j->kode_jamaah }} • {{ $j->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                                    </div>
                                                </label>
                                            @empty
                                                <div class="p-8 text-center">
                                                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 mb-3">
                                                        <i class="fas fa-user-slash text-gray-400"></i>
                                                    </div>
                                                    <p class="text-sm text-gray-500">Tidak ada jamaah tersedia untuk ditambahkan.</p>
                                                </div>
                                            @endforelse
                                        </div>
                                        <p class="text-xs text-gray-400 mt-3 text-center">Menampilkan jamaah "Belum Berangkat" yang tersedia.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse border-t border-gray-100">
                                <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-5 py-2.5 bg-emerald-600 text-base font-bold text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:ml-3 sm:w-auto sm:text-sm transition-all">
                                    Simpan Pilihan
                                </button>
                                <button @click="showAddModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-5 py-2.5 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Visa Modal -->
            <div x-show="editVisa" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="editVisa = null">
                        <div class="absolute inset-0 bg-gray-900 opacity-60 backdrop-blur-sm"></div>
                    </div>

                    <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full border border-gray-100">
                        <form x-bind:action="'/passport/' + (editVisa ? editVisa.id : '') + '/update-status'" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="bg-white px-6 pt-6 pb-4">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-bold text-gray-800">
                                        Update Status Visa
                                    </h3>
                                    <button type="button" @click="editVisa = null" class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 mb-5">
                                    <p class="text-xs text-blue-600 font-bold uppercase tracking-wide mb-1">JAMAAH</p>
                                    <p class="text-base font-bold text-blue-900" x-text="editVisa ? editVisa.name : ''"></p>
                                </div>
                                
                                <div class="mb-2">
                                    <label for="status_visa" class="block text-sm font-bold text-gray-700 mb-2">Pilih Status Baru</label>
                                    <select name="status_visa" id="status_visa" class="block w-full pl-3 pr-10 py-2.5 text-base border-gray-300 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm rounded-xl transition-shadow">
                                        <option value="Pending" x-bind:selected="editVisa && editVisa.current == 'Pending'">Pending</option>
                                        <option value="Approved" x-bind:selected="editVisa && editVisa.current == 'Approved'">Approved</option>
                                        <option value="Issued" x-bind:selected="editVisa && editVisa.current == 'Issued'">Issued</option>
                                        <option value="Rejected" x-bind:selected="editVisa && editVisa.current == 'Rejected'">Rejected</option>
                                    </select>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse border-t border-gray-100">
                                <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-5 py-2.5 bg-emerald-600 text-base font-bold text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:ml-3 sm:w-auto sm:text-sm transition-all">
                                    Simpan Perubahan
                                </button>
                                <button type="button" @click="editVisa = null" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-5 py-2.5 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Distribute Items Modal -->
            <div x-show="distributeItems" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="distributeItems = null">
                        <div class="absolute inset-0 bg-gray-900 opacity-60 backdrop-blur-sm"></div>
                    </div>

                    <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full border border-gray-100">
                        <form x-bind:action="'/embarkasi/{{ $embarkasi->id_embarkasi }}/distribute-items/' + (distributeItems ? distributeItems.id : '')" method="POST">
                            @csrf
                            <div class="bg-white px-6 pt-6 pb-4">
                                <div class="flex justify-between items-start mb-6">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-800">
                                            Distribusi Perlengkapan
                                        </h3>
                                        <p class="text-sm text-gray-500 mt-1">
                                            Pilih barang untuk diserahkan ke: <span x-text="distributeItems ? distributeItems.name : ''" class="font-bold text-gray-800"></span>
                                        </p>
                                    </div>
                                    <button type="button" @click="distributeItems = null" class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                
                                <div class="mt-4 max-h-[400px] overflow-y-auto border border-gray-200 rounded-xl custom-scrollbar">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50 sticky top-0 z-10">
                                            <tr>
                                                <th scope="col" class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Barang</th>
                                                <th scope="col" class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Stok</th>
                                                <th scope="col" class="px-5 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Pilih</th>
                                                <th scope="col" class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Qty</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-100">
                                            @foreach($stokItems as $item)
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-5 py-3.5 text-sm text-gray-900">
                                                    <div class="font-semibold">{{ $item->nama_barang }}</div>
                                                    <span class="text-xs text-gray-400 font-mono">{{ $item->kode_barang }}</span>
                                                </td>
                                                <td class="px-5 py-3.5 text-sm">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                        {{ $item->stok_tersedia }} {{ $item->satuan }}
                                                    </span>
                                                </td>
                                                <td class="px-5 py-3.5 text-center">
                                                    <input type="checkbox" name="items[{{ $item->id_stok }}][selected]" value="1" class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded cursor-pointer transition-all">
                                                </td>
                                                <td class="px-5 py-3.5">
                                                    <input type="number" name="items[{{ $item->id_stok }}][qty]" value="1" min="1" max="{{ $item->stok_tersedia }}" class="w-20 px-3 py-1.5 text-sm border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-center">
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse border-t border-gray-100">
                                <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-5 py-2.5 bg-emerald-600 text-base font-bold text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:ml-3 sm:w-auto sm:text-sm transition-all">
                                    Serahkan Barang
                                </button>
                                <button type="button" @click="distributeItems = null" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-5 py-2.5 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all">
                                    Batal
                                </button>
                            </div>
                        </form>
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