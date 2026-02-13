<x-app-layout>
    <x-slot name="header">
        Data Paspor & Visa
    </x-slot>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Daftar Paspor Jamaah</h2>
            <a href="{{ route('passport.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 transition-colors flex items-center">
                <i class="fas fa-plus mr-2"></i> Tambah Paspor
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 uppercase text-xs leading-normal">
                        <th class="py-3 px-6">Nama Jamaah</th>
                        <th class="py-3 px-6">No Paspor</th>
                        <th class="py-3 px-6">Tgl Terbit / Expire</th>
                        <th class="py-3 px-6">Kota Lahir</th>
                        <th class="py-3 px-6">Status Visa</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse($passports as $p)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6">
                            <div class="flex flex-col">
                                <span class="font-semibold">{{ $p->nama_passport }}</span>
                                <span class="text-xs text-gray-500">{{ $p->jamaah->kode_jamaah ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-6 font-medium">{{ $p->no_passport }}</td>
                        <td class="py-3 px-6">
                            <div class="flex flex-col">
                                <span class="text-xs">Issued: {{ $p->date_issued->format('d M Y') }}</span>
                                <span class="text-xs {{ $p->date_expire < now()->addMonths(6) ? 'text-red-500 font-bold' : '' }}">
                                    Expire: {{ $p->date_expire->format('d M Y') }}
                                </span>
                            </div>
                        </td>
                        <td class="py-3 px-6">{{ $p->birth_city }}</td>
                        <td class="py-3 px-6">
                            @php
                                $statusClass = match($p->status_visa) {
                                    'Approved' => 'bg-green-200 text-green-600',
                                    'Issued' => 'bg-blue-200 text-blue-600',
                                    'Rejected' => 'bg-red-200 text-red-600',
                                    default => 'bg-yellow-200 text-yellow-600',
                                };
                            @endphp
                            <span class="{{ $statusClass }} py-1 px-3 rounded-full text-xs">
                                {{ $p->status_visa }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center">
                                @if($p->scan_passport)
                                <a href="{{ asset('storage/' . $p->scan_passport) }}" target="_blank" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" title="Lihat Scan">
                                    <i class="fas fa-file-image"></i>
                                </a>
                                @endif
                                <a href="{{ route('passport.edit', $p->id_passport) }}" class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('passport.destroy', $p->id_passport) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                        <td colspan="6" class="py-6 px-6 text-center text-gray-500">
                            Belum ada data paspor.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-gray-200">
            {{ $passports->links() }}
        </div>
    </div>
</x-app-layout>
