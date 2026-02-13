<x-app-layout>
    <x-slot name="header">
        Jadwal Keberangkatan
    </x-slot>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm overflow-hidden" x-data="{ view: 'table' }">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Daftar Keberangkatan</h2>
            
            <div class="flex items-center space-x-4">
                <!-- View Toggle -->
                <div class="bg-gray-100 p-1 rounded-lg flex">
                    <button @click="view = 'table'" :class="{ 'bg-white shadow-sm text-emerald-600': view === 'table', 'text-gray-500 hover:text-gray-700': view !== 'table' }" class="px-3 py-1.5 rounded-md text-sm font-medium transition-all flex items-center">
                        <i class="fas fa-list mr-2"></i> List
                    </button>
                    <button @click="view = 'grid'" :class="{ 'bg-white shadow-sm text-emerald-600': view === 'grid', 'text-gray-500 hover:text-gray-700': view !== 'grid' }" class="px-3 py-1.5 rounded-md text-sm font-medium transition-all flex items-center">
                        <i class="fas fa-th-large mr-2"></i> Grid
                    </button>
                </div>

                <a href="{{ route('embarkasi.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 transition-colors flex items-center">
                    <i class="fas fa-plus mr-2"></i> Buat Jadwal
                </a>
            </div>
        </div>
        
        <!-- Table View -->
        <div x-show="view === 'table'" class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 uppercase text-xs leading-normal">
                        <th class="py-3 px-6">Kode</th>
                        <th class="py-3 px-6">Paket</th>
                        <th class="py-3 px-6">Kota Keberangkatan</th>
                        <th class="py-3 px-6">Waktu</th>
                        <th class="py-3 px-6">Kapasitas</th>
                        <th class="py-3 px-6">Status</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse($embarkasi as $e)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 whitespace-nowrap font-medium">{{ $e->kode_embarkasi }}</td>
                        <td class="py-3 px-6">{{ $e->paket_haji_umroh }}</td>
                        <td class="py-3 px-6">{{ $e->kota_keberangkatan }}</td>
                        <td class="py-3 px-6">
                            <div class="flex flex-col">
                                <span class="font-semibold">{{ $e->waktu_keberangkatan->format('d M Y') }}</span>
                                <span class="text-xs text-gray-500">{{ $e->waktu_keberangkatan->format('H:i') }} WIB</span>
                            </div>
                        </td>
                        <td class="py-3 px-6">
                            <div class="flex items-center">
                                <span class="mr-2">{{ $e->jumlah_jamaah }} / {{ $e->kapasitas_jamaah }}</span>
                                <div class="w-24 bg-gray-200 rounded-full h-2.5">
                                    @php
                                        $percentage = $e->kapasitas_jamaah > 0 ? ($e->jumlah_jamaah / $e->kapasitas_jamaah) * 100 : 0;
                                        $color = $percentage > 90 ? 'bg-red-600' : ($percentage > 70 ? 'bg-yellow-400' : 'bg-green-600');
                                    @endphp
                                    <div class="{{ $color }} h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-6">
                            @php
                                $statusClass = match($e->status) {
                                    'Belum Berangkat' => 'bg-yellow-200 text-yellow-600',
                                    'Sudah Berangkat' => 'bg-blue-200 text-blue-600',
                                    'Selesai' => 'bg-green-200 text-green-600',
                                    default => 'bg-gray-200 text-gray-600',
                                };
                            @endphp
                            <span class="{{ $statusClass }} py-1 px-3 rounded-full text-xs">
                                {{ $e->status }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center">
                                <a href="{{ route('embarkasi.show', $e->id_embarkasi) }}" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" title="Lihat Detail & Manifest">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('embarkasi.edit', $e->id_embarkasi) }}" class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('embarkasi.destroy', $e->id_embarkasi) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-4 mr-2 transform hover:text-red-500 hover:scale-110" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-6 px-6 text-center text-gray-500">
                            Belum ada jadwal keberangkatan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Grid View -->
        <div x-show="view === 'grid'" class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" style="display: none;">
            @forelse($embarkasi as $e)
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 flex flex-col h-full">
                <!-- Header -->
                <div class="p-5 border-b border-gray-100 flex justify-between items-start bg-gray-50 rounded-t-xl">
                    <div>
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">{{ $e->kode_embarkasi }}</span>
                        <h3 class="font-bold text-gray-800 text-lg mt-1 line-clamp-1" title="{{ $e->paket_haji_umroh }}">{{ $e->paket_haji_umroh }}</h3>
                        <div class="flex items-center text-sm text-gray-500 mt-1">
                            <i class="fas fa-map-marker-alt text-emerald-500 mr-2"></i> {{ $e->kota_keberangkatan }}
                        </div>
                    </div>
                    @php
                        $statusClass = match($e->status) {
                            'Belum Berangkat' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                            'Sudah Berangkat' => 'bg-blue-100 text-blue-700 border-blue-200',
                            'Selesai' => 'bg-green-100 text-green-700 border-green-200',
                            default => 'bg-gray-100 text-gray-700 border-gray-200',
                        };
                    @endphp
                    <span class="{{ $statusClass }} px-2.5 py-1 rounded-full text-xs font-semibold border">
                        {{ $e->status }}
                    </span>
                </div>

                <!-- Body -->
                <div class="p-5 flex-1 space-y-4">
                    <!-- Schedule -->
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Keberangkatan</p>
                            <p class="font-medium text-gray-900">{{ $e->waktu_keberangkatan->format('d M Y') }}</p>
                            <p class="text-sm text-gray-500">{{ $e->waktu_keberangkatan->format('H:i') }} WIB</p>
                        </div>
                    </div>

                    <!-- Capacity -->
                    <div>
                        <div class="flex justify-between items-end mb-1">
                            <span class="text-xs text-gray-500 font-semibold uppercase">Kapasitas</span>
                            <span class="text-sm font-bold text-gray-700">{{ $e->jumlah_jamaah }} / {{ $e->kapasitas_jamaah }}</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                            @php
                                $percentage = $e->kapasitas_jamaah > 0 ? ($e->jumlah_jamaah / $e->kapasitas_jamaah) * 100 : 0;
                                $color = $percentage > 90 ? 'bg-red-500' : ($percentage > 70 ? 'bg-yellow-400' : 'bg-emerald-500');
                            @endphp
                            <div class="{{ $color }} h-2.5 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Footer / Actions -->
                <div class="p-4 bg-gray-50 border-t border-gray-100 rounded-b-xl flex justify-between items-center">
                    <a href="{{ route('embarkasi.show', $e->id_embarkasi) }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium flex items-center group">
                        Lihat Detail <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    
                    <div class="flex space-x-2">
                        <a href="{{ route('embarkasi.edit', $e->id_embarkasi) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-full transition-colors" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('embarkasi.destroy', $e->id_embarkasi) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-full transition-colors" title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full flex flex-col items-center justify-center py-12 text-center bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-plane-slash text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Belum ada jadwal keberangkatan</h3>
                <p class="text-gray-500 mt-1 max-w-sm">Silakan buat jadwal keberangkatan baru untuk memulai.</p>
                <a href="{{ route('embarkasi.create') }}" class="mt-4 px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 transition-colors inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i> Buat Jadwal
                </a>
            </div>
            @endforelse
        </div>
        
        <div class="p-4 border-t border-gray-200">
            {{ $embarkasi->links() }}
        </div>
    </div>
</x-app-layout>
