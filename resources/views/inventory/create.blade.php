<x-app-layout>
    <x-slot name="header">
        Tambah Master Barang
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('inventory.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Barang -->
                        <div class="md:col-span-2">
                            <x-input-label for="nama_barang" :value="__('Nama Barang')" />
                            <x-text-input id="nama_barang" class="block mt-1 w-full" type="text" name="nama_barang" :value="old('nama_barang')" required autofocus placeholder="Contoh: Kain Ihram Dewasa" />
                            <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                        </div>

                        <!-- Kode Barang -->
                        <div>
                            <x-input-label for="kode_barang" :value="__('Kode Barang (Unique)')" />
                            <x-text-input id="kode_barang" class="block mt-1 w-full" type="text" name="kode_barang" :value="old('kode_barang')" required placeholder="Contoh: BRG-001" />
                            <x-input-error :messages="$errors->get('kode_barang')" class="mt-2" />
                        </div>

                        <!-- Inisial Barang -->
                        <div>
                            <x-input-label for="inisial_barang" :value="__('Inisial (Singkatan)')" />
                            <x-text-input id="inisial_barang" class="block mt-1 w-full" type="text" name="inisial_barang" :value="old('inisial_barang')" placeholder="Contoh: KI" />
                            <x-input-error :messages="$errors->get('inisial_barang')" class="mt-2" />
                        </div>

                        <!-- Stok Awal -->
                        <div>
                            <x-input-label for="stok_awal" :value="__('Stok Awal (Saldo Awal)')" />
                            <x-text-input id="stok_awal" class="block mt-1 w-full" type="number" name="stok_awal" :value="old('stok_awal', 0)" required min="0" />
                            <p class="text-xs text-gray-500 mt-1">Stok saat ini akan diset sama dengan stok awal.</p>
                            <x-input-error :messages="$errors->get('stok_awal')" class="mt-2" />
                        </div>

                        <!-- Buffer Stok -->
                        <div>
                            <x-input-label for="buffer_stok" :value="__('Buffer Stok (Batas Minimal)')" />
                            <x-text-input id="buffer_stok" class="block mt-1 w-full" type="number" name="buffer_stok" :value="old('buffer_stok', 5)" required min="0" />
                            <p class="text-xs text-gray-500 mt-1">Peringatan akan muncul jika stok di bawah jumlah ini.</p>
                            <x-input-error :messages="$errors->get('buffer_stok')" class="mt-2" />
                        </div>

                        <!-- Status Aktif -->
                        <div class="flex items-center mt-4">
                            <input id="is_tersedia" type="checkbox" name="is_tersedia" value="1" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500" {{ old('is_tersedia', true) ? 'checked' : '' }}>
                            <label for="is_tersedia" class="ml-2 block text-sm text-gray-900">Barang Aktif / Tersedia</label>
                        </div>

                        <!-- Keterangan -->
                        <div class="md:col-span-2">
                            <x-input-label for="keterangan" :value="__('Keterangan Tambahan')" />
                            <textarea id="keterangan" name="keterangan" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" rows="2">{{ old('keterangan') }}</textarea>
                            <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('inventory.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            {{ __('Batal') }}
                        </a>
                        <x-primary-button class="ml-4 bg-emerald-600 hover:bg-emerald-700">
                            {{ __('Simpan Barang') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
