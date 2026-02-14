<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-800 flex items-center">
            <span class="w-2 h-8 bg-emerald-500 rounded-r-md mr-3"></span>
            {{ __('Tambah Jadwal Keberangkatan') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('embarkasi.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Main Info -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Section 1: Informasi Paket -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center">
                            <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center mr-3">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Informasi Paket</h3>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Paket -->
                            <div class="col-span-2">
                                <x-input-label for="paket_haji_umroh" :value="__('Nama Paket')" class="mb-1 block font-semibold text-gray-700" />
                                <select id="paket_haji_umroh" name="paket_haji_umroh" class="tom-select block w-full text-sm rounded-xl" required placeholder="Pilih Paket..." onchange="updatePrice(this)">
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
                                <x-input-label for="kota_keberangkatan" :value="__('Kota Keberangkatan')" class="mb-1 block font-semibold text-gray-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                                    </div>
                                    <x-text-input id="kota_keberangkatan" class="block w-full pl-10 text-sm rounded-xl" type="text" name="kota_keberangkatan" :value="old('kota_keberangkatan')" required placeholder="Contoh: Jakarta (CGK)" />
                                </div>
                                <x-input-error :messages="$errors->get('kota_keberangkatan')" class="mt-2" />
                            </div>

                            <!-- Kapasitas -->
                            <div>
                                <x-input-label for="kapasitas_jamaah" :value="__('Kapasitas Jamaah')" class="mb-1 block font-semibold text-gray-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-users text-gray-400"></i>
                                    </div>
                                    <x-text-input id="kapasitas_jamaah" class="block w-full pl-10 text-sm rounded-xl" type="number" name="kapasitas_jamaah" :value="old('kapasitas_jamaah', 45)" required min="1" />
                                </div>
                                <x-input-error :messages="$errors->get('kapasitas_jamaah')" class="mt-2" />
                            </div>

                            <!-- Harga Paket -->
                            <div class="col-span-2">
                                <x-input-label for="harga_paket_display" :value="__('Harga Paket')" class="mb-1 block font-semibold text-gray-700" />
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-emerald-600 font-bold text-sm">Rp</span>
                                    </div>
                                    <!-- Input Dummy untuk Tampilan Rupiah -->
                                    <input type="text" id="harga_paket_display" class="block w-full pl-10 text-sm font-mono font-bold text-gray-800 rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition-colors" placeholder="0" oninput="formatRupiah(this)" />
                                    <!-- Input Hidden untuk Nilai Asli ke Backend -->
                                    <input type="hidden" id="harga_paket" name="harga_paket" value="{{ old('harga_paket') }}">
                                </div>
                                <x-input-error :messages="$errors->get('harga_paket')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Jadwal & Penerbangan -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                                <i class="fas fa-plane"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Jadwal & Penerbangan</h3>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                             <!-- Waktu Keberangkatan -->
                            <div>
                                <x-input-label for="waktu_keberangkatan" :value="__('Waktu Keberangkatan')" class="mb-1 block font-semibold text-gray-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-alt text-gray-400"></i>
                                    </div>
                                    <input id="waktu_keberangkatan" class="flatpickr block w-full pl-10 border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm" type="text" name="waktu_keberangkatan" value="{{ old('waktu_keberangkatan') }}" required placeholder="Pilih tanggal..." />
                                </div>
                                <x-input-error :messages="$errors->get('waktu_keberangkatan')" class="mt-2" />
                            </div>

                            <!-- Waktu Kepulangan -->
                            <div>
                                <x-input-label for="waktu_kepulangan" :value="__('Waktu Kepulangan')" class="mb-1 block font-semibold text-gray-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-check text-gray-400"></i>
                                    </div>
                                    <input id="waktu_kepulangan" class="flatpickr block w-full pl-10 border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm" type="text" name="waktu_kepulangan" value="{{ old('waktu_kepulangan') }}" placeholder="Pilih tanggal..." />
                                </div>
                                <x-input-error :messages="$errors->get('waktu_kepulangan')" class="mt-2" />
                            </div>

                             <!-- Maskapai -->
                            <div class="col-span-2">
                                <x-input-label for="maskapai" :value="__('Maskapai')" class="mb-1 block font-semibold text-gray-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-plane-tail text-gray-400"></i>
                                    </div>
                                    <x-text-input id="maskapai" class="block w-full pl-10 text-sm rounded-xl" type="text" name="maskapai" :value="old('maskapai')" placeholder="Contoh: Garuda Indonesia" />
                                </div>
                                <x-input-error :messages="$errors->get('maskapai')" class="mt-2" />
                            </div>

                             <!-- Pesawat Pergi -->
                            <div>
                                <x-input-label for="pesawat_pergi" :value="__('No. Penerbangan Pergi')" class="mb-1 block font-semibold text-gray-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-plane-departure text-gray-400"></i>
                                    </div>
                                    <x-text-input id="pesawat_pergi" class="block w-full pl-10 text-sm rounded-xl" type="text" name="pesawat_pergi" :value="old('pesawat_pergi')" placeholder="Contoh: GA-980" />
                                </div>
                                <x-input-error :messages="$errors->get('pesawat_pergi')" class="mt-2" />
                            </div>

                            <!-- Pesawat Pulang -->
                            <div>
                                <x-input-label for="pesawat_pulang" :value="__('No. Penerbangan Pulang')" class="mb-1 block font-semibold text-gray-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-plane-arrival text-gray-400"></i>
                                    </div>
                                    <x-text-input id="pesawat_pulang" class="block w-full pl-10 text-sm rounded-xl" type="text" name="pesawat_pulang" :value="old('pesawat_pulang')" placeholder="Contoh: GA-981" />
                                </div>
                                <x-input-error :messages="$errors->get('pesawat_pulang')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Status & TL -->
                <div class="lg:col-span-1 space-y-8">
                     <!-- Section 3: Pengaturan -->
                    <div class="bg-white shadow-sm rounded-2xl border border-gray-100 relative z-20">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center rounded-t-2xl">
                            <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center mr-3">
                                <i class="fas fa-cog"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Pengaturan</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('Status Keberangkatan')" class="mb-1 block font-semibold text-gray-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-info-circle text-gray-400"></i>
                                    </div>
                                    <select id="status" name="status" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm block w-full pl-10 text-sm">
                                        <option value="Belum Berangkat" {{ old('status') == 'Belum Berangkat' ? 'selected' : '' }}>Belum Berangkat</option>
                                        <option value="Sudah Berangkat" {{ old('status') == 'Sudah Berangkat' ? 'selected' : '' }}>Sudah Berangkat</option>
                                        <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <!-- Tour Leader -->
                            <div>
                                <x-input-label for="id_tour_leader" :value="__('Tour Leader')" class="mb-1 block font-semibold text-gray-700" />
                                <div class="relative z-50">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                        <i class="fas fa-user-tie text-gray-400"></i>
                                    </div>
                                    <select id="id_tour_leader" name="id_tour_leader" class="tom-select block w-full pl-10 text-sm rounded-xl" placeholder="Pilih Tour Leader...">
                                        <option value="">-- Pilih Tour Leader --</option>
                                        @foreach($tourLeaders as $tl)
                                            <option value="{{ $tl->id_pegawai }}" {{ old('id_tour_leader') == $tl->id_pegawai ? 'selected' : '' }}>
                                                {{ $tl->nama_pegawai }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('id_tour_leader')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Sticky Action Buttons -->
                    <div class="sticky top-6 z-10">
                        <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-100 relative">
                            <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all transform hover:-translate-y-0.5 mb-3">
                                <i class="fas fa-save mr-2"></i> Simpan Jadwal
                            </button>
                            <a href="{{ route('embarkasi.index') }}" class="w-full flex justify-center items-center py-3 px-4 border border-gray-300 rounded-xl shadow-sm text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-all">
                                <i class="fas fa-times mr-2"></i> Batal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Init Flatpickr
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr(".flatpickr", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
                allowInput: true
            });

            // Init TomSelect
            document.querySelectorAll('.tom-select').forEach((el) => {
                new TomSelect(el, {
                    create: false,
                    sortField: {
                        field: "text",
                        direction: "asc"
                    }
                });
            });

            // Init Harga Display (Jika ada old value saat error)
            const hargaInput = document.getElementById('harga_paket');
            const hargaDisplay = document.getElementById('harga_paket_display');
            if(hargaInput.value) {
                hargaDisplay.value = new Intl.NumberFormat('id-ID').format(hargaInput.value);
            }
        });

        function formatRupiah(input) {
            // Hapus karakter non-digit
            let value = input.value.replace(/\D/g, '');
            
            // Simpan nilai asli ke hidden input
            document.getElementById('harga_paket').value = value;
            
            // Format tampilan ke Rupiah
            if(value) {
                input.value = new Intl.NumberFormat('id-ID').format(value);
            } else {
                input.value = '';
            }
        }

        function updatePrice(selectElement) {
            // Need to get the option element itself because TomSelect hides the original select
            // But TomSelect updates the original select value. 
            // However, getting data-attributes from TomSelect instance is different.
            // Simplest way: Loop through original options to find matching value
            
            const value = selectElement.value;
            if(!value) return;

            const originalOption = Array.from(selectElement.options).find(opt => opt.value === value);
            if(originalOption) {
                const harga = originalOption.getAttribute('data-harga');
                const hargaInput = document.getElementById('harga_paket');
                const hargaDisplay = document.getElementById('harga_paket_display');
                
                if (harga) {
                    hargaInput.value = harga;
                    hargaDisplay.value = new Intl.NumberFormat('id-ID').format(harga);
                    
                    // Animasi flash
                    hargaDisplay.classList.add('bg-emerald-50', 'text-emerald-700', 'border-emerald-500');
                    setTimeout(() => {
                        hargaDisplay.classList.remove('bg-emerald-50', 'text-emerald-700', 'border-emerald-500');
                    }, 500);
                }
            }
        }
    </script>
</x-app-layout>