<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Master Barang') }}: {{ $item->nama_barang }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 bg-white border-b border-gray-200">
                    <form action="{{ route('inventory.update', $item->id_stok) }}" method="POST" x-data="{ submitting: false }" @submit="submitting = true">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Section: Identitas Barang -->
                            <div class="md:col-span-2 pb-4 border-b border-gray-100">
                                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-tag text-emerald-500 mr-2"></i> Identitas Barang
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="md:col-span-2">
                                        <x-input-label for="nama_barang" :value="__('Nama Barang')" />
                                        <x-text-input id="nama_barang" class="block mt-1 w-full" type="text" name="nama_barang" :value="old('nama_barang', $item->nama_barang)" required autofocus />
                                        <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="kode_barang" :value="__('Kode Barang (Unique)')" />
                                        <x-text-input id="kode_barang" class="block mt-1 w-full" type="text" name="kode_barang" :value="old('kode_barang', $item->kode_barang)" required />
                                        <x-input-error :messages="$errors->get('kode_barang')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="inisial_barang" :value="__('Inisial (Opsional)')" />
                                        <x-text-input id="inisial_barang" class="block mt-1 w-full" type="text" name="inisial_barang" :value="old('inisial_barang', $item->inisial_barang)" />
                                        <x-input-error :messages="$errors->get('inisial_barang')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Informasi Stok Real-time -->
                            <div class="md:col-span-2">
                                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center justify-between">
                                    <span class="flex items-center"><i class="fas fa-chart-pie text-emerald-500 mr-2"></i> Informasi Stok Saat Ini</span>
                                    @if($item->stok_tersedia <= $item->buffer_stok)
                                        <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded animate-pulse">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> LOW STOCK
                                        </span>
                                    @else
                                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                            <i class="fas fa-check-circle mr-1"></i> AMAN
                                        </span>
                                    @endif
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 text-center">
                                        <p class="text-xs text-gray-500 uppercase tracking-wide">Stok Awal</p>
                                        <p class="text-xl font-bold text-gray-700">{{ number_format($item->stok_awal, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 text-center">
                                        <p class="text-xs text-gray-500 uppercase tracking-wide">Stok Keluar</p>
                                        <p class="text-xl font-bold text-gray-700">{{ number_format($item->stok_keluar, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="bg-emerald-50 p-4 rounded-lg border border-emerald-100 text-center ring-2 ring-emerald-500 ring-opacity-20">
                                        <p class="text-xs text-emerald-600 uppercase tracking-wide font-bold">Stok Tersedia</p>
                                        <p class="text-2xl font-bold text-emerald-700">{{ number_format($item->stok_tersedia, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Pengaturan Stok -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-cog text-emerald-500 mr-2"></i> Pengaturan Batas
                                </h3>
                                
                                <div>
                                    <x-input-label for="buffer_stok" :value="__('Buffer Stok (Batas Minimal)')" />
                                    <div class="relative mt-1">
                                        <x-text-input id="buffer_stok" class="block w-full pl-4" type="number" name="buffer_stok" :value="old('buffer_stok', $item->buffer_stok)" required min="0" />
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">unit</span>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1"><i class="fas fa-bell mr-1"></i> Peringatan akan muncul jika stok di bawah jumlah ini.</p>
                                    <x-input-error :messages="$errors->get('buffer_stok')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Section: Status & Keterangan -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-info-circle text-emerald-500 mr-2"></i> Status & Lainnya
                                </h3>

                                <div class="bg-gray-50 p-4 rounded-md border border-gray-100">
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="is_tersedia" type="checkbox" name="is_tersedia" value="1" class="w-5 h-5 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500" {{ old('is_tersedia', $item->is_tersedia) ? 'checked' : '' }}>
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="is_tersedia" class="font-medium text-gray-700">Barang Aktif / Tersedia</label>
                                            <p class="text-gray-500">Barang non-aktif tidak akan muncul di pilihan transaksi.</p>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <x-input-label for="keterangan" :value="__('Keterangan Tambahan')" />
                                    <textarea id="keterangan" name="keterangan" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" rows="3">{{ old('keterangan', $item->keterangan) }}</textarea>
                                    <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-100">
                            <a href="{{ route('inventory.index') }}" class="text-gray-600 hover:text-gray-900 mr-4 text-sm font-medium transition-colors">
                                {{ __('Batal') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150" :disabled="submitting" :class="{ 'opacity-75 cursor-not-allowed': submitting }">
                                <span x-show="submitting" class="mr-2" style="display: none;">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </span>
                                <span x-text="submitting ? 'Menyimpan...' : 'Update Barang'">Update Barang</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>