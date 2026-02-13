<x-app-layout>
    <x-slot name="header">
        Detail Purchase Order: {{ $purchase->kode_purchase }}
    </x-slot>

    <!-- Success Message -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- Header Info -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">{{ $purchase->supplier->nama_supplier }}</h3>
                        <p class="text-sm text-gray-500">{{ $purchase->supplier->alamat }}</p>
                        <p class="text-sm text-gray-500 mt-1"><i class="fas fa-phone mr-1"></i> {{ $purchase->supplier->kontak }}</p>
                    </div>
                    <div class="text-right">
                        <span class="block text-xs text-gray-500 uppercase tracking-wide">Status PO</span>
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $purchase->status == 'Lunas' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }} mt-1">
                            {{ $purchase->status }}
                        </span>
                        <p class="text-sm text-gray-600 mt-2">Tanggal: <strong>{{ date('d M Y', strtotime($purchase->waktu_preorder)) }}</strong></p>
                    </div>
                </div>
                
                @if($purchase->keterangan)
                <div class="mt-4 p-3 bg-gray-50 rounded text-sm text-gray-600 italic border-l-4 border-gray-300">
                    "{{ $purchase->keterangan }}"
                </div>
                @endif
                
                <div class="mt-4 flex space-x-2">
                    <a href="{{ route('purchasing.edit', $purchase->id_purchase) }}" class="text-sm text-blue-600 hover:underline">Edit Header</a>
                    <span class="text-gray-300">|</span>
                    <a href="{{ route('purchasing.index') }}" class="text-sm text-gray-600 hover:underline">Kembali ke List</a>
                </div>
            </div>
        </div>

        <!-- Items Section -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Daftar Item Barang</h4>

                <!-- Add Item Form -->
                @if($purchase->status != 'Lunas')
                <div class="bg-gray-50 p-4 rounded-lg mb-6 border border-gray-200">
                    <form action="{{ route('purchasing.add-item', $purchase->id_purchase) }}" method="POST" class="flex flex-col md:flex-row items-end gap-4">
                        @csrf
                        <div class="flex-1 w-full">
                            <x-input-label for="id_stok" :value="__('Pilih Barang')" />
                            <select id="id_stok" name="id_stok" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id_stok }}">{{ $item->kode_barang }} - {{ $item->nama_barang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full md:w-32">
                            <x-input-label for="qty" :value="__('Qty')" />
                            <x-text-input id="qty" class="block mt-1 w-full" type="number" name="qty" min="1" value="1" required />
                        </div>
                        <div class="w-full md:w-48">
                            <x-input-label for="harga_satuan" :value="__('Harga Satuan (Rp)')" />
                            <x-text-input id="harga_satuan" class="block mt-1 w-full" type="number" name="harga_satuan" min="0" required placeholder="0" />
                        </div>
                        <div class="w-full md:w-auto">
                            <x-primary-button class="bg-emerald-600 hover:bg-emerald-700 w-full md:w-auto justify-center">
                                <i class="fas fa-plus mr-2"></i> Tambah
                            </x-primary-button>
                        </div>
                    </form>
                </div>
                @endif

                <!-- Items Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 uppercase text-xs leading-normal">
                                <th class="py-3 px-6">No</th>
                                <th class="py-3 px-6">Kode Barang</th>
                                <th class="py-3 px-6">Nama Barang</th>
                                <th class="py-3 px-6 text-right">Qty</th>
                                <th class="py-3 px-6 text-right">Harga Satuan</th>
                                <th class="py-3 px-6 text-right">Subtotal</th>
                                @if($purchase->status != 'Lunas')
                                <th class="py-3 px-6 text-center">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @forelse($purchase->details as $index => $detail)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6">{{ $index + 1 }}</td>
                                <td class="py-3 px-6 font-mono">{{ $detail->stok->kode_barang }}</td>
                                <td class="py-3 px-6">{{ $detail->stok->nama_barang }}</td>
                                <td class="py-3 px-6 text-right font-medium">{{ number_format($detail->qty, 0, ',', '.') }}</td>
                                <td class="py-3 px-6 text-right">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                <td class="py-3 px-6 text-right font-bold text-gray-800">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                @if($purchase->status != 'Lunas')
                                <td class="py-3 px-6 text-center">
                                    <form action="{{ route('purchasing.remove-item', ['id' => $purchase->id_purchase, 'detailId' => $detail->id]) }}" method="POST" onsubmit="return confirm('Hapus item ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition-colors">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ $purchase->status != 'Lunas' ? 7 : 6 }}" class="py-8 text-center text-gray-500 italic">
                                    Belum ada item dalam PO ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-gray-100 font-bold text-gray-800">
                            <tr>
                                <td colspan="5" class="py-4 px-6 text-right text-lg">Total Purchase Order</td>
                                <td class="py-4 px-6 text-right text-lg text-emerald-700">Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</td>
                                @if($purchase->status != 'Lunas')
                                <td></td>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
