<x-app-layout>
    <x-slot name="header">
        <!-- Not used in this theme -->
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h2 class="text-3xl font-extrabold text-secondary-900 tracking-tight">
                    Tambah Jadwal
                </h2>
                <p class="text-sm text-secondary-500 mt-1 font-medium">Buat jadwal keberangkatan baru untuk jamaah</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('embarkasi.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-secondary-300 rounded-lg font-semibold text-xs text-secondary-700 uppercase tracking-widest shadow-sm hover:bg-secondary-50 hover:text-primary-600 focus:outline-none transition ease-in-out duration-150">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
                </a>
            </div>
        </div>

        <form action="{{ route('embarkasi.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Main Info -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Section 1: Informasi Paket -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-secondary-100">
                        <div class="px-6 py-4 border-b border-secondary-100 bg-secondary-50/50 flex items-center">
                            <div class="w-10 h-10 rounded-xl bg-primary-100 text-primary-600 flex items-center justify-center mr-4 shadow-sm">
                                <i class="fas fa-box-open text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-secondary-900">Informasi Paket</h3>
                                <p class="text-xs text-secondary-500">Detail paket haji/umroh yang dipilih</p>
                            </div>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Paket -->
                            <div class="col-span-2">
                                <x-input-label for="paket_haji_umroh" :value="__('Nama Paket')" class="mb-1 block font-bold text-secondary-700" />
                                <select id="paket_haji_umroh" name="paket_haji_umroh" class="tom-select block w-full text-sm rounded-xl border-secondary-300 focus:border-primary-500 focus:ring-primary-500" required placeholder="Pilih Paket..." onchange="updatePrice(this)">
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
                                <x-input-label for="kota_keberangkatan" :value="__('Kota Keberangkatan')" class="mb-1 block font-bold text-secondary-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-map-marker-alt text-secondary-400"></i>
                                    </div>
                                    <input id="kota_keberangkatan" class="block w-full pl-10 text-sm rounded-xl border-secondary-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm" type="text" name="kota_keberangkatan" value="{{ old('kota_keberangkatan') }}" required placeholder="Contoh: Jakarta (CGK)" />
                                </div>
                                <x-input-error :messages="$errors->get('kota_keberangkatan')" class="mt-2" />
                            </div>

                            <!-- Kapasitas -->
                            <div>
                                <x-input-label for="kapasitas_jamaah" :value="__('Kapasitas Jamaah')" class="mb-1 block font-bold text-secondary-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-users text-secondary-400"></i>
                                    </div>
                                    <input id="kapasitas_jamaah" class="block w-full pl-10 text-sm rounded-xl border-secondary-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm" type="number" name="kapasitas_jamaah" value="{{ old('kapasitas_jamaah', 45) }}" required min="1" />
                                </div>
                                <x-input-error :messages="$errors->get('kapasitas_jamaah')" class="mt-2" />
                            </div>

                            <!-- Harga Paket -->
                            <div class="col-span-2">
                                <x-input-label for="harga_paket_display" :value="__('Harga Paket')" class="mb-1 block font-bold text-secondary-700" />
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-primary-600 font-bold text-sm">Rp</span>
                                    </div>
                                    <!-- Input Dummy untuk Tampilan Rupiah -->
                                    <input type="text" id="harga_paket_display" class="block w-full pl-10 text-sm font-mono font-bold text-secondary-900 rounded-xl border-secondary-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm transition-colors bg-secondary-50 focus:bg-white" placeholder="0" oninput="formatRupiah(this)" />
                                    <!-- Input Hidden untuk Nilai Asli ke Backend -->
                                    <input type="hidden" id="harga_paket" name="harga_paket" value="{{ old('harga_paket') }}">
                                </div>
                                <x-input-error :messages="$errors->get('harga_paket')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Jadwal & Penerbangan -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-secondary-100">
                        <div class="px-6 py-4 border-b border-secondary-100 bg-secondary-50/50 flex items-center">
                            <div class="w-10 h-10 rounded-xl bg-info-100 text-info-600 flex items-center justify-center mr-4 shadow-sm">
                                <i class="fas fa-plane text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-secondary-900">Jadwal & Penerbangan</h3>
                                <p class="text-xs text-secondary-500">Waktu keberangkatan dan detail penerbangan</p>
                            </div>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                             <!-- Waktu Keberangkatan -->
                            <div>
                                <x-input-label for="waktu_keberangkatan" :value="__('Waktu Keberangkatan')" class="mb-1 block font-bold text-secondary-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-alt text-secondary-400"></i>
                                    </div>
                                    <input id="waktu_keberangkatan" class="flatpickr block w-full pl-10 border-secondary-300 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm text-sm" type="text" name="waktu_keberangkatan" value="{{ old('waktu_keberangkatan') }}" required placeholder="Pilih tanggal..." />
                                </div>
                                <x-input-error :messages="$errors->get('waktu_keberangkatan')" class="mt-2" />
                            </div>

                            <!-- Waktu Kepulangan -->
                            <div>
                                <x-input-label for="waktu_kepulangan" :value="__('Waktu Kepulangan')" class="mb-1 block font-bold text-secondary-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-check text-secondary-400"></i>
                                    </div>
                                    <input id="waktu_kepulangan" class="flatpickr block w-full pl-10 border-secondary-300 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm text-sm" type="text" name="waktu_kepulangan" value="{{ old('waktu_kepulangan') }}" placeholder="Pilih tanggal..." />
                                </div>
                                <x-input-error :messages="$errors->get('waktu_kepulangan')" class="mt-2" />
                            </div>

                             <!-- Maskapai -->
                            <div class="col-span-2">
                                <x-input-label for="maskapai" :value="__('Maskapai')" class="mb-1 block font-bold text-secondary-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-plane-tail text-secondary-400"></i>
                                    </div>
                                    <input id="maskapai" class="block w-full pl-10 text-sm rounded-xl border-secondary-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm" type="text" name="maskapai" value="{{ old('maskapai') }}" placeholder="Contoh: Garuda Indonesia" />
                                </div>
                                <x-input-error :messages="$errors->get('maskapai')" class="mt-2" />
                            </div>

                             <!-- Pesawat Pergi -->
                            <div>
                                <x-input-label for="pesawat_pergi" :value="__('No. Penerbangan Pergi')" class="mb-1 block font-bold text-secondary-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-plane-departure text-secondary-400"></i>
                                    </div>
                                    <input id="pesawat_pergi" class="block w-full pl-10 text-sm rounded-xl border-secondary-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm" type="text" name="pesawat_pergi" value="{{ old('pesawat_pergi') }}" placeholder="Contoh: GA-980" />
                                </div>
                                <x-input-error :messages="$errors->get('pesawat_pergi')" class="mt-2" />
                            </div>

                            <!-- Pesawat Pulang -->
                            <div>
                                <x-input-label for="pesawat_pulang" :value="__('No. Penerbangan Pulang')" class="mb-1 block font-bold text-secondary-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-plane-arrival text-secondary-400"></i>
                                    </div>
                                    <input id="pesawat_pulang" class="block w-full pl-10 text-sm rounded-xl border-secondary-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm" type="text" name="pesawat_pulang" value="{{ old('pesawat_pulang') }}" placeholder="Contoh: GA-981" />
                                </div>
                                <x-input-error :messages="$errors->get('pesawat_pulang')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Status & TL -->
                <div class="lg:col-span-1 space-y-8">
                     <!-- Section 3: Pengaturan -->
                    <div class="bg-white shadow-sm rounded-2xl border border-secondary-100 relative z-20">
                        <div class="px-6 py-4 border-b border-secondary-100 bg-secondary-50/50 flex items-center rounded-t-2xl">
                            <div class="w-10 h-10 rounded-xl bg-warning-100 text-warning-600 flex items-center justify-center mr-4 shadow-sm">
                                <i class="fas fa-cog text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-secondary-900">Pengaturan</h3>
                                <p class="text-xs text-secondary-500">Status & Tour Leader</p>
                            </div>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('Status Keberangkatan')" class="mb-1 block font-bold text-secondary-700" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-info-circle text-secondary-400"></i>
                                    </div>
                                    <select id="status" name="status" class="border-secondary-300 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm block w-full pl-10 text-sm">
                                        <option value="Belum Berangkat" {{ old('status') == 'Belum Berangkat' ? 'selected' : '' }}>Belum Berangkat</option>
                                        <option value="Sudah Berangkat" {{ old('status') == 'Sudah Berangkat' ? 'selected' : '' }}>Sudah Berangkat</option>
                                        <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <!-- Tour Leader -->
                            <div>
                                <x-input-label for="id_tour_leader" :value="__('Tour Leader')" class="mb-1 block font-bold text-secondary-700" />
                                <div class="relative z-50">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                        <i class="fas fa-user-tie text-secondary-400"></i>
                                    </div>
                                    <select id="id_tour_leader" name="id_tour_leader" class="tom-select block w-full pl-10 text-sm rounded-xl border-secondary-300 focus:border-primary-500 focus:ring-primary-500" placeholder="Pilih Tour Leader...">
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
                        <div class="bg-white shadow-lg rounded-2xl p-6 border border-secondary-100 relative">
                            <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all transform hover:-translate-y-0.5 mb-3">
                                <i class="fas fa-save mr-2"></i> Simpan Jadwal
                            </button>
                            <a href="{{ route('embarkasi.index') }}" class="w-full flex justify-center items-center py-3 px-4 border border-secondary-300 rounded-xl shadow-sm text-sm font-bold text-secondary-700 bg-white hover:bg-secondary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-200 transition-all">
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
                    hargaDisplay.classList.add('bg-primary-50', 'text-primary-700', 'border-primary-500');
                    setTimeout(() => {
                        hargaDisplay.classList.remove('bg-primary-50', 'text-primary-700', 'border-primary-500');
                    }, 500);
                }
            }
        }
    </script>
</x-app-layout>