<x-app-layout>
    <x-slot name="header">
        Tambah Jadwal Keberangkatan
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('embarkasi.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Paket -->
                        <div>
                            <x-input-label for="paket_haji_umroh" :value="__('Nama Paket')" />
                            <select id="paket_haji_umroh" name="paket_haji_umroh" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm block mt-1 w-full" required onchange="updatePrice(this)">
                                <option value="">-- Pilih Paket --</option>
                                @foreach($priceLists as $pl)
                                    <option value="{{ $pl->nama_item }}" data-harga="{{ $pl->harga }}" {{ old('paket_haji_umroh') == $pl->nama_item ? 'selected' : '' }}>
                                        {{ $pl->nama_item }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('paket_haji_umroh')" class="mt-2" />
                        </div>

                        <!-- Kota Keberangkatan -->
                        <div>
                            <x-input-label for="kota_keberangkatan" :value="__('Kota Keberangkatan')" />
                            <x-text-input id="kota_keberangkatan" class="block mt-1 w-full" type="text" name="kota_keberangkatan" :value="old('kota_keberangkatan')" required placeholder="Contoh: Jakarta (CGK)" />
                            <x-input-error :messages="$errors->get('kota_keberangkatan')" class="mt-2" />
                        </div>

                        <!-- Waktu Keberangkatan -->
                        <div>
                            <x-input-label for="waktu_keberangkatan" :value="__('Waktu Keberangkatan')" />
                            <x-text-input id="waktu_keberangkatan" class="block mt-1 w-full" type="datetime-local" name="waktu_keberangkatan" :value="old('waktu_keberangkatan')" required />
                            <x-input-error :messages="$errors->get('waktu_keberangkatan')" class="mt-2" />
                        </div>

                        <!-- Waktu Kepulangan -->
                        <div>
                            <x-input-label for="waktu_kepulangan" :value="__('Waktu Kepulangan')" />
                            <x-text-input id="waktu_kepulangan" class="block mt-1 w-full" type="datetime-local" name="waktu_kepulangan" :value="old('waktu_kepulangan')" />
                            <x-input-error :messages="$errors->get('waktu_kepulangan')" class="mt-2" />
                        </div>

                        <!-- Maskapai -->
                        <div>
                            <x-input-label for="maskapai" :value="__('Maskapai')" />
                            <x-text-input id="maskapai" class="block mt-1 w-full" type="text" name="maskapai" :value="old('maskapai')" placeholder="Contoh: Garuda Indonesia" />
                            <x-input-error :messages="$errors->get('maskapai')" class="mt-2" />
                        </div>

                        <!-- Harga Paket -->
                        <div>
                            <x-input-label for="harga_paket" :value="__('Harga Paket (Rp)')" />
                            <x-text-input id="harga_paket" class="block mt-1 w-full" type="number" name="harga_paket" :value="old('harga_paket')" required min="0" placeholder="0" />
                            <x-input-error :messages="$errors->get('harga_paket')" class="mt-2" />
                        </div>

                        <!-- Kapasitas -->
                        <div>
                            <x-input-label for="kapasitas_jamaah" :value="__('Kapasitas Jamaah')" />
                            <x-text-input id="kapasitas_jamaah" class="block mt-1 w-full" type="number" name="kapasitas_jamaah" :value="old('kapasitas_jamaah', 45)" required min="1" />
                            <x-input-error :messages="$errors->get('kapasitas_jamaah')" class="mt-2" />
                        </div>

                        <!-- Tour Leader -->
                        <div>
                            <x-input-label for="id_tour_leader" :value="__('Tour Leader')" />
                            <select id="id_tour_leader" name="id_tour_leader" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="">-- Pilih Tour Leader --</option>
                                @foreach($tourLeaders as $tl)
                                    <option value="{{ $tl->id_pegawai }}" {{ old('id_tour_leader') == $tl->id_pegawai ? 'selected' : '' }}>
                                        {{ $tl->nama_pegawai }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_tour_leader')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="Belum Berangkat" {{ old('status') == 'Belum Berangkat' ? 'selected' : '' }}>Belum Berangkat</option>
                                <option value="Sudah Berangkat" {{ old('status') == 'Sudah Berangkat' ? 'selected' : '' }}>Sudah Berangkat</option>
                                <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                    </div>
                    
                    <div class="mt-4 border-t pt-4">
                        <h3 class="text-md font-medium text-gray-700 mb-2">Informasi Penerbangan (Opsional)</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Pesawat Pergi -->
                            <div>
                                <x-input-label for="pesawat_pergi" :value="__('Nomor Penerbangan Pergi')" />
                                <x-text-input id="pesawat_pergi" class="block mt-1 w-full" type="text" name="pesawat_pergi" :value="old('pesawat_pergi')" placeholder="Contoh: GA-980" />
                                <x-input-error :messages="$errors->get('pesawat_pergi')" class="mt-2" />
                            </div>

                            <!-- Pesawat Pulang -->
                            <div>
                                <x-input-label for="pesawat_pulang" :value="__('Nomor Penerbangan Pulang')" />
                                <x-text-input id="pesawat_pulang" class="block mt-1 w-full" type="text" name="pesawat_pulang" :value="old('pesawat_pulang')" placeholder="Contoh: GA-981" />
                                <x-input-error :messages="$errors->get('pesawat_pulang')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('embarkasi.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            {{ __('Batal') }}
                        </a>
                        <x-primary-button class="ml-4 bg-emerald-600 hover:bg-emerald-700">
                            {{ __('Simpan Jadwal') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updatePrice(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const harga = selectedOption.getAttribute('data-harga');
            const hargaInput = document.getElementById('harga_paket');
            
            if (harga) {
                hargaInput.value = harga;
            } else {
                hargaInput.value = '';
            }
        }
    </script>
</x-app-layout>
