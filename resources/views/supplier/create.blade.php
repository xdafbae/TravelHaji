<x-app-layout>
    <x-slot name="header">
        Tambah Supplier Baru
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('supplier.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Supplier -->
                        <div class="md:col-span-2">
                            <x-input-label for="nama_supplier" :value="__('Nama Supplier / Perusahaan')" />
                            <x-text-input id="nama_supplier" class="block mt-1 w-full" type="text" name="nama_supplier" :value="old('nama_supplier')" required autofocus />
                            <x-input-error :messages="$errors->get('nama_supplier')" class="mt-2" />
                        </div>

                        <!-- Kategori -->
                        <div>
                            <x-input-label for="kategori" :value="__('Kategori Supplier')" />
                            <select id="kategori" name="kategori" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Perlengkapan" {{ old('kategori') == 'Perlengkapan' ? 'selected' : '' }}>Perlengkapan (Kain, Batik, dll)</option>
                                <option value="Koper & Tas" {{ old('kategori') == 'Koper & Tas' ? 'selected' : '' }}>Koper & Tas</option>
                                <option value="Akomodasi" {{ old('kategori') == 'Akomodasi' ? 'selected' : '' }}>Akomodasi (Hotel)</option>
                                <option value="Transportasi" {{ old('kategori') == 'Transportasi' ? 'selected' : '' }}>Transportasi (Bus, Pesawat)</option>
                                <option value="Catering" {{ old('kategori') == 'Catering' ? 'selected' : '' }}>Catering</option>
                                <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                        </div>

                        <!-- Kontak -->
                        <div>
                            <x-input-label for="kontak" :value="__('No. Telepon / HP')" />
                            <x-text-input id="kontak" class="block mt-1 w-full" type="text" name="kontak" :value="old('kontak')" />
                            <x-input-error :messages="$errors->get('kontak')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email (Opsional)')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Status Aktif -->
                        <div class="flex items-center mt-4">
                            <input id="is_active" type="checkbox" name="is_active" value="1" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">Supplier Aktif</label>
                        </div>

                        <!-- Alamat -->
                        <div class="md:col-span-2">
                            <x-input-label for="alamat" :value="__('Alamat Lengkap')" />
                            <textarea id="alamat" name="alamat" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" rows="3">{{ old('alamat') }}</textarea>
                            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                        </div>

                        <!-- Keterangan -->
                        <div class="md:col-span-2">
                            <x-input-label for="keterangan" :value="__('Keterangan Tambahan')" />
                            <textarea id="keterangan" name="keterangan" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" rows="2">{{ old('keterangan') }}</textarea>
                            <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('supplier.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            {{ __('Batal') }}
                        </a>
                        <x-primary-button class="ml-4 bg-emerald-600 hover:bg-emerald-700">
                            {{ __('Simpan Supplier') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
