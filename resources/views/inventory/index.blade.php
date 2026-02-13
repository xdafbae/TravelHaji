<x-app-layout>
    <x-slot name="header">
        Stok Barang (Inventory)
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Action Button -->
        <div class="mb-4 flex justify-end">
            <a href="{{ route('inventory.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 text-sm flex items-center shadow">
                <i class="fas fa-plus mr-2"></i> Tambah Barang
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 uppercase text-xs leading-normal">
                                <th class="py-3 px-6">Kode</th>
                                <th class="py-3 px-6">Nama Barang</th>
                                <th class="py-3 px-6">Inisial</th>
                                <th class="py-3 px-6 text-center">Stok Tersedia</th>
                                <th class="py-3 px-6 text-center">Buffer Stok</th>
                                <th class="py-3 px-6 text-center">Status</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @forelse($items as $item)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 font-mono text-xs">{{ $item->kode_barang }}</td>
                                <td class="py-3 px-6 font-medium text-gray-800">{{ $item->nama_barang }}</td>
                                <td class="py-3 px-6">{{ $item->inisial_barang ?? '-' }}</td>
                                <td class="py-3 px-6 text-center">
                                    <span class="font-bold text-lg {{ $item->stok_tersedia <= $item->buffer_stok ? 'text-red-600' : 'text-emerald-600' }}">
                                        {{ number_format($item->stok_tersedia, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-center text-gray-500">{{ $item->buffer_stok }}</td>
                                <td class="py-3 px-6 text-center">
                                    @if($item->is_tersedia)
                                        <span class="bg-green-100 text-green-800 py-1 px-2 rounded text-xs">Aktif</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 py-1 px-2 rounded text-xs">Non-Aktif</span>
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        <a href="{{ route('inventory.edit', $item->id_stok) }}" class="w-4 mr-2 transform hover:text-yellow-500 hover:scale-110" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('inventory.destroy', $item->id_stok) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus barang ini?');">
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
                                    Belum ada data barang.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
