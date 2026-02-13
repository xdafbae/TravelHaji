<x-app-layout>
    <x-slot name="header">
        Data Jamaah
    </x-slot>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Daftar Jamaah</h2>
            <a href="{{ route('jamaah.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 transition-colors flex items-center">
                <i class="fas fa-plus mr-2"></i> Tambah Jamaah
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 uppercase text-xs leading-normal">
                        <th class="py-3 px-6">ID Jamaah</th>
                        <th class="py-3 px-6">Nama Lengkap</th>
                        <th class="py-3 px-6">Jenis Kelamin</th>
                        <th class="py-3 px-6">No HP</th>
                        <th class="py-3 px-6">Status Keberangkatan</th>
                        <th class="py-3 px-6 text-center">Status Pembayaran</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse($jamaah as $j)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 whitespace-nowrap font-medium">{{ $j->kode_jamaah }}</td>
                        <td class="py-3 px-6">{{ $j->nama_lengkap }}</td>
                        <td class="py-3 px-6">{{ $j->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td class="py-3 px-6">{{ $j->no_hp }}</td>
                        <td class="py-3 px-6">
                            <span class="bg-{{ $j->status_keberangkatan == 'Sudah Berangkat' ? 'green' : 'yellow' }}-200 text-{{ $j->status_keberangkatan == 'Sudah Berangkat' ? 'green' : 'yellow' }}-600 py-1 px-3 rounded-full text-xs">
                                {{ $j->status_keberangkatan }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-center">
                            @php
                                $latestEmbarkasi = $j->embarkasi->first();
                                $paymentStatus = $latestEmbarkasi ? $latestEmbarkasi->pivot->payment_status : 'Belum Terdaftar';
                                
                                $paymentColor = match($paymentStatus) {
                                    'Lunas' => 'bg-green-100 text-green-800',
                                    'Belum Lunas' => 'bg-red-100 text-red-800',
                                    'Pending' => 'bg-yellow-100 text-yellow-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                            @endphp
                            <span class="{{ $paymentColor }} py-1 px-3 rounded-full text-xs font-semibold">
                                {{ $paymentStatus }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center">
                                <!-- View (Future Implementation) -->
                                <a href="#" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <!-- Edit -->
                                <a href="{{ route('jamaah.edit', $j->id_jamaah) }}" class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <!-- Delete -->
                                <form action="{{ route('jamaah.destroy', $j->id_jamaah) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                            Belum ada data jamaah.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-gray-200">
            {{ $jamaah->links() }}
        </div>
    </div>
</x-app-layout>
