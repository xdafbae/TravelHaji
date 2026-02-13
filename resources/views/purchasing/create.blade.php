<x-app-layout>
    <x-slot name="header">
        Buat Purchase Order Baru
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('purchasing.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Supplier -->
                        <div>
                            <x-input-label for="id_supplier" :value="__('Supplier')" />
                            <select id="id_supplier" name="id_supplier" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">-- Pilih Supplier --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id_supplier }}" {{ old('id_supplier') == $supplier->id_supplier ? 'selected' : '' }}>
                                        {{ $supplier->nama_supplier }} ({{ $supplier->kategori }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_supplier')" class="mt-2" />
                        </div>

                        <!-- Tanggal Preorder -->
                        <div>
                            <x-input-label for="waktu_preorder" :value="__('Tanggal PO')" />
                            <x-text-input id="waktu_preorder" class="block mt-1 w-full" type="date" name="waktu_preorder" :value="old('waktu_preorder', date('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('waktu_preorder')" class="mt-2" />
                        </div>

                        <!-- Keterangan -->
                        <div class="md:col-span-2">
                            <x-input-label for="keterangan" :value="__('Keterangan / Catatan')" />
                            <textarea id="keterangan" name="keterangan" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" rows="3">{{ old('keterangan') }}</textarea>
                            <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('purchasing.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            {{ __('Batal') }}
                        </a>
                        <x-primary-button class="ml-4 bg-emerald-600 hover:bg-emerald-700">
                            {{ __('Buat PO & Lanjut ke Item') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
