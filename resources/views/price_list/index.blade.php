<x-app-layout>
    <x-slot name="header">
        Price List / Katalog Harga
    </x-slot>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Daftar Harga Item</h2>
            <a href="{{ route('price-list.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 transition-colors flex items-center">
                <i class="fas fa-plus mr-2"></i> Tambah Item
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 uppercase text-xs leading-normal">
                        <th class="py-3 px-6">Kode</th>
                        <th class="py-3 px-6">Nama Item</th>
                        <th class="py-3 px-6">Harga</th>
                        <th class="py-3 px-6">Kategori Form</th>
                        <th class="py-3 px-6">Status</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse($priceLists as $item)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 whitespace-nowrap font-medium">{{ $item->kode_item }}</td>
                        <td class="py-3 px-6">
                            <div class="flex flex-col">
                                <span class="font-semibold">{{ $item->nama_item }}</span>
                                <span class="text-xs text-gray-500">{{ Str::limit($item->keterangan, 30) }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-6 font-semibold">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="py-3 px-6">
                            <div class="flex flex-wrap gap-1">
                                @if($item->form_a) <span class="bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded">A</span> @endif
                                @if($item->form_b) <span class="bg-purple-100 text-purple-800 text-xs px-2 py-0.5 rounded">B</span> @endif
                                @if($item->form_c) <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-0.5 rounded">C</span> @endif
                                @if($item->form_d) <span class="bg-pink-100 text-pink-800 text-xs px-2 py-0.5 rounded">D</span> @endif
                            </div>
                        </td>
                        <td class="py-3 px-6">
                            <span class="{{ $item->is_active ? 'bg-green-200 text-green-600' : 'bg-red-200 text-red-600' }} py-1 px-3 rounded-full text-xs">
                                {{ $item->is_active ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center">
                                <a href="{{ route('price-list.edit', $item->id_pricelist) }}" class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('price-list.destroy', $item->id_pricelist) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                            Belum ada data Price List.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-gray-200">
            {{ $priceLists->links() }}
        </div>
    </div>
</x-app-layout>
