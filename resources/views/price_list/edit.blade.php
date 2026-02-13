<x-app-layout>
    <x-slot name="header">
        Edit Item Price List
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('price-list.update', $priceList->id_pricelist) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Item -->
                        <div class="md:col-span-2">
                            <x-input-label for="nama_item" :value="__('Nama Item')" />
                            <x-text-input id="nama_item" class="block mt-1 w-full" type="text" name="nama_item" :value="old('nama_item', $priceList->nama_item)" required autofocus />
                            <x-input-error :messages="$errors->get('nama_item')" class="mt-2" />
                        </div>

                        <!-- Harga -->
                        <div>
                            <x-input-label for="harga" :value="__('Harga (Rp)')" />
                            <x-text-input id="harga" class="block mt-1 w-full" type="number" name="harga" :value="old('harga', $priceList->harga)" required min="0" />
                            <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                        </div>

                        <!-- Kode Item (Optional) -->
                        <div>
                            <x-input-label for="kode_item" :value="__('Kode Item')" />
                            <x-text-input id="kode_item" class="block mt-1 w-full" type="text" name="kode_item" :value="old('kode_item', $priceList->kode_item)" />
                            <x-input-error :messages="$errors->get('kode_item')" class="mt-2" />
                        </div>

                        <!-- Tanggal Berlaku -->
                        <div>
                            <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai Berlaku')" />
                            <x-text-input id="tanggal_mulai" class="block mt-1 w-full" type="date" name="tanggal_mulai" :value="old('tanggal_mulai', $priceList->tanggal_mulai ? $priceList->tanggal_mulai->format('Y-m-d') : '')" />
                            <x-input-error :messages="$errors->get('tanggal_mulai')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="tanggal_berakhir" :value="__('Tanggal Berakhir (Opsional)')" />
                            <x-text-input id="tanggal_berakhir" class="block mt-1 w-full" type="date" name="tanggal_berakhir" :value="old('tanggal_berakhir', $priceList->tanggal_berakhir ? $priceList->tanggal_berakhir->format('Y-m-d') : '')" />
                            <x-input-error :messages="$errors->get('tanggal_berakhir')" class="mt-2" />
                        </div>

                        <!-- Keterangan -->
                        <div class="md:col-span-2">
                            <x-input-label for="keterangan" :value="__('Keterangan')" />
                            <textarea id="keterangan" name="keterangan" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" rows="3">{{ old('keterangan', $priceList->keterangan) }}</textarea>
                            <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                        </div>
                        
                        <!-- Usage Flags -->
                        <div class="md:col-span-2">
                            <h3 class="text-sm font-medium text-gray-700 mb-3">Kategori Penggunaan (Form)</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" name="form_a" value="1" {{ old('form_a', $priceList->form_a) ? 'checked' : '' }}>
                                    <span class="ml-2 text-gray-600">Form A (Paket)</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" name="form_b" value="1" {{ old('form_b', $priceList->form_b) ? 'checked' : '' }}>
                                    <span class="ml-2 text-gray-600">Form B (Perlengkapan)</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" name="form_c" value="1" {{ old('form_c', $priceList->form_c) ? 'checked' : '' }}>
                                    <span class="ml-2 text-gray-600">Form C (Dokumen)</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" name="form_d" value="1" {{ old('form_d', $priceList->form_d) ? 'checked' : '' }}>
                                    <span class="ml-2 text-gray-600">Form D (Lain-lain)</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" name="form_d_barang" value="1" {{ old('form_d_barang', $priceList->form_d_barang) ? 'checked' : '' }}>
                                    <span class="ml-2 text-gray-600">Barang</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" name="form_d_jasa" value="1" {{ old('form_d_jasa', $priceList->form_d_jasa) ? 'checked' : '' }}>
                                    <span class="ml-2 text-gray-600">Jasa</span>
                                </label>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="md:col-span-2 mt-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" name="is_active" value="1" {{ old('is_active', $priceList->is_active) ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700 font-medium">Status Aktif</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('price-list.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            {{ __('Batal') }}
                        </a>
                        <x-primary-button class="ml-4 bg-emerald-600 hover:bg-emerald-700">
                            {{ __('Update Item') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
