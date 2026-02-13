<x-app-layout>
    <x-slot name="header">
        Detail Keberangkatan: {{ $embarkasi->kode_embarkasi }}
    </x-slot>

    <!-- Messages -->
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Embarkasi Details -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Info Keberangkatan</h3>
                    <span class="{{ $embarkasi->status == 'Sudah Berangkat' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} px-2 py-1 rounded text-xs font-semibold">
                        {{ $embarkasi->status }}
                    </span>
                </div>
                
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-gray-500 block">Paket</span>
                        <span class="font-medium">{{ $embarkasi->paket_haji_umroh }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Kota Keberangkatan</span>
                        <span class="font-medium">{{ $embarkasi->kota_keberangkatan }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Waktu Keberangkatan</span>
                        <span class="font-medium">{{ $embarkasi->waktu_keberangkatan->format('d M Y, H:i') }} WIB</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Maskapai</span>
                        <span class="font-medium">{{ $embarkasi->maskapai ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Tour Leader</span>
                        <span class="font-medium">{{ $embarkasi->tourLeader->nama_pegawai ?? 'Belum Ditentukan' }}</span>
                    </div>
                    
                    <div class="pt-4 border-t">
                        <div class="flex justify-between mb-1">
                            <span>Kapasitas</span>
                            <span class="font-semibold">{{ $embarkasi->jumlah_jamaah }} / {{ $embarkasi->kapasitas_jamaah }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            @php
                                $percentage = $embarkasi->kapasitas_jamaah > 0 ? ($embarkasi->jumlah_jamaah / $embarkasi->kapasitas_jamaah) * 100 : 0;
                                $color = $percentage > 90 ? 'bg-red-600' : ($percentage > 70 ? 'bg-yellow-400' : 'bg-green-600');
                            @endphp
                            <div class="{{ $color }} h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t space-y-3">
                    <h4 class="font-semibold text-gray-700">Aksi Cepat</h4>
                    
                    @if($embarkasi->status == 'Belum Berangkat')
                    <form action="{{ route('embarkasi.update-status', $embarkasi->id_embarkasi) }}" method="POST" onsubmit="return confirm('Ubah status menjadi Sudah Berangkat? Data jamaah juga akan diupdate.')">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Sudah Berangkat">
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-plane-departure mr-2"></i> Berangkatkan Sekarang
                        </button>
                    </form>
                    @endif

                    <a href="{{ route('embarkasi.edit', $embarkasi->id_embarkasi) }}" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Edit Jadwal
                    </a>
                </div>
            </div>

            <!-- Add Jamaah Form -->
            @if($embarkasi->status == 'Belum Berangkat')
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Tambah Jamaah</h3>
                <form action="{{ route('embarkasi.add-jamaah', $embarkasi->id_embarkasi) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="jamaah_ids" class="block text-sm font-medium text-gray-700">Pilih Jamaah (Multi-select)</label>
                            <select name="jamaah_ids[]" id="jamaah_ids" multiple class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm rounded-md h-40">
                                @foreach($availableJamaah as $j)
                                    <option value="{{ $j->id_jamaah }}">{{ $j->nama_lengkap }} ({{ $j->kode_jamaah }})</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Tahan tombol Ctrl (Windows) atau Command (Mac) untuk memilih lebih dari satu.</p>
                        </div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                            Tambahkan ke Manifest
                        </button>
                    </div>
                </form>
            </div>
            @endif
        </div>

        <!-- Right Column: Manifest List -->
        <div class="lg:col-span-2" x-data="{ view: 'table', editVisa: null, distributeItems: null }">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Manifest Penumpang</h3>
                    
                    <div class="flex items-center space-x-2">
                        <!-- View Toggle -->
                        <div class="bg-gray-100 p-1 rounded-lg flex mr-2">
                            <button @click="view = 'table'" :class="{ 'bg-white shadow-sm text-emerald-600': view === 'table', 'text-gray-500 hover:text-gray-700': view !== 'table' }" class="px-2 py-1 rounded text-xs font-medium transition-all flex items-center" title="List View">
                                <i class="fas fa-list"></i>
                            </button>
                            <button @click="view = 'grid'" :class="{ 'bg-white shadow-sm text-emerald-600': view === 'grid', 'text-gray-500 hover:text-gray-700': view !== 'grid' }" class="px-2 py-1 rounded text-xs font-medium transition-all flex items-center" title="Card View">
                                <i class="fas fa-th-large"></i>
                            </button>
                        </div>

                        <a href="{{ route('embarkasi.export-manifest', $embarkasi->id_embarkasi) }}" class="px-3 py-1 bg-gray-100 text-gray-600 rounded text-sm hover:bg-gray-200 flex items-center">
                            <i class="fas fa-file-excel mr-1"></i> Export
                        </a>
                        <button class="px-3 py-1 bg-gray-100 text-gray-600 rounded text-sm hover:bg-gray-200">
                            <i class="fas fa-print mr-1"></i> Print
                        </button>
                    </div>
                </div>
                
                <!-- Table View -->
                <div x-show="view === 'table'" class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 uppercase text-xs leading-normal">
                                <th class="py-3 px-6">No</th>
                                <th class="py-3 px-6">Nama Jamaah</th>
                                <th class="py-3 px-6">Gender</th>
                                <th class="py-3 px-6">No Paspor</th>
                                <th class="py-3 px-6">Status Dokumen</th>
                                <th class="py-3 px-6">Status Visa</th>
                                <th class="py-3 px-6 text-center">Perlengkapan</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @forelse($embarkasi->jamaah as $index => $jamaah)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6">{{ $index + 1 }}</td>
                                <td class="py-3 px-6">
                                    <div class="flex items-center">
                                        <div class="mr-2">
                                            @if($jamaah->foto_diri)
                                                <img class="w-8 h-8 rounded-full object-cover" src="{{ asset('storage/' . $jamaah->foto_diri) }}" />
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-xs">
                                                    {{ substr($jamaah->nama_lengkap, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="font-medium block">{{ $jamaah->nama_lengkap }}</span>
                                            <span class="text-xs text-gray-500">{{ $jamaah->kode_jamaah }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-6">{{ $jamaah->jenis_kelamin }}</td>
                                <td class="py-3 px-6">
                                    {{ $jamaah->passport->no_passport ?? '-' }}
                                    @if(!($jamaah->passport))
                                        <span class="text-red-500 text-xs ml-1" title="Paspor belum diinput"><i class="fas fa-exclamation-circle"></i></span>
                                    @endif
                                </td>
                                <td class="py-3 px-6">
                                    <span class="px-2 py-1 rounded-full text-xs {{ $jamaah->pivot->document_status == 'Lengkap' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $jamaah->pivot->document_status }}
                                    </span>
                                </td>
                                <td class="py-3 px-6">
                                    @if($jamaah->passport)
                                        @php
                                            $visaStatus = $jamaah->passport->status_visa;
                                            $visaClass = match($visaStatus) {
                                                'Approved' => 'bg-green-100 text-green-800',
                                                'Issued' => 'bg-blue-100 text-blue-800',
                                                'Rejected' => 'bg-red-100 text-red-800',
                                                default => 'bg-yellow-100 text-yellow-800',
                                            };
                                        @endphp
                                        <button @click="editVisa = { id: {{ $jamaah->passport->id_passport }}, name: '{{ $jamaah->nama_lengkap }}', current: '{{ $visaStatus }}' }" class="{{ $visaClass }} py-1 px-3 rounded-full text-xs hover:opacity-80 transition-opacity focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                            {{ $visaStatus }} <i class="fas fa-pencil-alt ml-1 text-[10px] opacity-50"></i>
                                        </button>
                                    @else
                                        <span class="text-gray-400 text-xs italic">Paspor belum ada</span>
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <button @click="distributeItems = { id: {{ $jamaah->id_jamaah }}, name: '{{ $jamaah->nama_lengkap }}' }" class="text-xs bg-emerald-100 text-emerald-700 py-1 px-3 rounded-full hover:bg-emerald-200 transition-colors flex items-center justify-center mx-auto space-x-1">
                                        <i class="fas fa-box-open"></i>
                                        <span>{{ $jamaah->barang->count() }} Item</span>
                                    </button>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    @if($embarkasi->status == 'Belum Berangkat')
                                    <form action="{{ route('embarkasi.remove-jamaah', ['id' => $embarkasi->id_embarkasi, 'jamaahId' => $jamaah->id_jamaah]) }}" method="POST" onsubmit="return confirm('Hapus jamaah dari manifest ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                    @else
                                    <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="py-8 px-6 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-users text-gray-300 text-4xl mb-3"></i>
                                        <p>Belum ada jamaah dalam manifest ini.</p>
                                        <p class="text-sm">Gunakan form di sebelah kiri untuk menambahkan jamaah.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Grid View -->
                <div x-show="view === 'grid'" class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4" style="display: none;">
                    @forelse($embarkasi->jamaah as $index => $jamaah)
                    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-all flex items-start space-x-4 relative">
                        <!-- Avatar -->
                        <div class="flex-shrink-0">
                            @if($jamaah->foto_diri)
                                <img class="w-12 h-12 rounded-full object-cover border-2 border-emerald-100" src="{{ asset('storage/' . $jamaah->foto_diri) }}" />
                            @else
                                <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 text-lg font-bold border-2 border-white shadow-sm">
                                    {{ substr($jamaah->nama_lengkap, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 truncate" title="{{ $jamaah->nama_lengkap }}">{{ $jamaah->nama_lengkap }}</h4>
                                    <p class="text-xs text-gray-500">{{ $jamaah->kode_jamaah }}</p>
                                </div>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $jamaah->pivot->document_status == 'Lengkap' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $jamaah->pivot->document_status }}
                                </span>
                            </div>
                            
                            <div class="mt-2 space-y-1">
                                <div class="flex items-center text-xs text-gray-600">
                                    <i class="fas fa-passport w-4 text-gray-400"></i>
                                    <span class="truncate">
                                        {{ $jamaah->passport->no_passport ?? '-' }}
                                        @if(!($jamaah->passport))
                                            <span class="text-red-500 ml-1" title="Paspor belum diinput"><i class="fas fa-exclamation-circle"></i></span>
                                        @endif
                                    </span>
                                </div>
                                <div class="flex items-center text-xs text-gray-600">
                                    <i class="fas fa-venus-mars w-4 text-gray-400"></i>
                                    <span>{{ $jamaah->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                </div>
                                @if($jamaah->passport)
                                    @php
                                        $visaStatus = $jamaah->passport->status_visa;
                                        $visaClass = match($visaStatus) {
                                            'Approved' => 'bg-green-100 text-green-800',
                                            'Issued' => 'bg-blue-100 text-blue-800',
                                            'Rejected' => 'bg-red-100 text-red-800',
                                            default => 'bg-yellow-100 text-yellow-800',
                                        };
                                    @endphp
                                    <div class="flex items-center text-xs pt-1">
                                        <i class="fas fa-stamp w-4 text-gray-400"></i>
                                        <button @click="editVisa = { id: {{ $jamaah->passport->id_passport }}, name: '{{ $jamaah->nama_lengkap }}', current: '{{ $visaStatus }}' }" class="{{ $visaClass }} px-1.5 py-0.5 rounded text-[10px] font-semibold hover:opacity-80 transition-opacity">
                                            Visa: {{ $visaStatus }} <i class="fas fa-pencil-alt ml-1 opacity-50"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        @if($embarkasi->status == 'Belum Berangkat')
                        <div class="absolute top-2 right-2">
                             <form action="{{ route('embarkasi.remove-jamaah', ['id' => $embarkasi->id_embarkasi, 'jamaahId' => $jamaah->id_jamaah]) }}" method="POST" onsubmit="return confirm('Hapus jamaah dari manifest ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors p-1">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                    @empty
                    <div class="col-span-full py-8 text-center text-gray-500">
                        <i class="fas fa-users text-gray-300 text-4xl mb-3"></i>
                        <p>Belum ada jamaah dalam manifest ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Upload Section -->
            <div class="mt-6 bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Dokumen Keberangkatan</h3>
                
                <form action="{{ route('embarkasi.upload-documents', $embarkasi->id_embarkasi) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Boarding Pass Upload -->
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center text-center hover:bg-gray-50 transition-colors relative">
                            <input type="file" name="boarding_pass_file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="this.nextElementSibling.classList.remove('hidden'); this.nextElementSibling.nextElementSibling.classList.add('hidden');">
                            <div class="hidden z-0">
                                <i class="fas fa-check-circle text-3xl text-green-500 mb-2"></i>
                                <span class="font-medium text-gray-600 block">File Dipilih</span>
                            </div>
                            <div class="z-0">
                                <i class="fas fa-file-upload text-3xl text-gray-400 mb-2"></i>
                                <span class="font-medium text-gray-600 block">Upload Boarding Pass (ZIP/PDF)</span>
                                <span class="text-xs text-gray-400 mt-1">Maks. 10MB</span>
                            </div>
                            @if($embarkasi->boarding_pass_file)
                                <div class="mt-2 z-20">
                                    <a href="{{ asset('storage/' . $embarkasi->boarding_pass_file) }}" target="_blank" class="text-xs text-blue-600 hover:underline flex items-center bg-white px-2 py-1 rounded shadow-sm border">
                                        <i class="fas fa-download mr-1"></i> Lihat File
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Manifest Final Upload -->
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center text-center hover:bg-gray-50 transition-colors relative">
                            <input type="file" name="manifest_file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="this.nextElementSibling.classList.remove('hidden'); this.nextElementSibling.nextElementSibling.classList.add('hidden');">
                            <div class="hidden z-0">
                                <i class="fas fa-check-circle text-3xl text-green-500 mb-2"></i>
                                <span class="font-medium text-gray-600 block">File Dipilih</span>
                            </div>
                            <div class="z-0">
                                <i class="fas fa-file-upload text-3xl text-gray-400 mb-2"></i>
                                <span class="font-medium text-gray-600 block">Upload Manifest Final</span>
                                <span class="text-xs text-gray-400 mt-1">Maks. 5MB</span>
                            </div>
                            @if($embarkasi->manifest_file)
                                <div class="mt-2 z-20">
                                    <a href="{{ asset('storage/' . $embarkasi->manifest_file) }}" target="_blank" class="text-xs text-blue-600 hover:underline flex items-center bg-white px-2 py-1 rounded shadow-sm border">
                                        <i class="fas fa-download mr-1"></i> Lihat File
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm">
                            <i class="fas fa-cloud-upload-alt mr-2"></i> Simpan Dokumen
                        </button>
                    </div>
                </form>
            </div>

            <!-- Edit Visa Modal -->
            <div x-show="editVisa" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Background overlay -->
                    <div x-show="editVisa" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <!-- Modal panel -->
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div x-show="editVisa" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        
                        <form method="POST" :action="`{{ url('/passport') }}/${editVisa?.id}/update-status`">
                            @csrf
                            @method('PATCH')
                            
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <i class="fas fa-stamp text-emerald-600"></i>
                                    </div>
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                            Update Status Visa
                                        </h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">
                                                Ubah status visa untuk jamaah <span class="font-bold text-gray-800" x-text="editVisa?.name"></span>.
                                            </p>
                                            
                                            <div class="mt-4">
                                                <label for="status_visa" class="block text-sm font-medium text-gray-700">Status Visa Baru</label>
                                                <select id="status_visa" name="status_visa" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm rounded-md" x-model="editVisa.current">
                                                    <option value="Pending">Pending</option>
                                                    <option value="Approved">Approved</option>
                                                    <option value="Issued">Issued (Visa Keluar)</option>
                                                    <option value="Rejected">Rejected (Ditolak)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Simpan Perubahan
                                </button>
                                <button type="button" @click="editVisa = null" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Distribute Items Modal -->
            <div x-show="distributeItems" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Background overlay -->
                    <div x-show="distributeItems" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <!-- Modal panel -->
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div x-show="distributeItems" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                        
                        <form method="POST" :action="`{{ url('/embarkasi') }}/{{ $embarkasi->id_embarkasi }}/distribute-items/${distributeItems?.id}`">
                            @csrf
                            
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <i class="fas fa-tshirt text-emerald-600"></i>
                                    </div>
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                            Distribusi Perlengkapan
                                        </h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500 mb-4">
                                                Pilih barang yang akan diserahkan kepada <span class="font-bold text-gray-800" x-text="distributeItems?.name"></span>. Stok akan berkurang otomatis.
                                            </p>
                                            
                                            <div class="overflow-y-auto max-h-60 border rounded-md">
                                                <table class="min-w-full divide-y divide-gray-200">
                                                    <thead class="bg-gray-50">
                                                        <tr>
                                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Pilih
                                                            </th>
                                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Nama Barang
                                                            </th>
                                                            <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Stok Tersedia
                                                            </th>
                                                            <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Qty
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200">
                                                        @foreach($stokItems as $item)
                                                        <tr>
                                                            <td class="px-4 py-2 whitespace-nowrap">
                                                                <input type="checkbox" name="items[{{ $item->id_stok }}][selected]" value="1" class="focus:ring-emerald-500 h-4 w-4 text-emerald-600 border-gray-300 rounded" {{ $item->stok_tersedia <= 0 ? 'disabled' : '' }}>
                                                            </td>
                                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                                                {{ $item->nama_barang }}
                                                                <input type="hidden" name="items[{{ $item->id_stok }}][id_stok]" value="{{ $item->id_stok }}">
                                                            </td>
                                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-right font-mono {{ $item->stok_tersedia <= 0 ? 'text-red-500' : 'text-emerald-600' }}">
                                                                {{ $item->stok_tersedia }}
                                                            </td>
                                                            <td class="px-4 py-2 whitespace-nowrap text-center">
                                                                <input type="number" name="items[{{ $item->id_stok }}][qty]" min="1" max="{{ $item->stok_tersedia }}" value="1" class="w-16 py-1 px-2 border border-gray-300 rounded-md text-sm text-center focus:ring-emerald-500 focus:border-emerald-500" {{ $item->stok_tersedia <= 0 ? 'disabled' : '' }}>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        @if($stokItems->isEmpty())
                                                        <tr>
                                                            <td colspan="4" class="px-4 py-4 text-center text-sm text-gray-500">
                                                                Tidak ada stok barang yang tersedia. Silakan input di menu Inventory.
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Serahkan Barang
                                </button>
                                <button type="button" @click="distributeItems = null" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Visa Modal (Removed from outside) -->
</x-app-layout>
