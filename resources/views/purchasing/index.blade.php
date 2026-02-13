<x-app-layout>
    <x-slot name="header">
        Purchasing (Purchase Order)
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Action Button -->
        <div class="mb-4 flex justify-end">
            <a href="{{ route('purchasing.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 text-sm flex items-center shadow">
                <i class="fas fa-plus mr-2"></i> Buat PO Baru
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 uppercase text-xs leading-normal">
                                <th class="py-3 px-6">Kode PO</th>
                                <th class="py-3 px-6">Tanggal</th>
                                <th class="py-3 px-6">Supplier</th>
                                <th class="py-3 px-6 text-right">Total Amount</th>
                                <th class="py-3 px-6 text-center">Status</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @forelse($purchases as $po)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 font-mono font-medium">{{ $po->kode_purchase }}</td>
                                <td class="py-3 px-6">{{ $po->waktu_preorder ? date('d M Y', strtotime($po->waktu_preorder)) : '-' }}</td>
                                <td class="py-3 px-6">{{ $po->supplier->nama_supplier ?? '-' }}</td>
                                <td class="py-3 px-6 text-right font-bold text-gray-800">Rp {{ number_format($po->total_amount, 0, ',', '.') }}</td>
                                <td class="py-3 px-6 text-center">
                                    @php
                                        $statusClass = match($po->status) {
                                            'Lunas' => 'bg-green-100 text-green-800',
                                            'Ada Data' => 'bg-blue-100 text-blue-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                    @endphp
                                    <span class="{{ $statusClass }} py-1 px-3 rounded-full text-xs">
                                        {{ $po->status }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        <a href="{{ route('purchasing.show', $po->id_purchase) }}" class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110" title="Detail / Kelola Item">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('purchasing.edit', $po->id_purchase) }}" class="w-4 mr-2 transform hover:text-yellow-500 hover:scale-110" title="Edit Header">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('purchasing.destroy', $po->id_purchase) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus PO ini?');">
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
                                    Belum ada data Purchase Order.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $purchases->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
