<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Edit Purchase Order') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kode: <span class="font-mono font-bold text-blue-600">{{ $purchase->kode_purchase }}</span></p>
            </div>
            <div class="mt-4 md:mt-0">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                <i class="fas fa-home mr-2"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                <a href="{{ route('purchasing.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Purchasing</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                <span class="text-sm font-medium text-gray-500">Edit</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- Error / Success Handling -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif
        
        @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada inputan:</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left Column: Header Edit -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Edit Header PO</h3>
                        
                        <form action="{{ route('purchasing.update', $purchase->id_purchase) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="space-y-4">
                                <!-- Supplier -->
                                <div>
                                    <x-input-label for="id_supplier" :value="__('Supplier')" />
                                    <select id="id_supplier" name="id_supplier" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm block mt-1 w-full text-sm" required>
                                        <option value="">-- Pilih Supplier --</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id_supplier }}" {{ old('id_supplier', $purchase->id_supplier) == $supplier->id_supplier ? 'selected' : '' }}>
                                                {{ $supplier->nama_supplier }} ({{ $supplier->kategori }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Tanggal Preorder -->
                                <div>
                                    <x-input-label for="waktu_preorder" :value="__('Tanggal PO')" />
                                    <x-text-input id="waktu_preorder" class="block mt-1 w-full text-sm" type="date" name="waktu_preorder" :value="old('waktu_preorder', date('Y-m-d', strtotime($purchase->waktu_preorder)))" required />
                                </div>

                                <!-- Tanggal Barang Datang -->
                                <div>
                                    <x-input-label for="tgl_barang_datang" :value="__('Tgl Datang (Est)')" />
                                    <x-text-input id="tgl_barang_datang" class="block mt-1 w-full text-sm" type="date" name="tgl_barang_datang" :value="old('tgl_barang_datang', $purchase->tgl_barang_datang ? date('Y-m-d', strtotime($purchase->tgl_barang_datang)) : '')" />
                                </div>

                                <!-- Status -->
                                <div>
                                    <x-input-label for="status" :value="__('Status PO')" />
                                    <select id="status" name="status" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm block mt-1 w-full text-sm" required>
                                        <option value="Data Masih Kosong" {{ old('status', $purchase->status) == 'Data Masih Kosong' ? 'selected' : '' }}>Data Masih Kosong</option>
                                        <option value="Ada Data" {{ old('status', $purchase->status) == 'Ada Data' ? 'selected' : '' }}>Ada Data (On Process)</option>
                                        <option value="Lunas" {{ old('status', $purchase->status) == 'Lunas' ? 'selected' : '' }}>Lunas / Selesai</option>
                                    </select>
                                    <p class="text-xs text-gray-500 mt-1">Status 'Lunas' akan menambah stok barang.</p>
                                </div>

                                <!-- Keterangan -->
                                <div>
                                    <x-input-label for="keterangan" :value="__('Catatan')" />
                                    <textarea id="keterangan" name="keterangan" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm" rows="3">{{ old('keterangan', $purchase->keterangan) }}</textarea>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-between items-center">
                                <div class="text-xs text-gray-400">
                                    Last update: {{ $purchase->updated_at->diffForHumans() }}
                                </div>
                                <x-primary-button class="bg-blue-600 hover:bg-blue-700">
                                    {{ __('Update Header') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column: Item Management -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Add Item Form -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah Item</h3>
                        <form action="{{ route('purchasing.add-item', $purchase->id_purchase) }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                            @csrf
                            <div class="md:col-span-5">
                                <x-input-label for="id_stok" :value="__('Produk')" />
                                <select id="id_stok" name="id_stok" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm block mt-1 w-full text-sm" required>
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id_stok }}">{{ $item->kode_barang }} - {{ $item->nama_barang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="qty" :value="__('Qty')" />
                                <x-text-input id="qty" class="block mt-1 w-full text-sm" type="number" name="qty" min="1" value="1" required />
                            </div>
                            <div class="md:col-span-3">
                                <x-input-label for="harga_satuan" :value="__('Harga (@)')" />
                                <div class="relative mt-1 rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <span class="text-gray-500 sm:text-sm font-bold">Rp</span>
                                    </div>
                                    <input type="number" name="harga_satuan" id="harga_satuan" min="0" placeholder="0" class="block w-full rounded-md border-gray-300 pl-10 focus:border-emerald-500 focus:ring-emerald-500 text-sm" required />
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <button type="submit" class="w-full px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:outline-none transition ease-in-out duration-150">
                                    <i class="fas fa-plus"></i> Tambah
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Items List -->
                    <div class="p-0">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-white border-b border-gray-200">
                                    <tr class="text-xs text-gray-500 uppercase">
                                        <th class="py-3 px-6">Barang</th>
                                        <th class="py-3 px-6 text-right">Qty</th>
                                        <th class="py-3 px-6 text-right">Harga</th>
                                        <th class="py-3 px-6 text-right">Subtotal</th>
                                        <th class="py-3 px-6 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($purchase->details as $detail)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-6">
                                            <div class="text-sm font-medium text-gray-900">{{ $detail->stok->nama_barang }}</div>
                                            <div class="text-xs text-gray-500 font-mono">{{ $detail->stok->kode_barang }}</div>
                                        </td>
                                        <td class="py-3 px-6 text-right text-sm">{{ number_format($detail->qty) }}</td>
                                        <td class="py-3 px-6 text-right text-sm">{{ \App\Helpers\CurrencyHelper::formatRupiah($detail->harga_satuan) }}</td>
                                        <td class="py-3 px-6 text-right text-sm font-bold">{{ \App\Helpers\CurrencyHelper::formatRupiah($detail->subtotal) }}</td>
                                        <td class="py-3 px-6 text-center">
                                            <form action="{{ route('purchasing.remove-item', ['id' => $purchase->id_purchase, 'detailId' => $detail->id]) }}" method="POST" onsubmit="return confirm('Hapus item ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-600 transition-colors" title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-gray-500 text-sm italic">
                                            Belum ada item. Silakan tambah item di atas.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="3" class="py-3 px-6 text-right text-sm font-bold text-gray-600">Total:</td>
                                        <td class="py-3 px-6 text-right text-sm font-bold text-emerald-600">{{ \App\Helpers\CurrencyHelper::formatRupiah($purchase->total_amount) }}</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('purchasing.show', $purchase->id_purchase) }}" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none transition ease-in-out duration-150">
                        {{ __('Selesai & Lihat Detail') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>