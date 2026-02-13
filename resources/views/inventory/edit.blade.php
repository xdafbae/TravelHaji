<x-app-layout>
    <x-slot name="header">
        Edit Barang: {{ $item->nama_barang }}
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('inventory.update', $item->id_stok) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Barang -->
                        <div class="md:col-span-2">
                            <x-input-label for="nama_barang" :value="__('Nama Barang')" />
                            <x-text-input id="nama_barang" class="block mt-1 w-full" type="text" name="nama_barang" :value="old('nama_barang', $item->nama_barang)" required autofocus />
                            <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                        </div>

                        <!-- Kode Barang -->
                        <div>
                            <x-input-label for="kode_barang" :value="__('Kode Barang (Unique)')" />
                            <x-text-input id="kode_barang" class="block mt-1 w-full" type="text" name="kode_barang" :value="old('kode_barang', $item->kode_barang)" required />
                            <x-input-error :messages="$errors->get('kode_barang')" class="mt-2" />
                        </div>

                        <!-- Inisial Barang -->
                        <div>
                            <x-input-label for="inisial_barang" :value="__('Inisial (Singkatan)')" />
                            <x-text-input id="inisial_barang" class="block mt-1 w-full" type="text" name="inisial_barang" :value="old('inisial_barang', $item->inisial_barang)" />
                            <x-input-error :messages="$errors->get('inisial_barang')" class="mt-2" />
                        </div>

                        <!-- Buffer Stok -->
                        <div>
                            <x-input-label for="buffer_stok" :value="__('Buffer Stok (Batas Minimal)')" />
                            <x-text-input id="buffer_stok" class="block mt-1 w-full" type="number" name="buffer_stok" :value="old('buffer_stok', $item->buffer_stok)" required min="0" />
                            <x-input-error :messages="$errors->get('buffer_stok')" class="mt-2" />
                        </div>

                        <!-- Status Aktif -->
                        <div class="flex items-center mt-8">
                            <input id="is_tersedia" type="checkbox" name="is_tersedia" value="1" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500" {{ old('is_tersedia', $item->is_tersedia) ? 'checked' : '' }}>
                            <label for="is_tersedia" class="ml-2 block text-sm text-gray-900">Barang Aktif / Tersedia</label>
                        </div>

                        <!-- Info Stok (Read Only) -->
                        <div class="bg-gray-50 p-4 rounded-md md:col-span-2">
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Informasi Stok</h4>
                            <div class="grid grid-cols-3 gap-4 text-center">
                                <div>
                                    <span class="block text-xs text-gray-500">Stok Awal</span>
                                    <span class="text-lg font-mono">{{ $item->stok_awal }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Stok Keluar</span>
                                    <span class="text-lg font-mono">{{ $item->stok_keluar }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Stok Tersedia</span>
                                    <span class="text-lg font-mono font-bold text-emerald-600">{{ $item->stok_tersedia }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="md:col-span-2">
                            <x-input-label for="keterangan" :value="__('Keterangan Tambahan')" />
                            <textarea id="keterangan" name="keterangan" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" rows="2">{{ old('keterangan', $item->keterangan) }}</textarea>
                            <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('inventory.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            {{ __('Batal') }}
                        </a>
                        <x-primary-button class="ml-4 bg-emerald-600 hover:bg-emerald-700">
                            {{ __('Update Barang') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
