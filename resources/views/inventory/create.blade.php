<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Master Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 bg-white border-b border-gray-200">
                    <form action="{{ route('inventory.store') }}" method="POST" x-data="{ submitting: false }" @submit="submitting = true">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Section: Identitas Barang -->
                            <div class="md:col-span-2 pb-4 border-b border-gray-100">
                                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-tag text-emerald-500 mr-2"></i> Identitas Barang
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="md:col-span-2">
                                        <x-input-label for="nama_barang" :value="__('Nama Barang')" />
                                        <x-text-input id="nama_barang" class="block mt-1 w-full" type="text" name="nama_barang" :value="old('nama_barang')" required autofocus placeholder="Contoh: Kain Ihram Dewasa Premium" />
                                        <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="kode_barang" :value="__('Kode Barang (Unique)')" />
                                        <x-text-input id="kode_barang" class="block mt-1 w-full" type="text" name="kode_barang" :value="old('kode_barang')" required placeholder="Contoh: KIN-001" />
                                        <x-input-error :messages="$errors->get('kode_barang')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="inisial_barang" :value="__('Inisial (Opsional)')" />
                                        <x-text-input id="inisial_barang" class="block mt-1 w-full" type="text" name="inisial_barang" :value="old('inisial_barang')" placeholder="Contoh: KIP" />
                                        <x-input-error :messages="$errors->get('inisial_barang')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Pengaturan Stok -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-cubes text-emerald-500 mr-2"></i> Pengaturan Stok
                                </h3>
                                
                                <div>
                                    <x-input-label for="stok_awal" :value="__('Stok Awal (Saldo Awal)')" />
                                    <div class="relative mt-1">
                                        <x-text-input id="stok_awal" class="block w-full pl-4" type="number" name="stok_awal" :value="old('stok_awal', 0)" required min="0" />
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">unit</span>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1"><i class="fas fa-info-circle mr-1"></i> Stok saat ini akan diset sama dengan stok awal.</p>
                                    <x-input-error :messages="$errors->get('stok_awal')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="buffer_stok" :value="__('Buffer Stok (Batas Minimal)')" />
                                    <div class="relative mt-1">
                                        <x-text-input id="buffer_stok" class="block w-full pl-4" type="number" name="buffer_stok" :value="old('buffer_stok', 5)" required min="0" />
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
                                            <input id="is_tersedia" type="checkbox" name="is_tersedia" value="1" class="w-5 h-5 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500" {{ old('is_tersedia', true) ? 'checked' : '' }}>
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="is_tersedia" class="font-medium text-gray-700">Barang Aktif / Tersedia</label>
                                            <p class="text-gray-500">Barang non-aktif tidak akan muncul di pilihan transaksi.</p>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <x-input-label for="keterangan" :value="__('Keterangan Tambahan')" />
                                    <textarea id="keterangan" name="keterangan" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" rows="3" placeholder="Deskripsi, lokasi penyimpanan, atau catatan lain...">{{ old('keterangan') }}</textarea>
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
                                <span x-text="submitting ? 'Menyimpan...' : 'Simpan Barang'">Simpan Barang</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>