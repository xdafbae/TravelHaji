<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Supplier') }}: {{ $supplier->nama_supplier }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 bg-white border-b border-gray-200">
                    <form action="{{ route('supplier.update', $supplier->id_supplier) }}" method="POST" x-data="{ submitting: false }" @submit="submitting = true">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <!-- Nama Supplier -->
                                <div>
                                    <x-input-label for="nama_supplier" :value="__('Nama Supplier / Perusahaan')" />
                                    <x-text-input id="nama_supplier" class="block mt-1 w-full" type="text" name="nama_supplier" :value="old('nama_supplier', $supplier->nama_supplier)" required autofocus />
                                    <x-input-error :messages="$errors->get('nama_supplier')" class="mt-2" />
                                </div>

                                <!-- Kategori -->
                                <div>
                                    <x-input-label for="kategori" :value="__('Kategori Supplier')" />
                                    <select id="kategori" name="kategori" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm block mt-1 w-full">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach(['Perlengkapan', 'Koper & Tas', 'Akomodasi', 'Transportasi', 'Catering', 'Lainnya'] as $cat)
                                            <option value="{{ $cat }}" {{ old('kategori', $supplier->kategori) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                                </div>

                                <!-- Status Aktif -->
                                <div class="flex items-center pt-2">
                                    <input id="is_active" type="checkbox" name="is_active" value="1" class="w-5 h-5 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500" {{ old('is_active', $supplier->is_active) ? 'checked' : '' }}>
                                    <div class="ml-3 text-sm">
                                        <label for="is_active" class="font-medium text-gray-700">Supplier Aktif</label>
                                        <p class="text-gray-500">Supplier aktif dapat dipilih dalam transaksi pembelian.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                <!-- Kontak -->
                                <div>
                                    <x-input-label for="kontak" :value="__('No. Telepon / HP')" />
                                    <x-text-input id="kontak" class="block mt-1 w-full" type="text" name="kontak" :value="old('kontak', $supplier->kontak)" />
                                    <x-input-error :messages="$errors->get('kontak')" class="mt-2" />
                                </div>

                                <!-- Email -->
                                <div>
                                    <x-input-label for="email" :value="__('Email (Opsional)')" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $supplier->email)" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                            </div>
                            
                            <!-- Full Width -->
                            <div class="md:col-span-2 space-y-6">
                                <!-- Alamat -->
                                <div>
                                    <x-input-label for="alamat" :value="__('Alamat Lengkap')" />
                                    <textarea id="alamat" name="alamat" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" rows="3">{{ old('alamat', $supplier->alamat) }}</textarea>
                                    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                                </div>

                                <!-- Keterangan -->
                                <div>
                                    <x-input-label for="keterangan" :value="__('Keterangan Tambahan')" />
                                    <textarea id="keterangan" name="keterangan" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" rows="2">{{ old('keterangan', $supplier->keterangan) }}</textarea>
                                    <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-100">
                            <a href="{{ route('supplier.index') }}" class="text-gray-600 hover:text-gray-900 mr-4 text-sm font-medium transition-colors">
                                {{ __('Batal') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150" :disabled="submitting" :class="{ 'opacity-75 cursor-not-allowed': submitting }">
                                <span x-show="submitting" class="mr-2" style="display: none;">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </span>
                                <span x-text="submitting ? 'Menyimpan...' : 'Update Supplier'">Update Supplier</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>